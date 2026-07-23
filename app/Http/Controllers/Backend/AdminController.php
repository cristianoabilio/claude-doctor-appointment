<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...

            $user = Auth::user();
            $verificationCode = random_int(100000, 999999); // Generate a random 6-digit code

            session(['verification_code' => $verificationCode, 'user_id' => $user->id]);

            Mail::to($user->email)->send(new VerificationCodeEmail($verificationCode));

            Auth::logout();

            return redirect()->route('custom.verification.code')
                ->with('status', 'Verification Code sent to you email.');
        }

        return redirect()->back()->withErrors(['email' => 'Invalid credentials provided.']);
    }

    public function verificationCode()
    {
        return view('auth.verify-code');
    }

    public function verificationCodeLogin(Request $request)
    {
        $request->validate(['verification_code' => ['required', 'numeric']]);

        if ((int) $request->verification_code === session('verification_code')) {
            Auth::loginUsingId(session('user_id'));

            session()->forget([
                'verification_code',
                'user_id'
            ]);

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['code' => 'Invalid Verification Code.']);
    }



    public function logout(Request $request)
    {
        Auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
