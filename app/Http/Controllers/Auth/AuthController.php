<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'occupation' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'currency' => 'nullable|string|max:10',
            'password' => 'required|string|min:4|confirmed',
        ]);

        $passportPath = $request->hasFile('passport')
            ? $request->file('passport')->storeAs('passports', time() . '_' . $request->file('passport')->getClientOriginalName(), 'public')
            : null;

        $kycPath = $request->hasFile('kyc')
            ? $request->file('kyc')->storeAs('kycs', time() . '_' . $request->file('kyc')->getClientOriginalName(), 'public')
            : null;

        $loginId = rand(1000000000, 9999999999);
        $accountNumber = abs(rand(1000000000, 9999999999));

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'country' => $validated['country'] ?? null,
            'city' => $validated['city'] ?? null,
            'currency' => $validated['currency'] ?? null,
            'password' => Hash::make($validated['password']),
            'kyc_path' => $kycPath,
            'login_id' => $loginId,
            'account_number' => $accountNumber,
            'plain' => $validated['password'],
            'verification_code' => rand(1000, 9999),
            'email_status' => 1,
            'user_status' => 1,
            'verification_expiry' => now()->addMinutes(10),
        ]);

        Mail::send('emails.account_welcome', ['user' => $user], function($message) use ($user) {
            $message->to($user->email, $user->name)
                    ->subject('Welcome to Appex Trust Bank - Your Account Details');
        });

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Account created successfully! Check your email for your account number.');
    }


    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'login_id';

        if (Auth::attempt([$fieldType => $request->login, 'password' => $request->password])) {
            return redirect()->route('home')->with('success', 'Logged in successfully!');
        }

        return redirect()->back()->withErrors(['login' => 'Invalid login credentials'])->withInput();
    }


    /**
     * Handle forgot password.
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $token = \Illuminate\Support\Str::random(64);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        $url = url('/reset-password/' . $token . '?email=' . urlencode($request->email));

        Mail::send('emails.password_reset', ['url' => $url], function($message) use ($request) {
            $message->to($request->email)
                    ->subject('Reset Your Password - Appex Trust Bank');
        });

        return back()->with('success', 'Password reset link has been sent to your email.');
    }


    /**
     * Show the reset password form.
     */
    public function showResetForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }


    /**
     * Handle password reset.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:4|confirmed',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->withErrors(['email' => 'Invalid or expired reset token.']);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->plain = $request->password;
        $user->save();

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password has been reset successfully. Please login.');
    }
}
