@extends('layouts.main')

@section('container')
<div class="p-4 sm:ml-64">
    <div class="p-4 mt-14">
        <h2 class="text-3xl font-bold text-gray-800">Laporan Kategori</h2>

        {{-- Filter Form --}}
        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h3 id="filter-title" class="text-xl font-semibold mb-4 text-gray-700">Pencarian Data</h3>
            <form id="filter-form" class="grid grid-cols-1 gap-6">

                <div class="grid grid-cols-3 gap-6">
                    <div>
                        <label for="periode" class="block text-sm font-medium text-gray-800">Periode</label>
                        <select id="periode" name="periode" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">Semua</option>
                            <option value="bulanan">Bulanan</option>
                            <option value="tahunan">Tahunan</option>
                        </select>
                    </div>
                
                    <div id="bulan-container" class="hidden">
                        <label for="bulan" class="block text-sm font-medium text-gray-800">Bulan</label>
                        <select id="bulan" name="bulan" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">Pilih Bulan</option>
                            @foreach (['januari', 'februari', 'maret', 'april', 'mei', 'juni', 'juli', 'agustus', 'september', 'oktober', 'november', 'desember'] as $bulan)
                                <option value="{{ $bulan }}">{{ ucfirst($bulan) }}</option>
                            @endforeach
                        </select>
                    </div>
                
                    <div id="tahun-container" class="hidden">
                        <label for="tahun" class="block text-sm font-medium text-gray-800">Tahun</label>
                        <select id="tahun" name="tahun" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">Pilih Tahun</option>
                            @for ($year = date('Y'); $year >= 2000; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div>
                    <label for="jenis_perawatan" class="block text-sm font-medium text-gray-800">Jenis Perawatan</label>
                    <select id="jenis_perawatan" name="jenis_perawatan" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">Semua</option>
                        <option value="pengisian-bbm">Pengisian BBM</option>
                        <option value="servis-rutin">Servis Rutin</option>
                        <option value="perbaikan">Perbaikan</option>
                        <option value="pergantian">Pergantian</option>
                        <option value="bayar-pajak">Bayar Pajak</option>
                        <option value="emoney">E-money</option>
                        <option value="bayar-parkir">Bayar Parkir</option>
                    </select>
                </div>

                <div>
                    <label for="kendaraan" class="block text-sm font-medium text-gray-800">Kendaraan</label>
                    <select id="kendaraan" name="kendaraan" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">Semua</option>
                        @foreach (['kendaraan1', 'kendaraan2'] as $kendaraan)
                            <option value="{{ $kendaraan }}">{{ ucfirst($kendaraan) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="tanggal_laporan" class="block text-sm font-medium text-gray-800">Tanggal Laporan</label>
                    <input type="date" id="tanggal_laporan" name="tanggal_laporan" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>

                <div class="flex flex-col items-end">
                    <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-300">
                        Cari
                    </button>

                    <button type="button" id="ubah-judul-button" class="mt-2 w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition ease-in-out duration-300">
                        Ubah Judul Laporan
                    </button>
                </div>
            </form>
        </div>

        {{-- Input Field for New Title (Hidden by default) --}}
        <div id="change-title-container" class="hidden mt-5 bg-white p-4 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Ubah Judul Laporan</h3>
            <input type="text" id="new_judul_laporan" name="new_judul_laporan" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Masukkan Judul Baru">
            <button id="save-title-button" class="mt-2 w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-300">
                Simpan Judul
            </button>
        </div>    

        {{-- Hasil Filter --}}
        <div class="mt-5 bg-gray-50 p-4 rounded-lg shadow-md">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Hasil Filter</h3>
            <div class="flex space-x-4">
                <div class="flex-1 border border-blue-500 p-2 rounded-md">
                    <p>Total Seluruh Data: <span id="total-data" class="font-medium text-blue-600">{{ count($laporan) }}</span></p>
                </div>
                <div class="flex-1 border border-blue-500 p-2 rounded-md">
                    <p>Jumlah Data yang Dicari: <span id="filtered-data" class="font-medium text-blue-600">0</span></p>
                </div>
            </div>
        </div>

        {{-- Tabel Laporan --}}
        @if($laporan && count($laporan) > 0)
            <div class="mt-5 overflow-hidden border border-gray-200 rounded-lg shadow-md">
                <table class="min-w-full divide-y divide-gray-200 bg-white">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Polisi</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Perawatan</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Total Biaya</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($laporan as $index => $item)
                            <tr>
                                <td class="px-2 py-3 whitespace-nowrap text-center text-sm text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-center text-sm text-gray-500">{{ $item->nomor_polisi }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-center text-sm text-gray-500">{{ $item->tanggal }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-center text-sm text-gray-500">{{ $item->jenis_perawatan }}</td>
                                <td class="px-6 py-3 whitespace-nowrap text-center text-sm text-gray-500">Rp {{ number_format($item->total_biaya, 0, ',', '.') }}</td>                                
                            </tr>
                        @endforeach
                    </tbody>                                
                </table>
            </div>
        @else
            <div class="mt-5 bg-red-100 p-4 rounded-lg">
                <p class="text-red-600">Tidak ada data yang ditemukan.</p>
            </div>
        @endif
    </div>
</div>
<script>
    document.getElementById('periode').addEventListener('change', function() {
        const periodeValue = this.value;
        document.getElementById('bulan-container').style.display = periodeValue === 'bulanan' ? 'block' : 'none';
        document.getElementById('tahun-container').style.display = (periodeValue === 'bulanan' || periodeValue === 'tahunan') ? 'block' : 'none';
    });

    document.getElementById('ubah-judul-button').addEventListener('click', function() {
        const changeTitleContainer = document.getElementById('change-title-container');
        changeTitleContainer.classList.toggle('hidden');
    });

    document.getElementById('save-title-button').addEventListener('click', function() {
        const newTitle = document.getElementById('new_judul_laporan').value;
        if (newTitle) {
            document.getElementById('filter-title').innerText = newTitle;
            document.getElementById('change-title-container').classList.add('hidden');
        }
    });
</script>
@endsection
