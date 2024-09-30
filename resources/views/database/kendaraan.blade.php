@extends('layouts.main')

@section('container')
<div class="p-4 sm:ml-64">
    <div class="p-4 mt-14">
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">Data Kendaraan</h1>

            <div class="overflow-x-auto">
                <table id="kendaraan-table" class="min-w-full bg-white border border-gray-300 mb-4 mx-4" style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            @if (isset($data['data_kendaraan'][0]))
                                @foreach ($data['data_kendaraan'][0] as $header)
                                    <th class="py-2 border-b border-gray-300 text-center px-4 border-r whitespace-nowrap">{{ $header }}</th>
                                @endforeach
                                <th class="py-2 border-b border-gray-300 text-center px-4 border-r whitespace-nowrap">Aksi</th>
                            @else
                                <th class="py-2 border-b border-gray-300 text-center px-4 border-r whitespace-nowrap">Kolom 1</th>
                                <th class="py-2 border-b border-gray-300 text-center px-4 border-r whitespace-nowrap">Kolom 2</th>
                                <th class="py-2 border-b border-gray-300 text-center px-4 border-r whitespace-nowrap">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($data['data_kendaraan']) && count($data['data_kendaraan']) > 0)
                            @foreach ($data['data_kendaraan'] as $index => $row)
                                @if ($index > 0)
                                    <tr id="kendaraan-row-{{ $index }}">
                                        @foreach ($row as $cell)
                                            <td class="py-2 border-b border-gray-300 text-center px-4 border-r whitespace-nowrap">{{ $cell !== null && $cell !== '' ? $cell : '-' }}</td>
                                        @endforeach
                                        <td class="py-2 border-b border-gray-300 text-center px-4 whitespace-nowrap">
                                            <a onclick="editRow('kendaraan', {{ $index }})" class="text-blue-500 hover:text-blue-700 hover:cursor-pointer">Edit</a>
                                            <form action="{{ route('databaseKendaraan.destroy', ['type' => 'kendaraan', 'rowIndex' => $index]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 ml-2 bg-transparent border-none cursor-pointer">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            <tr>
                                <td class="py-2 border-b border-gray-300 text-center px-4" colspan="{{ count($data['data_kendaraan'][0]) }}">Tidak ada data yang tersedia.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Button Tambah -->
<div class="fixed flex justify-center items-center bottom-3 right-4 gap-x-3">
    <button onclick="toggleModal()" class="flex flex-col justify-center items-center bg-green-500 text-white px-6 py-4 rounded-full shadow-sm shadow-black hover:bg-green-700 transition duration-300">
        <i class="fa-solid fa-plus fa-xl mt-3"></i>
        <h1 class="mt-3">TAMBAH</h1>
    </button>
    <!-- Button Print -->
    <a href="https://docs.google.com/spreadsheets/d/1mfB-fDXonpoB34byZ-0UZaT7tOZSt6-4Cg50nd4rs-M/export?format=pdf&gid=2043898895&size=A4&portrait=false&gridlines=false&fzr=false&attachment=false&filename=Database%20Kendaraan" 
    target="_blank" 
    class="flex flex-col justify-center items-center bg-blue-500 text-white px-5 py-4 rounded-full shadow-sm shadow-black hover:bg-blue-700 transition duration-300">
        <i class="fa-solid fa-print fa-xl mt-3"></i>
        <h1 class="mt-3">PRINT</h1>
    </a>
</div>

<!-- Modal Form -->
<div id="modalForm" class="fixed inset-0 flex items-center justify-center z-50 hidden bg-gray-900 bg-opacity-50">
    <div class="bg-white w-full max-w-4xl max-h-[80vh] overflow-y-auto rounded-xl shadow-lg p-6" id="modalContent">
        <h2 class="text-xl font-semibold mb-4">Tambah Data Kendaraan</h2>
        <form action="{{ route('databaseKendaraan.store', ['type' => 'kendaraan']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Form fields start here -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div><label for="nomor_polisi">Nomor Polisi</label><input type="text" name="nomor_polisi" id="nomor_polisi" class="w-full p-2 border"></div>
                <div><label for="nama_pemilik">Nama Pemilik</label><input type="text" name="nama_pemilik" id="nama_pemilik" class="w-full p-2 border"></div>
                <div><label for="alamat">Alamat</label><input type="text" name="alamat" id="alamat" class="w-full p-2 border"></div>
                <div><label for="merk">Merk</label><input type="text" name="merk" id="merk" class="w-full p-2 border"></div>
                <div><label for="type">Type</label><input type="text" name="type" id="type" class="w-full p-2 border"></div>
                <div><label for="jenis">Jenis</label><input type="text" name="jenis" id="jenis" class="w-full p-2 border"></div>
                <div><label for="model">Model</label><input type="text" name="model" id="model" class="w-full p-2 border"></div>
                <div><label for="tahun_pembuatan">Tahun Pembuatan</label><input type="text" name="tahun_pembuatan" id="tahun_pembuatan" class="w-full p-2 border"></div>
                <div><label for="isi_silinder">Isi Silinder</label><input type="text" name="isi_silinder" id="isi_silinder" class="w-full p-2 border"></div>
                <div><label for="nomor_rangka">Nomor Rangka</label><input type="text" name="nomor_rangka" id="nomor_rangka" class="w-full p-2 border"></div>
                <div><label for="nomor_mesin">Nomor Mesin</label><input type="text" name="nomor_mesin" id="nomor_mesin" class="w-full p-2 border"></div>
                <div><label for="warna">Warna</label><input type="text" name="warna" id="warna" class="w-full p-2 border"></div>
                <div><label for="bahan_bakar">Bahan Bakar</label><input type="text" name="bahan_bakar" id="bahan_bakar" class="w-full p-2 border"></div>
                <div><label for="warna_tnkb">Warna TNKB</label><input type="text" name="warna_tnkb" id="warna_tnkb" class="w-full p-2 border"></div>
                <div><label for="tahun_registrasi">Tahun Registrasi</label><input type="text" name="tahun_registrasi" id="tahun_registrasi" class="w-full p-2 border"></div>
                <div><label for="nomor_bpkb">Nomor BPKB</label><input type="text" name="nomor_bpkb" id="nomor_bpkb" class="w-full p-2 border"></div>
                <div><label for="tanggal_berlaku">Tanggal Berlaku</label><input type="date" name="tanggal_berlaku" id="tanggal_berlaku" class="w-full p-2 border"></div>
                <div><label for="bulan_berlaku">Bulan Berlaku</label><input type="text" name="bulan_berlaku" id="bulan_berlaku" class="w-full p-2 border"></div>
                <div><label for="berat">Berat</label><input type="text" name="berat" id="berat" class="w-full p-2 border"></div>
                <div><label for="sumbu">Sumbu</label><input type="text" name="sumbu" id="sumbu" class="w-full p-2 border"></div>
                <div><label for="penumpang">Penumpang</label><input type="text" name="penumpang" id="penumpang" class="w-full p-2 border"></div>
                <div><label for="pengguna">Pengguna</label><input type="text" name="pengguna" id="pengguna" class="w-full p-2 border"></div>
                <div><label for="gambar_depan">Gambar Depan</label><input type="file" name="gambar_depan" id="gambar_depan" class="w-full p-2 border"></div>
                <div><label for="gambar_belakang">Gambar Belakang</label><input type="file" name="gambar_belakang" id="gambar_belakang" class="w-full p-2 border"></div>
                <div><label for="gambar_kanan">Gambar Samping Kanan</label><input type="file" name="gambar_kanan" id="gambar_kanan" class="w-full p-2 border"></div>
                <div><label for="gambar_kiri">Gambar Samping Kiri</label><input type="file" name="gambar_kiri" id="gambar_kiri" class="w-full p-2 border"></div>
            </div>
            <!-- Form actions -->
            <div class="flex justify-end mt-4">
                <button type="button" onclick="toggleModal()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700 transition duration-300">Batal</button>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded ml-2 hover:bg-green-700 transition duration-300">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleModal() {
        const modal = document.getElementById('modalForm');
        modal.classList.toggle('hidden');
    }

    // Menambahkan event listener untuk klik di luar modal
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('modalForm');
        const modalContent = document.getElementById('modalContent');

        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    });
</script>

@endsection
