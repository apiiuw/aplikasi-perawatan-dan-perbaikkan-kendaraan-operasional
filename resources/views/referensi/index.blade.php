@extends('layouts.main')

@section('container')
<div class="p-4 sm:ml-64">
    <div class="p-4 mt-14">
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold mb-4">Data Referensi</h1>

            @foreach(['merk_kendaraan', 'jenis_perawatan', 'bahan_bakar', 'bulan', 'tahun'] as $type)
                <h2 class="text-xl font-semibold mb-2">{{ ucfirst(str_replace('_', ' ', $type)) }}</h2>
                <table id="{{ $type }}-table" class="min-w-full bg-white border border-gray-300 mb-4">
                    <thead>
                        <tr>
                            @if (isset($data[$type][0]))
                                @foreach ($data[$type][0] as $header)
                                    <th class="py-2 px-4 border-b">{{ $header }}</th>
                                @endforeach
                                <th class="py-2 px-4 border-b">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data[$type] as $index => $row)
                            @if ($index > 0)
                                <tr id="{{ $type }}-row-{{ $index }}">
                                    @foreach ($row as $cell)
                                        <td class="py-2 px-4 border-b text-center">{{ $cell }}</td>
                                    @endforeach
                                    <td class="py-2 px-4 border-b text-center">
                                        <!-- Edit dan Hapus -->
                                        <a onclick="editRow('{{ $type }}', {{ $index }})" class="text-blue-500 hover:text-blue-700 hover:cursor-pointer">Edit</a>
                                        <form action="{{ route('referensi.destroy', ['type' => $type, 'rowIndex' => $index]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 ml-2 bg-transparent border-none cursor-pointer">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>

                <!-- Form untuk menambah data -->
                <form id="{{ $type }}-form" action="{{ route('referensi.store', $type) }}" method="POST" class="mb-8 flex justify-center">
                    @csrf
                    @foreach($data[$type][0] as $key => $header)
                        @if ($key > 0) <!-- Jangan tampilkan input untuk nomor otomatis -->
                            <input type="text" name="column{{ $key }}" placeholder="Ketikkan {{ strtolower($header) }}..." class="p-2 border border-gray-300 rounded" required>
                        @endif
                    @endforeach                
                    <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded">Tambah Data</button>
                </form>
            @endforeach
        </div>
    </div>
</div>

<!-- Button Print -->
<a href="https://docs.google.com/spreadsheets/d/1mfB-fDXonpoB34byZ-0UZaT7tOZSt6-4Cg50nd4rs-M/export?format=pdf&gid=0&portrait=false&gridlines=false&fzr=false&attachment=false&filename=Referensi%20Aplikasi%20Perawatan%20Dan%20Perbaikan%20Kendaraan%20Operasional" 
   target="_blank" 
   class="fixed flex flex-col justify-center items-center bottom-4 right-4 bg-blue-500 text-white px-4 py-4 rounded-full shadow-lg hover:bg-blue-700 transition duration-300">
    <i class="fa-solid fa-print fa-xl mt-3"></i>
    <h1 class="mt-3">PRINT</h1>
</a>

{{-- <!-- Button Print -->
<a href="https://docs.google.com/spreadsheets/d/1mfB-fDXonpoB34byZ-0UZaT7tOZSt6-4Cg50nd4rs-M/export?format=pdf&gid=0&gridlines=false&notes=false" 
   target="_blank" 
   class="fixed flex flex-col justify-center items-center bottom-4 right-4 bg-blue-500 text-white px-4 py-4 rounded-full shadow-lg hover:bg-blue-700 transition duration-300">
    <i class="fa-solid fa-print fa-xl mt-3"></i>
    <h1 class="mt-3">PRINT</h1>
</a> --}}

<script>
function editRow(type, index) {
    const row = document.getElementById(`${type}-row-${index}`);
    const cells = row.getElementsByTagName('td');
    const form = document.getElementById(`${type}-form`);

    if (form) {
        form.innerHTML = ''; // Kosongkan form sebelum menambah input
        // Tambahkan input hidden untuk CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        for (let i = 1; i < cells.length - 1; i++) { // Mulai dari index 1 untuk mengabaikan nomor dan kolom aksi
            const cellValue = cells[i].innerText;
            const input = document.createElement('input');
            input.type = 'text';
            input.name = `column${i+1}`;
            input.value = cellValue;
            input.placeholder = `Ketikkan data ${i+1}`;
            input.className = 'p-2 border border-gray-300 rounded';
            form.appendChild(input);
        }

        const submitButton = document.createElement('button');
        submitButton.type = 'submit';
        submitButton.className = 'ml-2 px-4 py-2 bg-green-500 text-white rounded';
        submitButton.innerText = 'Simpan';
        form.appendChild(submitButton);
        form.action = `{{ url('/referensi/update') }}/${type}/${index}`; // Update URL action
    }
}
</script>
@endsection
