<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /**
     * Handle authentication attempt.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required'],
            ],
            [
                'email.required' => 'Alamat email wajib diisi.',
                'email.email' => 'Format alamat email tidak valid.',
                'password.required' => 'Kata sandi wajib diisi.',
            ]
        );

        $adminName = config('admin.default_name');
        $adminEmail = config('admin.default_email');
        $adminPassword = config('admin.default_password');
        $user = User::where('email', $credentials['email'])->first();

        if (! hash_equals($adminEmail, $credentials['email'])) {
            throw ValidationException::withMessages([
                'login' => 'Email atau kata sandi yang Anda masukkan salah.',
            ]);
        }

        if (! $user && $credentials['email'] === $adminEmail) {
            $user = User::create([
                'name' => $adminName,
                'email' => $adminEmail,
                'password' => Hash::make($adminPassword),
            ]);
        }

        if ($user && $credentials['email'] === $adminEmail && hash_equals($adminPassword, $credentials['password'])) {
            $user->name = $user->name ?: $adminName;
            $user->password = Hash::make($adminPassword);
            $user->save();
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        throw ValidationException::withMessages([
            'login' => 'Email atau kata sandi yang Anda masukkan salah.',
        ]);
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
