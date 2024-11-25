@extends('layouts.main')

@section('container')
<div class="p-4 sm:ml-64">
    <div class="p-4 mt-14">
        <div class="flex justify-start items-center gap-x-2">
            <svg class="flex-shrink-0 w-5 h-5 transition duration-75 {{ $active === 'laporan.kategori' || $active === 'laporan.transaksi' ? 'text-black' : 'text-gray-500 group-hover:text-black' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
            </svg>
            <h1 class="text-2xl font-bold">Laporan Kategori</h1>
        </div>

        {{-- Filter Form --}}
        <div class="bg-white p-6 rounded-lg shadow-md mt-6">
            <h3 id="filter-title" class="text-xl font-bold mb-4 text-gray-700">Pencarian Data</h3>
            <form id="filter-form" action="/laporan/kategori/search" method="POST" class="grid grid-cols-1 gap-6">
                @csrf
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
                        <option value="Pengisian BBM">Pengisian BBM</option>
                        <option value="sServis Rutin">Servis Rutin</option>
                        <option value="Perbaikan">Perbaikan</option>
                        <option value="Pergantian">Pergantian</option>
                        <option value="Bayar Pajak">Bayar Pajak</option>
                        <option value="Emoney">E-money</option>
                        <option value="Bayar Parkir">Bayar Parkir</option>
                    </select>
                </div>

                <div>
                    <label for="kendaraan" class="block text-sm font-medium text-gray-800">Kendaraan</label>
                    <select id="kendaraan" name="kendaraan" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">Semua</option>
                        @foreach ($kendaraan as $item)
                            <option value="{{ $item }}">{{ ucfirst($item) }}</option>
                        @endforeach
                    </select>
                </div>                
 
                <div>
                    <label for="tanggal_laporan" class="block text-sm font-medium text-gray-800">Tanggal Laporan</label>
                    <input type="text" id="tanggal_laporan" name="tanggal_laporan" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm pl-1">
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
            <input type="text" id="new_judul_laporan" name="new_judul_laporan" class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm pl-1" placeholder="Masukkan Judul Baru">
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
                    @php
                        $subtotal = 0;
                    @endphp
                    @foreach ($laporan as $index => $item)
                        <tr>
                            <td class="px-2 py-3 whitespace-nowrap text-center text-sm text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-center text-sm text-gray-500">{{ $item->nomor_polisi }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-center text-sm text-gray-500">{{ $item->tanggal }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-center text-sm text-gray-500">{{ $item->jenis_perawatan }}</td>
                            <td class="px-6 py-3 whitespace-nowrap text-center text-sm text-gray-500">Rp {{ number_format($item->total_biaya, 0, ',', '.') }}</td>
                        </tr>
                        @php
                            $subtotal += $item->total_biaya;
                        @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="px-6 py-3 text-right font-bold text-gray-700">Subtotal</td>
                        <td class="px-6 py-3 text-center font-bold text-gray-700">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    @else
        <div class="mt-5 bg-red-100 p-4 rounded-lg">
            <p class="text-red-600">Tidak ada data yang ditemukan.</p>
        </div>
    @endif
    
    
    </div>
</div>

<div class="fixed flex justify-center items-center bottom-3 right-4 gap-x-3">
    <!-- Button Print -->
    <a href="{{--https://docs.google.com/spreadsheets/d/1mfB-fDXonpoB34byZ-0UZaT7tOZSt6-4Cg50nd4rs-M/export?format=pdf&gid=0&size=A4&portrait=false&gridlines=false&fzr=false&attachment=false&filename=Referensi%20Aplikasi%20Perawatan%20Dan%20Perbaikan%20Kendaraan%20Operasional--}}" 
    target="_blank" 
    class="flex flex-col justify-center items-center bg-blue-500 text-white px-5 py-4 rounded-full shadow-sm shadow-black hover:bg-blue-700 transition duration-300">
        <i class="fa-solid fa-print fa-xl mt-3"></i>
        <h1 class="mt-3">PRINT</h1>
    </a>
</div>

<script>
    // Fungsi untuk toggle periode pilihan
    document.getElementById('periode').addEventListener('change', function() {
        const periodeValue = this.value;
        document.getElementById('bulan-container').style.display = periodeValue === 'bulanan' ? 'block' : 'none';
        document.getElementById('tahun-container').style.display = (periodeValue === 'bulanan' || periodeValue === 'tahunan') ? 'block' : 'none';
    });

    // Inisialisasi flatpickr untuk tanggal laporan
    flatpickr("#tanggal_laporan", {
        dateFormat: "d F Y", // Format tanggal: 10 Oktober 2024
        locale: {
            firstDayOfWeek: 1, // Mulai dari hari Senin
            weekdays: {
                shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
            },
            months: {
                shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            },
        },
    });

    // Tombol untuk mengubah judul laporan
    document.getElementById('ubah-judul-button').addEventListener('click', function() {
        const changeTitleContainer = document.getElementById('change-title-container');
        changeTitleContainer.style.display = changeTitleContainer.style.display === 'none' ? 'block' : 'none';
    });

    // Simpan judul laporan baru
    document.getElementById('save-title-button').addEventListener('click', function() {
        const newTitle = document.getElementById('new_judul_laporan').value;
        if (newTitle) {
            document.getElementById('filter-title').innerText = newTitle;
            document.getElementById('change-title-container').style.display = 'none';
        }
    });

    // Fungsi pencarian laporan berdasarkan kata kunci
    document.getElementById('filter-form').addEventListener('submit', function(e) {
        const searchQuery = document.getElementById('search_query').value.toLowerCase();
        const laporanItems = document.querySelectorAll('#list-laporan li');

        laporanItems.forEach(function(item) {
            const title = item.getAttribute('data-title').toLowerCase();
            if (title.includes(searchQuery)) {
                item.style.display = 'block';  // Tampilkan item jika cocok dengan pencarian
            } else {
                item.style.display = 'none';   // Sembunyikan item jika tidak cocok
            }
        });

        // Form akan disubmit dan halaman akan di-refresh secara default
    });
</script>

@endsection
