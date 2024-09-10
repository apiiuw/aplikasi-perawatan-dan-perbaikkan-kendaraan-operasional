<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Exception;

class LoginController extends Controller
{
    // Fungsi login standar dengan NRP atau email
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

    // Redirect ke Google untuk login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle callback dari Google setelah login
    public function handleGoogleCallback()
{
    try {
        // Mendapatkan user dari Google dengan stateless
        $googleUser = Socialite::driver('google')->stateless()->user();
        
        // Cari atau buat user di database
        $user = User::where('email', $googleUser->email)->first();
        
        if ($user) {
            Auth::login($user);
        } else {
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'password' => bcrypt('password'),
            ]);
            
            Auth::login($user);
        }
        
        return redirect()->intended('/');
    } catch (Exception $e) {
        return redirect('/login')->with('error', 'Gagal login dengan Google.');
    }
}

}
