<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validasi data formulir
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');

        // Cek apakah input login adalah email atau NRP
        $user = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? User::where('email', $login)->first()
            : User::where('nrp', $login)->first();

        if ($user && Hash::check($password, $user->password)) {
            // Autentikasi berhasil
            Auth::login($user);
            return redirect()->intended('/');
        }

        // Jika user ditemukan tetapi password salah
        if ($user) {
            return back()->withErrors([
                'password' => 'Password yang diberikan tidak sesuai.',
            ])->withInput();
        }

        // Jika user tidak ditemukan
        return back()->withErrors([
            'login' => 'NRP atau email yang diberikan tidak ditemukan.',
        ])->withInput();
    }
}
