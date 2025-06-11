<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Email harus diisi',
            'email.email'       => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan tidak sesuai.',
        ])->onlyInput('email');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'email'    => ['required', 'email', 'unique:users'],
            'nik'      => ['required', 'string', 'size:16', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role'     => ['required', 'in:employee,admin'],
        ], [
            'email.required'     => 'Email harus diisi',
            'email.email'        => 'Format email tidak valid',
            'email.unique'       => 'Email sudah terdaftar',
            'nik.required'       => 'NIK harus diisi',
            'nik.size'           => 'NIK harus terdiri dari 16 digit',
            'nik.unique'         => 'NIK sudah terdaftar',
            'password.required'  => 'Password harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'role.required'      => 'Role harus dipilih',
            'role.in'            => 'Role yang dipilih tidak valid',
        ]);

        $user = User::create([
            'email'    => $validated['email'],
            'nik'      => $validated['nik'],
            'password' => Hash::make($validated['password']),
            'role'     => $validated['role'],
        ]);

        $user->assignRole($validated['role']);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Registrasi berhasil!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
