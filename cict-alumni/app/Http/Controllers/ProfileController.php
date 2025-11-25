<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function view(Request $request)
    {
        $alumni = $request->user();

        return view('alumni.profile', [
            'alumni' => $alumni,
            'isOwner' => true,
            'editMode' => false,
        ]);
    }

    public function edit(Request $request)
    {
        $alumni = $request->user();

        return view('alumni.profile', [
            'alumni' => $alumni,
            'isOwner' => true,
            'editMode' => true,
        ]);
    }

    public function update(Request $request)
    {
        $alumni = $request->user();

        $validated = $request->validate([
            'first_name'      => 'required|string|max:255',
            'middle_initial'  => 'nullable|string|max:2',
            'last_name'       => 'required|string|max:255',
            'gender'          => 'nullable|string|in:Male,Female,Other,Prefer not to say',
            'age'             => 'nullable|integer',
            'address'         => 'nullable|string|max:255',
            'phone_number'    => 'nullable|string|max:20',
            'current_job'     => 'nullable|string|max:255',
            'graduation_year' => 'nullable|integer',
            'degree_program'  => 'nullable|string|max:255',
            'email'           => 'required|email|max:255|unique:alumni,email,' . $alumni->alumniID . ',alumniID',
            'profile_picture' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
            'banner_picture'  => 'nullable|image|mimes:jpeg,jpg,png,gif|max:4096',
        ]);

        $alumni->fill($validated);

        // Profile picture
        if ($request->has('clear_profile_picture') && $request->clear_profile_picture == 1) {
            if ($alumni->profile_picture && Storage::disk('public')->exists($alumni->profile_picture)) {
                Storage::disk('public')->delete($alumni->profile_picture);
            }
            $alumni->profile_picture = null;
        } elseif ($request->hasFile('profile_picture')) {
            if ($alumni->profile_picture && Storage::disk('public')->exists($alumni->profile_picture)) {
                Storage::disk('public')->delete($alumni->profile_picture);
            }
            $alumni->profile_picture = $request->file('profile_picture')->store('profile_picture', 'public');
        }

        // Banner picture
        if ($request->has('clear_banner_picture') && $request->clear_banner_picture == 1) {
            if ($alumni->banner_picture && Storage::disk('public')->exists($alumni->banner_picture)) {
                Storage::disk('public')->delete($alumni->banner_picture);
            }
            $alumni->banner_picture = null;
        } elseif ($request->hasFile('banner_picture')) {
            if ($alumni->banner_picture && Storage::disk('public')->exists($alumni->banner_picture)) {
                Storage::disk('public')->delete($alumni->banner_picture);
            }
            $alumni->banner_picture = $request->file('banner_picture')->store('banner_picture', 'public');
        }

        $alumni->save();

        return redirect()->route('profile.view')->with('status', 'Profile updated successfully.');
    }

    public function public(Request $request, $alumniID)
    {
        $alumni = Alumni::findOrFail($alumniID);
        $isOwner = Auth::guard('alumni')->check() && Auth::guard('alumni')->id() == $alumniID;
    
        // Check if accessed from directory via query parameter
        $fromDirectory = $request->query('from_directory', false);
    
        return view('alumni.profile', [
            'alumni' => $alumni,
            'isOwner' => $isOwner,
            'editMode' => false,
            'fromDirectory' => $fromDirectory, // pass this to Blade
        ]);
    }
}
