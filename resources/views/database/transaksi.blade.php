@extends('layouts.main')

@section('container')
<div class="p-4 sm:ml-64">
    <div class="p-4 mt-14">
        <div class="container mx-auto p-4">
            <div class="flex justify-start items-center mb-4 gap-x-2">
                <i class="fa-solid fa-file-invoice-dollar fa-xl"></i>
                <h1 class="text-2xl font-bold">Data Transaksi</h1>
            </div>

            <div class="overflow-x-auto">
                <table id="transaksi-table" class="min-w-full bg-white border border-gray-300 mb-4 mx-4" style="border-collapse: collapse;">
                    <thead>
                        <tr>
                            @if (isset($data['data_transaksi'][0]))
                                @foreach ($data['data_transaksi'][0] as $header)
                                    <th class="py-2 border-b border-gray-300 text-center px-4 border-r whitespace-nowrap">{{ $header }}</th>
                                @endforeach
                            @else
                                <th class="py-2 border-b border-gray-300 text-center px-4 border-r whitespace-nowrap">Kolom 1</th>
                                <th class="py-2 border-b border-gray-300 text-center px-4 border-r whitespace-nowrap">Kolom 2</th>
                                <th class="py-2 border-b border-gray-300 text-center px-4 border-r whitespace-nowrap">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($data['data_transaksi']) && count($data['data_transaksi']) > 0)
                            @foreach ($data['data_transaksi'] as $index => $row)
                                @if ($index > 0)
                                    <tr id="transaksi-row-{{ $index }}">
                                        @foreach ($row as $cell)
                                            <td class="py-2 border-b border-gray-300 text-center px-4 border-r whitespace-nowrap">
                                                {{ $cell !== null && $cell !== '' ? (is_numeric($cell) ? number_format($cell, 0, ',', '.') : $cell) : '-' }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            <tr>
                                <td class="py-2 border-b border-gray-300 text-center px-4" colspan="{{ count($data['data_transaksi'][0]) }}">Tidak ada data yang tersedia.</td>
                            </tr>
                        @endif
                    </tbody>                    
                </table>
            </div>
        </div>
    </div>
</div>

<div class="fixed flex justify-center items-center bottom-3 right-4 gap-x-3">
    <!-- Button Print -->
    <a href="https://docs.google.com/spreadsheets/d/1mfB-fDXonpoB34byZ-0UZaT7tOZSt6-4Cg50nd4rs-M/export?format=pdf&gid=655560585&size=A4&portrait=false&gridlines=false&fzr=false&attachment=false&filename=Database%20Transaksi" 
    target="_blank" 
    class="flex flex-col justify-center items-center bg-blue-500 text-white px-5 py-4 rounded-full shadow-sm shadow-black hover:bg-blue-700 transition duration-300">
        <i class="fa-solid fa-print fa-xl mt-3"></i>
        <h1 class="mt-3">PRINT</h1>
    </a>
</div>

@endsection
