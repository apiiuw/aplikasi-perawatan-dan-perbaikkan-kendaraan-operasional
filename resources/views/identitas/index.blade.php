@extends('layouts.main')
@section('container')

<div class="p-4 sm:ml-64">
    <div class="p-4 mt-14 flex flex-col justify-center">
        <div class="bg-gray-100 h-full flex flex-col items-center justify-center py-10">
            <h1 class="mb-3 font-jakartaSans font-bold text-2xl">IDENTITAS DIRI</h1>
            <div class="max-w-lg bg-white pr-8 pl-8 pt-8 rounded shadow-md lg:w-full">
                <!-- Avatar Section -->
                <div class="flex items-center justify-center mb-6">
                    <div class="w-24 h-24 mr-4 overflow-hidden rounded-full">
                        <img src="{{ asset('assets/image/user_avatar/' . (auth()->user()->avatar ? auth()->user()->id . '/' . basename(auth()->user()->avatar) : 'default/default_user_profile.png')) }}" alt="Avatar" class="w-full h-full object-cover" />
                    </div>
                </div>
        
                <!-- Nama Lengkap Section -->
                <div class="mb-6">
                    <div>
                        <label for="nama_pengabministrasi" class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                        <input type="text" id="nama_pengabministrasi" name="nama_pengabministrasi" value="{{ auth()->user()->nama_pengabiministrasi }}"
                            class="w-full px-4 py-2 border rounded cursor-default pointer-events-none" readonly />
                    </div>
                </div>

                <!-- Jabatan Section -->
                <div class="mb-6">
                    <div>
                        <label for="jabatan" class="block text-gray-700 text-sm font-bold mb-2">Jabatan</label>
                        <input type="text" id="jabatan" name="jabatan" value="{{ auth()->user()->jabatan }}"
                            class="w-full px-4 py-2 border rounded cursor-default pointer-events-none" readonly />
                    </div>
                </div>

                <!-- Nama Instansi Section -->
                <div class="mb-6">
                    <div>
                        <label for="nama_instansi" class="block text-gray-700 text-sm font-bold mb-2">Nama Instansi</label>
                        <input type="text" id="nama_instansi" name="nama_instansi" value="{{ auth()->user()->nama_instansi }}"
                            class="w-full px-4 py-2 border rounded cursor-default pointer-events-none" readonly />
                    </div>
                </div>
        
                <!-- Email Section -->
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ auth()->user()->email }}"
                        class="w-full px-4 py-2 border rounded cursor-default pointer-events-none" readonly />
                </div>

                <!-- NRP Section -->
                <div class="mb-6">
                    <label for="nrp" class="block text-gray-700 text-sm font-bold mb-2">NRP (Nomor Registrasi Pokok)</label>
                    <input type="number" id="nrp" name="nrp" value="{{ auth()->user()->nrp }}"
                        class="w-full px-4 py-2 border rounded cursor-default pointer-events-none" readonly />
                </div>

            </div>

            <div class="max-w-lg bg-blue-500 p-8 rounded shadow-md lg:w-full">
                <!-- Nama Lengkap Atasan Section -->
                <div class="mb-6">
                    <div>
                        <label for="nama_atasan" class="block text-white text-sm font-bold mb-2">Nama Lengkap Atasan</label>
                        <input type="text" id="nama_atasan" name="nama_atasan" value="{{ auth()->user()->nama_atasan }}"
                            class="w-full px-4 py-2 border rounded cursor-default pointer-events-none" readonly />
                    </div>
                </div>

                <!-- NRP Atasan Section -->
                <div class="mb-6">
                    <div>
                        <label for="nrp_atasan" class="block text-white text-sm font-bold mb-2">NRP (Nomor Registrasi Pokok) Atasan</label>
                        <input type="text" id="nrp_atasan" name="nrp_atasan" value="{{ auth()->user()->nrp_atasan }}"
                            class="w-full px-4 py-2 border rounded cursor-default pointer-events-none" readonly />
                    </div>
                </div>

                <!-- Jabatan Atasan Section -->
                <div class="mb-6">
                    <div>
                        <label for="jabatan_atasan" class="block text-white text-sm font-bold mb-2">Jabatan Atasan</label>
                        <input type="text" id="jabatan_atasan" name="jabatan_atasan" value="{{ auth()->user()->jabatan_atasan }}"
                            class="w-full px-4 py-2 border rounded cursor-default pointer-events-none" readonly />
                    </div>
                </div>
            </div>
        
                <!-- Buttons -->
                <div class="flex justify-center mx-5 mt-5">
                    <a href="{{ url('/identitas/edit') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 focus:outline-none focus:shadow-outline-blue">
                    Ubah Identitas
                </a>
                </div>
        </div>
    </div>
</div>

@endsection
