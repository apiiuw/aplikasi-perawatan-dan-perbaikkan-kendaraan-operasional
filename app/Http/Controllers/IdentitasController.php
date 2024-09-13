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
    
        // Validasi input tanpa avatar
        $validated = $request->validate([
            'nama_pengabiministrasi' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nama_instansi' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nrp' => 'required|numeric',
            'nama_atasan' => 'nullable|string|max:255',
            'nrp_atasan' => 'nullable|string|max:255',
            'jabatan_atasan' => 'nullable|string|max:255',
        ]);
    
        // Validasi avatar
        if ($request->hasFile('avatar')) {
            $avatarFile = $request->file('avatar');
            $mimeType = $avatarFile->getClientMimeType();
            $validMimeTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
    
            if (!in_array($mimeType, $validMimeTypes)) {
                return redirect()->route('identitas.edit')->withErrors([
                    'avatar' => 'Format file tidak dapat diterima. Silakan unggah file dengan format JPEG, PNG, JPG, atau GIF.'
                ])->withInput();
            }
    
            // Validasi ukuran file
            if ($avatarFile->getSize() > 2048 * 1024) {
                return redirect()->route('identitas.edit')->withErrors([
                    'avatar' => 'Ukuran file terlalu besar. Maksimal ukuran file adalah 2MB.'
                ])->withInput();
            }
    
            $avatarPath = 'assets/image/user_avatar/' . $user->id;
            $avatarName = time() . '.' . $avatarFile->getClientOriginalExtension();
    
            // Buat direktori jika belum ada
            $fullPath = public_path($avatarPath);
            if (!file_exists($fullPath)) {
                mkdir($fullPath, 0755, true);
            }
    
            // Simpan file ke direktori
            $avatarFile->move($fullPath, $avatarName);
            $avatarPathFull = $avatarPath . '/' . $avatarName;
            
            // Update path avatar pada validasi
            $validated['avatar'] = $avatarPathFull;
        } else {
            // Jika tidak ada file yang diupload, gunakan path lama jika ada
            $validated['avatar'] = $user->avatar;
        }
    
        // Cek apakah ada perubahan
        $hasChanges = false;
        foreach ($validated as $key => $value) {
            if ($user->$key !== $value) {
                $hasChanges = true;
                break;
            }
        }
    
        if ($hasChanges) {
            // Update user
            $user->update($validated);
            return redirect()->route('identitas.edit')->with([
                'success' => 'Identitas berhasil diperbarui.',
                'success_type' => 'success'
            ]);
        } else {
            // Jika tidak ada perubahan, kembali ke halaman edit dengan pesan info
            return redirect()->route('identitas.edit')->with([
                'success' => 'Tidak ada perubahan yang dilakukan.',
                'success_type' => 'info'
            ]);
        }
    }    

}
