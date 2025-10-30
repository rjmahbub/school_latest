<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelController extends Controller
{
    public function showForm()
    {
        return view('excel.excel-upload');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('file');

        // Load spreadsheet
        $spreadsheet = IOFactory::load($file->getPathname());
        $students = $spreadsheet->getActiveSheet()->toArray();

        // echo '<pre>';
        // print_r($sheetData);
        // echo '</pre>';

        // Pass data to view
        return view('excel.admit', compact('students'));
    }
}
