<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Program;
use App\Models\Specialization;
use App\Models\AlumniMasterlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class AlumniAuthController extends Controller
{
    // ------------------------
    // Show Registration Form
    // ------------------------
    public function showRegistrationForm()
    {
        $programs = Program::all();
        $specializations = Specialization::all();
        return view('auth.alumni_register', compact('programs', 'specializations'));
    }

    // ------------------------
    // Verify against Masterlist
    // ------------------------
    public function verifyMasterlist(Request $request)
    {
        $request->validate([
            'student_number' => 'nullable|string',
            'last_name' => 'required|string',
            'first_name' => 'nullable|string',
            'birthdate' => 'nullable|date',
            'use_fullname' => 'required|boolean',
        ]);

        $query = AlumniMasterlist::query();

        if ($request->use_fullname) {
            $query->whereRaw('LOWER(first_name) = ?', [strtolower($request->first_name)])
                  ->whereRaw('LOWER(last_name) = ?', [strtolower($request->last_name)])
                  ->when($request->birthdate, fn($q) => $q->whereDate('birthdate', $request->birthdate));
        } else {
            $query->where('student_number', $request->student_number)
                  ->whereRaw('LOWER(last_name) = ?', [strtolower($request->last_name)]);
        }

        $match = $query->first();

        if (!$match) {
            return response()->json([
                'success' => false,
                'message' => 'No matching record found in the masterlist. Please check your details and try again.'
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'student_number'   => $match->student_number,
                'first_name'       => $match->first_name,
                'middle_name'      => $match->middle_name,
                'last_name'        => $match->last_name,
                'birthdate'        => $match->birthdate,
                'gender'           => $match->gender,
                'programID'        => $match->programID,
                'specializationID' => $match->specializationID,
                'graduation_year'  => $match->graduation_year,
                'auxiliary_name'   => $match->auxiliary_name, // ✅ only prefilled field
            ]
        ]);
    }

    // ------------------------
    // Handle Registration
    // ------------------------
    public function register(Request $request)
    {
        $validated = $request->validate([
            'student_number' => 'nullable|string',
            'last_name' => 'required|string',
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'auxiliary_name' => 'nullable|string|max:255',
            'birthdate' => 'required|date',
            'gender' => 'required|string',
            'civil_status' => 'required|string',
            'programID' => 'required|exists:programs,programID',
            'specializationID' => 'nullable|exists:specializations,specializationID',
            'graduation_year' => 'required|numeric',
            'employment_status' => 'nullable|string',
            'address' => 'required|string',
            'country' => 'required|string',
            'region' => 'nullable|string',
            'province' => 'nullable|string',
            'city' => 'nullable|string',
            'postal_code' => 'required|string',
            'mobile_number' => 'required|string',
            'email' => 'required|email|unique:alumni,email',
            'password' => ['required', 'string', 'min:8', 'confirmed',
                           'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*?&]/'],
            'privacy' => 'accepted',
            'answered_alumni_tracer' => 'nullable|boolean'
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.regex' => 'Password must include at least one uppercase letter, one number, and one special character.',
            'password.confirmed' => 'Password confirmation does not match.'
        ]);

        Alumni::create([
            'student_number' => $validated['student_number'] ?? null,
            'last_name' => $validated['last_name'],
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'auxiliary_name' => $validated['auxiliary_name'] ?? null,
            'birthdate' => $validated['birthdate'],
            'gender' => $validated['gender'],
            'civil_status' => $validated['civil_status'],
            'program' => $validated['programID'],
            'specialization' => $validated['specializationID'] ?? null,
            'graduation_year' => $validated['graduation_year'],
            'employment_status' => $validated['employment_status'] ?? null,
            'address' => $validated['address'],
            'country' => $validated['country'],
            'region' => $validated['region'] ?? null,
            'province' => $validated['province'] ?? null,
            'city' => $validated['city'] ?? null,
            'postal_code' => $validated['postal_code'],
            'phone_number' => $validated['mobile_number'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'answered_alumni_tracer' => $validated['answered_alumni_tracer'] ?? 0,
        ]);

        return redirect()->route('alumni.login')
                         ->with('success', 'Account created successfully! You may now log in.');
    }

    // ------------------------
    // Show Login Form
    // ------------------------
    public function showLoginForm()
    {
        return view('auth.alumni_login');
    }

    // ------------------------
    // Handle Login
    // ------------------------
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $email = $request->email;

        $attemptsKey = 'alumni_login_attempts_' . $email;
        $lockoutKey = 'alumni_login_lockout_' . $email;

        if (Cache::has($lockoutKey)) {
            $seconds = Cache::get($lockoutKey) - time();
            return back()
                ->withErrors(['email' => "Too many failed login attempts. Try again in {$seconds} seconds."])
                ->withInput()
                ->with('lockout_seconds', $seconds);
        }

        $alumni = Alumni::where('email', $email)->first();

        if (!$alumni || !Hash::check($request->password, $alumni->password)) {
            $attempts = Cache::get($attemptsKey, 0) + 1;
            Cache::put($attemptsKey, $attempts, 300);

            if ($attempts >= 5) {
                $lockoutTime = 300;
                Cache::put($lockoutKey, time() + $lockoutTime, $lockoutTime);
                Cache::forget($attemptsKey);
                return back()->withErrors(['email' => 'Too many failed login attempts.'])->withInput();
            }

            return back()->withErrors(['email' => 'Invalid email or password'])->withInput();
        }

        Cache::forget($attemptsKey);
        Cache::forget($lockoutKey);

        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerate();

        Auth::guard('alumni')->login($alumni);

        return redirect()->route('alumni.home');
    }

    // ------------------------
    // Logout Alumni
    // ------------------------
    public function logout(Request $request)
    {
        $alumni = Auth::guard('alumni')->user();
        if ($alumni) {
            Cache::forget('online_alumni_' . $alumni->alumniID);
        }

        Auth::guard('alumni')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out.');
    }
}
