@extends('layouts.main')
@section('container')

<div class="p-4 sm:ml-64">
    <div class="p-4 mt-14 flex flex-col justify-center">
        <div class="bg-gray-100 h-full flex flex-col items-center justify-center py-10">
            @if ($errors->any())
            <div class="mb-4 p-4 bg-red-500 text-white border border-red-700 flash-message show">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif
            
            @if (session('success'))
                @if (session('success_type') === 'info')
                    <div id="flash-message" class="mb-4 p-4 bg-yellow-500 text-white border border-yellow-700 flash-message show">
                        {{ session('success') }}
                    </div>
                @elseif (session('success_type') === 'success')
                    <div id="flash-message" class="mb-4 p-4 bg-green-100 text-green-700 border border-green-300 flash-message show">
                        {{ session('success') }}
                    </div>
                @endif
            @endif            
            <h1 class="mb-3 font-jakartaSans font-bold text-2xl">UBAH IDENTITAS DIRI</h1>
            <form action="{{ route('identitas.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')                
                <div class="max-w-lg bg-white pr-8 pl-8 pt-8 pb-8 rounded shadow-md lg:w-full">
                    <!-- Avatar Section -->
                    <div class="flex flex-col items-center justify-center mb-6">
                        <div class="w-24 h-24 overflow-hidden rounded-full" id="avatar-preview">
                            <img src="{{ asset('assets/image/user_avatar/' . (auth()->user()->avatar ? auth()->user()->id . '/' . basename(auth()->user()->avatar) : 'default/default_user_profile.png')) }}" alt="Avatar" class="w-full h-full object-cover" />
                        </div>
                        
                        <button type="button" class="mt-2 bg-green-500 hover:bg-green-600 border rounded-md p-2 px-3">
                            <label for="avatar" class="cursor-pointer text-white">Ubah Foto</label>
                            <input type="file" id="avatar" name="avatar" class="hidden" />
                        </button>                                            
                    </div>
            
                    <!-- Nama Lengkap Section -->
                    <div class="mb-6">
                        <div>
                            <label for="nama_pengabiministrasi" class="block text-gray-700 text-sm font-bold mb-2 pointer-events-none">Nama Lengkap</label>
                            <input type="text" id="nama_pengabiministrasi" name="nama_pengabiministrasi" value="{{ auth()->user()->nama_pengabiministrasi }}"
                                class="w-full px-4 py-2 bg-yellow-400 border border-yellow-400 rounded cursor-default pointer-events-none" readonly />
                        </div>
                    </div>

                    <!-- Jabatan Section -->
                    <div class="mb-6">
                        <div>
                            <label for="jabatan" class="block text-gray-700 text-sm font-bold mb-2">Jabatan</label>
                            <input type="text" id="jabatan" name="jabatan" value="{{ auth()->user()->jabatan }}"
                                class="w-full px-4 py-2 border border-green-500 rounded focus:border-green-700 focus:ring-green-700 focus:outline-none" />
                        </div>
                    </div>                 

                    <!-- Nama Instansi Section -->
                    <div class="mb-6">
                        <div>
                            <label for="nama_instansi" class="block text-gray-700 text-sm font-bold mb-2 pointer-events-none">Nama Instansi</label>
                            <input type="text" id="nama_instansi" name="nama_instansi" value="{{ auth()->user()->nama_instansi }}"
                                class="w-full px-4 py-2 bg-yellow-400 border border-yellow-400 rounded cursor-default pointer-events-none" readonly />
                        </div>
                    </div>
            
                    <!-- Email Section -->
                    <div class="mb-6">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2 pointer-events-none">Email</label>
                        <input type="email" id="email" name="email" value="{{ auth()->user()->email }}"
                            class="w-full px-4 py-2 bg-yellow-400 border border-yellow-400 rounded cursor-default pointer-events-none" readonly />
                    </div>

                    <!-- NRP Section -->
                    <div class="mb-6">
                        <label for="nrp" class="block text-gray-700 text-sm font-bold mb-2 pointer-events-none">NRP (Nomor Registrasi Pokok)</label>
                        <input type="number" id="nrp" name="nrp" value="{{ auth()->user()->nrp }}"
                            class="w-full px-4 py-2 bg-yellow-400 border border-yellow-400 rounded cursor-default pointer-events-none" readonly />
                    </div>

                </div>

                <div class="max-w-lg bg-blue-500 p-8 rounded shadow-md lg:w-full">
                    <!-- Nama Lengkap Atasan Section -->
                    <div class="mb-6">
                        <div>
                            <label for="nama_atasan" class="block text-white text-sm font-bold mb-2">Nama Lengkap Atasan</label>
                            <input type="text" id="nama_atasan" name="nama_atasan" value="{{ auth()->user()->nama_atasan }}"
                                class="w-full px-4 py-2 border-2 border-green-500 rounded focus:border-green-700 focus:ring-green-700 focus:outline-none" />
                        </div>
                    </div>

                    <!-- NRP Atasan Section -->
                    <div class="mb-6">
                        <div>
                            <label for="nrp_atasan" class="block text-white text-sm font-bold mb-2">NRP (Nomor Registrasi Pokok) Atasan</label>
                            <input type="number" id="nrp_atasan" name="nrp_atasan" value="{{ auth()->user()->nrp_atasan }}"
                                class="w-full px-4 py-2 border-2 border-green-500 rounded focus:border-green-700 focus:ring-green-700 focus:outline-none" />
                        </div>
                    </div>

                    <!-- Jabatan Atasan Section -->
                    <div class="mb-0">
                        <div>
                            <label for="jabatan_atasan" class="block text-white text-sm font-bold mb-2">Jabatan Atasan</label>
                            <input type="text" id="jabatan_atasan" name="jabatan_atasan" value="{{ auth()->user()->jabatan_atasan }}"
                                class="w-full px-4 py-2 border-2 border-green-500 rounded focus:border-green-700 focus:ring-green-700 focus:outline-none" />
                        </div>
                    </div>
                </div>
            
                <!-- Buttons -->
                <div class="flex justify-center gap-x-5 mx-5 mt-5">
                    <button type="submit"
                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 focus:outline-none focus:shadow-outline-green">
                        Simpan Perubahan
                    </button>
                    <a href="{{ url('/identitas') }}"
                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 focus:outline-none focus:shadow-outline-red">
                        Batalkan Perubahan
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Transisi untuk flash message */
    .flash-message {
        transition: opacity 0.6s ease;
    }

    /* Kelas untuk menampilkan pesan */
    .show {
        opacity: 1;
    }

    /* Kelas untuk menyembunyikan pesan (fade out) */
    .fade-out {
        opacity: 0;
    }

</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('form').addEventListener('submit', function(event) {
            // Anda bisa menambahkan logika konfirmasi atau validasi di sini
            // Misalnya, konfirmasi sebelum submit:
            var confirmed = confirm("Apakah Anda yakin ingin menyimpan perubahan?");
            if (!confirmed) {
                event.preventDefault(); // Mencegah submit jika tidak dikonfirmasi
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var fileInput = document.getElementById('avatar');
        var avatarPreview = document.getElementById('avatar-preview').querySelector('img');

        fileInput.addEventListener('change', function(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    avatarPreview.src = e.target.result; // Update preview dengan gambar yang di-upload
                }

                reader.readAsDataURL(file);
            }
        });
    });
</script>

    
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            // Tambahkan kelas 'flash-message' untuk memastikan transisi diterapkan
            flashMessage.classList.add('flash-message');

            // Jika jenis pesan adalah 'success', redirect setelah 3 detik
            if (flashMessage.classList.contains('bg-green-100')) {
                setTimeout(function() {
                    flashMessage.classList.add('fade-out'); // Mulai fade out
                    setTimeout(function() {
                        window.location.href = '/identitas'; // Redirect setelah 3 detik
                    }, 600); // Durasi transisi fade out
                }, 3000); // Tampilkan selama 3 detik
            } else {
                setTimeout(function() {
                    flashMessage.classList.add('fade-out'); // Mulai fade out
                    setTimeout(function() {
                        flashMessage.remove(); // Hapus elemen dari DOM setelah fade out
                    }, 600); // Durasi transisi fade out
                }, 3000); // Tampilkan selama 3 detik
            }
        }
    });
</script>

@endsection
