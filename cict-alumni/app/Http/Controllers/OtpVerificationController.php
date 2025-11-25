<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\AlumniVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class OtpVerificationController extends Controller
{
    public function showOtpForm()
    {
        if (!session()->has('registration_data')) {
            return redirect()->route('alumni.register')->with('error', 'No registration data found. Please register again.');
        }

        session(['otp_cooldown' => 30]);
        return view('auth.otp_verification');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp_code' => 'required|numeric']);

        if (!session()->has('registration_data')) {
            return redirect()->route('alumni.register')->with('error', 'Registration session expired.');
        }

        $regData = session('registration_data');

        $verification = AlumniVerification::where('otp', $request->otp_code)
            ->where('expires_at', '>', now())
            ->first();

        if (!$verification) {
            return back()->with('error', 'Invalid or expired OTP.');
        }

        // Save to Alumni
        $alumni = Alumni::create([
            'last_name' => $regData['last_name'],
            'first_name' => $regData['first_name'],
            'middle_initial' => $regData['middle_initial'],
            'age' => $regData['age'],
            'address' => $regData['address'],
            'phone_number' => $regData['phone_number'],
            'current_job' => $regData['current_job'],
            'graduation_year' => $regData['graduation_year'],
            'degree_program' => $regData['degree_program'],
            'gender' => $regData['gender'], // ✅ add this line
            'email' => $regData['email'],
            'password' => Hash::make($regData['password']),
        ]);

        // Delete verification record (no need to save alumniID to it)
        $verification->delete();
        session()->forget('registration_data');
        session()->forget('resend_count');

        return redirect()->route('alumni.login')->with('success', 'Your email is verified! You may now log in.');
    }

    public function resendOtp()
    {
        if (!session()->has('registration_data')) {
            return back()->with('error', 'Registration session expired.');
        }

        $regData = session('registration_data');
        $otpCode = rand(100000, 999999);

        // Save new OTP to alumni_verifications table using email
        AlumniVerification::updateOrCreate(
            ['email' => $regData['email']],
            ['otp' => $otpCode, 'expires_at' => now()->addMinutes(5)]
        );

        Mail::raw("Your OTP code is: $otpCode", function ($message) use ($regData) {
            $message->to($regData['email'])
                    ->subject('Your OTP Code');
        });

        $resendCount = session('resend_count', 0) + 1;
        $cooldown = min(300, 30 + ($resendCount - 1) * 30); // Max 5 mins
        session([
            'otp_cooldown' => $cooldown,
            'resend_count' => $resendCount,
        ]);

        return back()->with('success', 'OTP has been resent.');
    }

    public function changeEmail()
    {
        session()->forget('registration_data');
        session()->forget('resend_count');
        return redirect()->route('alumni.register')->with('success', 'Please register again with a new email.');
    }
}
