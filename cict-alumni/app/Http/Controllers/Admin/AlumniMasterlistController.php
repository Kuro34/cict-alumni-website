<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AlumniMasterlist;
use App\Models\Program;
use App\Models\Specialization;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;

class AlumniMasterlistController extends Controller
{
    public function index()
    {
        $masterlist = AlumniMasterlist::with(['program', 'specialization'])->paginate(20);
        return view('admin.masterlist.index', compact('masterlist'));
    }

    public function showImportForm()
    {
        return view('admin.masterlist.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        $file = $request->file('file');
        $path = $file->getRealPath();
        $rows = \PhpOffice\PhpSpreadsheet\IOFactory::load($path)->getActiveSheet()->toArray(null, true, true, true);

        DB::beginTransaction();
        try {
            foreach ($rows as $index => $row) {
                if ($index == 1) continue; // skip header

                $program = Program::firstOrCreate(['program_name' => trim($row['G'])]);
                $specialization = Specialization::firstOrCreate([
                    'specialization_name' => trim($row['H']),
                    'programID' => $program->programID,
                ]);

                AlumniMasterlist::updateOrCreate(
                    ['student_number' => trim($row['A'])],
                    [
                        'last_name' => trim($row['B']),
                        'first_name' => trim($row['C']),
                        'middle_name' => trim($row['D']),
                        'birthdate' => trim($row['E']),
                        'gender' => trim($row['F']),
                        'programID' => $program->programID,
                        'specializationID' => $specialization->specializationID,
                        'graduation_year' => trim($row['I']),
                    ]
                );
            }

            DB::commit();
            return back()->with('success', 'Masterlist uploaded successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error uploading file: ' . $e->getMessage());
        }
    }

    public function export()
    {
        $masterlist = AlumniMasterlist::with(['program', 'specialization'])->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header row
        $sheet->setCellValue('A1', 'Student Number');
        $sheet->setCellValue('B1', 'Last Name');
        $sheet->setCellValue('C1', 'First Name');
        $sheet->setCellValue('D1', 'Middle Name');
        $sheet->setCellValue('E1', 'Birthdate');
        $sheet->setCellValue('F1', 'Gender');
        $sheet->setCellValue('G1', 'Program');
        $sheet->setCellValue('H1', 'Specialization');
        $sheet->setCellValue('I1', 'Graduation Year');

        // Data rows
        $rowNum = 2;
        foreach ($masterlist as $alumni) {
            $sheet->setCellValue('A' . $rowNum, $alumni->student_number);
            $sheet->setCellValue('B' . $rowNum, $alumni->last_name);
            $sheet->setCellValue('C' . $rowNum, $alumni->first_name);
            $sheet->setCellValue('D' . $rowNum, $alumni->middle_name);
            $sheet->setCellValue('E' . $rowNum, $alumni->birthdate);
            $sheet->setCellValue('F' . $rowNum, $alumni->gender);
            $sheet->setCellValue('G' . $rowNum, $alumni->program->program_name ?? '');
            $sheet->setCellValue('H' . $rowNum, $alumni->specialization->specialization_name ?? '');
            $sheet->setCellValue('I' . $rowNum, $alumni->graduation_year);
            $rowNum++;
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'alumni_masterlist_' . date('Y-m-d_His') . '.xlsx';

        // Stream the file to the browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        $writer->save('php://output');
        exit;
    }
}
