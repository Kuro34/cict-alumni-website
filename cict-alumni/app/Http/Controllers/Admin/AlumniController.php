<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Point;
use App\Models\PointHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\PointsAdjusted;

class AlumniController extends Controller
{
    /** Show all alumni */
    public function index(Request $request)
    {
        $query = Alumni::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('degree_program', 'like', "%{$search}%")
                  ->orWhere('graduation_year', 'like', "%{$search}%");
            });
        }

        if ($request->filled('degree_program')) {
            $query->where('degree_program', $request->degree_program);
        }

        if ($request->filled('graduation_year')) {
            $query->where('graduation_year', $request->graduation_year);
        }

        if ($request->filled('sort_by') && in_array($request->sort_by, ['first_name','last_name','degree_program','graduation_year'])) {
            $sortOrder = $request->sort_order == 'desc' ? 'desc' : 'asc';
            $query->orderBy($request->sort_by, $sortOrder);
        } else {
            $query->orderBy('last_name');
        }

        $alumni = $query->paginate(10)->withQueryString();
        $degreePrograms = Alumni::select('degree_program')->distinct()->pluck('degree_program');
        $graduationYears = Alumni::select('graduation_year')->distinct()->pluck('graduation_year');

        return view('admin.alumni.index', compact('alumni', 'degreePrograms', 'graduationYears'));
    }

    /** Show individual alumni details */
    public function show($id)
    {
        $alumni = Alumni::findOrFail($id);

        // Get current points (from points table)
        $totalPoints = Point::where('alumniID', $alumni->alumniID)->value('total_points') ?? 0;

        // Get latest 10 adjustment history
        $pointHistory = PointHistory::where('alumniID', $alumni->alumniID)
                                    ->latest()
                                    ->take(10)
                                    ->get();

        return view('admin.alumni.show', compact('alumni', 'totalPoints', 'pointHistory'));
    }

    /** Adjust points, log history, send email */
    public function adjustPoints(Request $request, $id)
    {
        $request->validate([
            'points' => 'required|integer',
            'reason' => 'required|string|max:255',
        ]);

        $alumni = Alumni::findOrFail($id);

        // Get current points
        $currentPoints = Point::where('alumniID', $alumni->alumniID)->value('total_points') ?? 0;

        // Compute new total
        $newTotal = $currentPoints + $request->points;

        // Update or create the points record
        Point::updateOrCreate(
            ['alumniID' => $alumni->alumniID],
            ['total_points' => $newTotal]
        );

        // Log history (includes reason)
        PointHistory::create([
            'alumniID' => $alumni->alumniID,
            'points_changed' => $request->points,
            'reason' => $request->reason,
            'adminID' => auth('admin')->id(),
        ]);

        // Send notification email
        Mail::to($alumni->email)->send(new PointsAdjusted($alumni, $request->points, $request->reason, $newTotal));

        return redirect()->back()->with('success', 'Points updated and email sent successfully!');
    }

    /** Delete alumni */
    public function destroy($id)
    {
        $alumni = Alumni::findOrFail($id);
        $alumni->delete();

        return redirect()->route('admin.alumni.index')->with('success', 'Alumni deleted successfully.');
    }
}
