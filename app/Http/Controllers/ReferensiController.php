<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ReferensiController extends Controller
{
    public function show()
    {
        $filePath = public_path('assets/documents/excels/DOKUMEN APLIKASI.xlsx');
        $spreadsheet = IOFactory::load($filePath);

        $referensiSheet = $spreadsheet->getSheet(0)->toArray(null, true, true, true);

        $merkKendaraanData = array_filter(array_map(function($row) {
            return [
                'no' => isset($row['A']) ? $row['A'] : null,
                'merk' => isset($row['B']) ? $row['B'] : null
            ];
        }, $referensiSheet), function($row) {
            return !empty($row['no']) || !empty($row['merk']);
        });

        $jenisKendaraanData = array_filter(array_map(function($row) {
            return [
                'no' => isset($row['D']) ? $row['D'] : null,
                'jenisKendaraan' => isset($row['E']) ? $row['E'] : null
            ];
        }, $referensiSheet), function($row) {
            return !empty($row['no']) || !empty($row['jenisKendaraan']);
        });

        return view('referensi.index', [
            'merkKendaraanData' => $merkKendaraanData,
            'jenisKendaraanData' => $jenisKendaraanData,
            'active' => 'referensi',
            'title' => 'Referensi',
        ]);
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'merkKendaraanData.*.merk' => 'nullable|string|max:255',
            'jenisKendaraanData.*.jenisKendaraan' => 'nullable|string|max:255',
        ]);

        $merkKendaraanData = $request->input('merkKendaraanData', []);
        $jenisKendaraanData = $request->input('jenisKendaraanData', []);

        $filePath = public_path('assets/documents/excels/DOKUMEN APLIKASI.xlsx');
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getSheet(0);

        // Update data di sheet
        $rowNumber = 2; // Start from row 2 to skip header
        foreach ($merkKendaraanData as $data) {
            $sheet->setCellValue('A' . $rowNumber, $rowNumber - 1); // Set number automatically
            $sheet->setCellValue('B' . $rowNumber, $data['merk'] ?? '');
            $rowNumber++;
        }

        $rowNumber = 2; // Start from row 2 to skip header
        foreach ($jenisKendaraanData as $data) {
            $sheet->setCellValue('D' . $rowNumber, $rowNumber - 1); // Set number automatically
            $sheet->setCellValue('E' . $rowNumber, $data['jenisKendaraan'] ?? '');
            $rowNumber++;
        }

        // Simpan file yang sudah diperbarui
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($filePath);

        return redirect()->route('referensi.show')->with('success', 'Data updated successfully');
    }

    public function add(Request $request)
    {
        $filePath = public_path('assets/documents/excels/DOKUMEN APLIKASI.xlsx');
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getSheet(0);

        $merkKendaraanData = $request->input('merkKendaraanData', []);
        $jenisKendaraanData = $request->input('jenisKendaraanData', []);

        $rowNumber = $sheet->getHighestRow() + 1; // Next available row
        foreach ($merkKendaraanData as $data) {
            if (empty($data['merk'])) continue; // Skip empty rows
            $sheet->setCellValue('A' . $rowNumber, $rowNumber - 1); // Set number automatically
            $sheet->setCellValue('B' . $rowNumber, $data['merk']);
            $rowNumber++;
        }

        $rowNumber = $sheet->getHighestRow() + 1; // Next available row
        foreach ($jenisKendaraanData as $data) {
            if (empty($data['jenisKendaraan'])) continue; // Skip empty rows
            $sheet->setCellValue('D' . $rowNumber, $rowNumber - 1); // Set number automatically
            $sheet->setCellValue('E' . $rowNumber, $data['jenisKendaraan']);
            $rowNumber++;
        }

        // Simpan file yang sudah diperbarui
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($filePath);

        return redirect()->route('referensi.show')->with('success', 'Data added successfully');
    }

    public function remove(Request $request)
    {
        $filePath = public_path('assets/documents/excels/DOKUMEN APLIKASI.xlsx');
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getSheet(0);

        $merkKendaraanIndexes = $request->input('merkKendaraanIndexes', []);
        $jenisKendaraanIndexes = $request->input('jenisKendaraanIndexes', []);

        foreach ($merkKendaraanIndexes as $index) {
            $sheet->removeRow($index + 1); // Adjust for header row
        }

        foreach ($jenisKendaraanIndexes as $index) {
            $sheet->removeRow($index + 1); // Adjust for header row
        }

        // Simpan file yang sudah diperbarui
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($filePath);

        return redirect()->route('referensi.show')->with('success', 'Data removed successfully');
    }
}
