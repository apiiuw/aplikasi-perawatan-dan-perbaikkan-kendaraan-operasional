<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PT Jasa Raharja - {{ $title }}</title>
    <link rel="icon" href="{{ asset('assets/Logo/Jasa Raharja Logo Utama.png') }}">

    {{-- CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>

    @vite('resources/css/app.css')
</head>

<body class="flex justify-center items-center h-full">
    <div class="flex w-full max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-lg lg:max-w-6xl my-10">
        <div class="hidden bg-cover lg:block lg:w-3/4 lg:bg-cover" style="background-image: url('/assets/image/branding/branding.jpeg');"></div>

        <div class="w-full px-6 py-8 md:px-8 lg:w-1/2">
            <div class="flex justify-center mx-auto">
                <img class="w-auto h-7 sm:h-8" src="{{ asset('assets/Logo/Logo Jasa Raharja Utama dalam pelindungan, prima dalam pelayanan.png') }}" alt="">
            </div>

            <p class="mt-3 text-xl text-center text-gray-600">
                Daftar Akun Baru
            </p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mt-4">
                    <label class="block mb-2 text-sm font-medium text-gray-600" for="nama_pengabiministrasi">Nama Pengabministrasi</label>
                    <input id="nama_pengabiministrasi" name="nama_pengabiministrasi" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg focus:border-blue-400 focus:ring-opacity-40 focus:outline-none focus:ring focus:ring-blue-300" type="text" value="{{ old('nama_pengabministrasi') }}" required />
                    @error('nama_pengabministrasi')
                        <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label class="block mb-2 text-sm font-medium text-gray-600" for="jabatan">Jabatan</label>
                    <input id="jabatan" name="jabatan" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg focus:border-blue-400 focus:ring-opacity-40 focus:outline-none focus:ring focus:ring-blue-300" type="text" value="{{ old('jabatan') }}" required />
                    @error('jabatan')
                        <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label class="block mb-2 text-sm font-medium text-gray-600" for="nrp">NRP</label>
                    <input id="nrp" name="nrp" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg focus:border-blue-400 focus:ring-opacity-40 focus:outline-none focus:ring focus:ring-blue-300" type="number" value="{{ old('nrp') }}" required />
                    @error('nrp')
                        <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label class="block mb-2 text-sm font-medium text-gray-600" for="nama_instansi">Nama Instansi</label>
                    <select id="nama_instansi" name="nama_instansi" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg focus:border-blue-400 focus:ring-opacity-40 focus:outline-none focus:ring focus:ring-blue-300">
                        <option value="" disabled selected>Pilih Instansi</option>
                        <!-- Tambahkan opsi instansi di sini -->
                        <option value="Cabang Utama DKI Jakarta">Cabang Utama DKI Jakarta</option>
                        <option value="Cabang Utama Kepulauan Riau">Cabang Utama Kepulauan Riau</option>
                        <option value="Cabang Utama Serang">Cabang Utama Serang</option>
                    </select>
                    @error('nama_instansi')
                        <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            
                <div class="mt-4">
                    <label class="block mb-2 text-sm font-medium text-gray-600" for="kabupaten_kota">Kabupaten/Kota</label>
                    <select id="kabupaten_kota" name="kabupaten_kota" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg focus:border-blue-400 focus:ring-opacity-40 focus:outline-none focus:ring focus:ring-blue-300">
                        <option value="" disabled selected>Pilih Kabupaten/Kota</option>
                        <!-- Tambahkan opsi kabupaten/kota di sini -->
                        <option value="DKI Jakarta">DKI Jakarta</option>
                        <option value="Kepulauan Riau">Kepulauan Riau</option>
                        <option value="Serang">Serang</option>
                    </select>
                    @error('kabupaten_kota')
                        <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            
                <div class="mt-4">
                    <label class="block mb-2 text-sm font-medium text-gray-600" for="email">Email</label>
                    <input id="email" name="email" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg focus:border-blue-400 focus:ring-opacity-40 focus:outline-none focus:ring focus:ring-blue-300" type="email" value="{{ old('email') }}" required autofocus />
                    @error('email')
                        <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            
                <div class="mt-4">
                    <label class="block mb-2 text-sm font-medium text-gray-600" for="password">Password</label>
                    <input id="password" name="password" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg focus:border-blue-400 focus:ring-opacity-40 focus:outline-none focus:ring focus:ring-blue-300" type="password" required />
                    @error('password')
                        <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            
                <div class="mt-4">
                    <label class="block mb-2 text-sm font-medium text-gray-600" for="password_confirmation">Konfirmasi Password</label>
                    <input id="password_confirmation" name="password_confirmation" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg focus:border-blue-400 focus:ring-opacity-40 focus:outline-none focus:ring focus:ring-blue-300" type="password" required />
                </div>
            
                <div class="mt-6">
                    <button type="submit" class="w-full px-6 py-3 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-gray-800 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-50">
                        Daftar
                    </button>
                </div>
            </form>            

            <div class="flex items-center justify-between mt-4">
                <span class="w-1/5 border-b md:w-1/4"></span>

                <a href="/login" class="text-xs text-gray-500 uppercase:text-gray-400 hover:underline">Atau Masuk</a>

                <span class="w-1/5 border-b md:w-1/4"></span>
            </div>
        </div>
    </div>
</body>
</html>
