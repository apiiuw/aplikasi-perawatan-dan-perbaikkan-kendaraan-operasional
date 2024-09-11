<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register'); // Pastikan ini sesuai dengan lokasi file view register
    }

    public function register(Request $request)
    {
        // Validasi data
        $this->validator($request->all())->validate();

        // Periksa apakah NRP sudah ada
        if (User::where('nrp', $request->nrp)->exists()) {
            return redirect()->back()->withErrors(['nrp' => 'NRP sudah terdaftar.']);
        }

        // Jika validasi dan pengecekan berhasil, buat pengguna baru
        $user = $this->create($request->all());

        // Login pengguna yang baru didaftarkan
        Auth::login($user);

        return redirect()->route('beranda');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:20', 'confirmed'],
            'nama_instansi' => ['required', 'string'],
            'nama_pengabiministrasi' => ['required', 'string'],
            'nrp' => ['required', 'numeric', 'unique:users,nrp'],
            'jabatan' => ['required', 'string'],
            'kabupaten_kota' => ['required', 'string'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'nama_instansi' => $data['nama_instansi'],
            'nama_pengabiministrasi' => $data['nama_pengabiministrasi'] ?? '',
            'nrp' => $data['nrp'],
            'jabatan' => $data['jabatan'],
            'kabupaten_kota' => $data['kabupaten_kota'],
        ]);
    }
}
