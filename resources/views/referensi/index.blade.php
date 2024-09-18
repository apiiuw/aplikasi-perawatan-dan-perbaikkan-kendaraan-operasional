@extends('layouts.main')

@section('container')
<div class="p-4 sm:ml-64">
  <div class="p-4 mt-14">
    @if (session('success'))
    <div class="p-4 mb-4 text-green-800 bg-green-100 rounded-lg" role="alert">
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <h1 class="text-2xl font-bold mb-4">Merk Kendaraan</h1>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
      <form action="{{ route('referensi.update') }}" method="POST">
        @csrf
        <button type="button" id="addMerkKendaraan" class="bg-blue-600 text-white font-medium py-2 px-4 rounded hover:bg-blue-700 mb-4">Add Merk Kendaraan</button>
        <table class="w-full text-sm text-left text-gray-500">
          <thead class="text-xs text-white uppercase bg-blue-500">
            <tr>
              <th scope="col" class="px-6 py-3">No</th>
              <th scope="col" class="px-6 py-3">Merk Kendaraan</th>
              <th scope="col" class="px-6 py-3">Actions</th>
            </tr>
          </thead>
          <tbody id="merkKendaraanTableBody">
            @foreach ($merkKendaraanData as $index => $row)
              <tr class="bg-white border-b hover:bg-gray-50">
                <td class="px-6 py-4">{{ $index + 1 }}</td>
                <td class="px-6 py-4">{{ $row['merk'] ?? '' }}</td>
                <td class="px-6 py-4">
                  <button type="button" class="edit-btn bg-yellow-500 text-white py-1 px-3 rounded" data-index="{{ $index }}">Edit</button>
                  <button type="button" class="remove-btn bg-red-600 text-white py-1 px-3 rounded" data-index="{{ $index }}">Remove</button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        <div class="mt-4">
          <button type="submit" class="bg-green-600 text-white font-medium py-2 px-4 rounded hover:bg-green-700">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Popup Modal for Edit -->
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 justify-center items-center hidden">
  <div class="bg-white p-8 rounded-lg shadow-lg">
    <h2 class="text-xl font-bold mb-4">Edit Merk Kendaraan</h2>
    <input type="text" id="editMerkInput" class="w-full p-2 border border-gray-300 rounded mb-4">
    <button id="saveEdit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700">Save</button>
    <button id="closeModal" class="bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700">Close</button>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  let currentEditIndex = null;

  // Handle Add Row
  document.getElementById('addMerkKendaraan').addEventListener('click', function() {
    const tbody = document.getElementById('merkKendaraanTableBody');
    const newIndex = tbody.querySelectorAll('tr').length + 1;
    const newRow = `
      <tr class="bg-white border-b hover:bg-gray-50">
        <td class="px-6 py-4">${newIndex}</td>
        <td class="px-6 py-4"><input type="text" name="merkKendaraanData[${newIndex}][merk]" class="w-full px-2 py-1 border border-gray-300 rounded" /></td>
        <td class="px-6 py-4">
          <button type="button" class="edit-btn bg-yellow-500 text-white py-1 px-3 rounded" data-index="${newIndex}">Edit</button>
          <button type="button" class="remove-btn bg-red-600 text-white py-1 px-3 rounded" data-index="${newIndex}">Remove</button>
        </td>
      </tr>
    `;
    tbody.insertAdjacentHTML('beforeend', newRow);
  });

  // Handle Edit Button
  document.addEventListener('click', function(e) {
    if (e.target.classList.contains('edit-btn')) {
      currentEditIndex = e.target.getAttribute('data-index');
      const row = document.querySelector(`[name="merkKendaraanData[${currentEditIndex}][merk]"]`).value;
      document.getElementById('editMerkInput').value = row;
      document.getElementById('editModal').classList.remove('hidden');
    }
  });

  // Handle Save Edit
  document.getElementById('saveEdit').addEventListener('click', function() {
    const newValue = document.getElementById('editMerkInput').value;
    document.querySelector(`[name="merkKendaraanData[${currentEditIndex}][merk]"]`).value = newValue;
    document.getElementById('editModal').classList.add('hidden');
  });

  // Handle Remove Row
  document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-btn')) {
      e.target.closest('tr').remove();
    }
  });

  // Close Modal
  document.getElementById('closeModal').addEventListener('click', function() {
    document.getElementById('editModal').classList.add('hidden');
  });
});
</script>
@endsection
