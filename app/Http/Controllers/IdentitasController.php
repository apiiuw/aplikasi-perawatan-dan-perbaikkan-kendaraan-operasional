<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdentitasController extends Controller
{
    public function edit()
    {
        return view('identitas.edit', [
            'active' => 'identitas',
            'title' => 'Edit Identitas',
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validated = $request->validate([
            'nama_pengabiministrasi' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nama_instansi' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nrp' => 'required|numeric',
            'nama_atasan' => 'nullable|string|max:255',
            'nrp_atasan' => 'nullable|string|max:255',
            'jabatan_atasan' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk avatar
        ]);

        // Update avatar jika ada
        if ($request->hasFile('avatar')) {
            $avatarFile = $request->file('avatar');
            $avatarPath = 'assets/image/user_avatar/' . $user->id;
            $avatarName = time() . '.' . $avatarFile->getClientOriginalExtension();

            // Buat direktori jika belum ada
            $fullPath = public_path($avatarPath);
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }

            // Simpan file ke direktori
            $avatarFile->move($fullPath, $avatarName);
            $validated['avatar'] = $avatarPath . '/' . $avatarName;
        }

        // Update user
        $user->update($validated);

        return redirect()->route('identitas.edit')->with([
            'success' => 'Identitas berhasil diperbarui.',
            'success_type' => 'success'
        ]);
    }

}
