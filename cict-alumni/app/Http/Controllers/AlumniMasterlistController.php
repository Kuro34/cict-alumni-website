<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlumniMasterlist;
use App\Models\Program;
use App\Models\Specialization;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class AlumniMasterlistController extends Controller
{
    
    public function collection(Collection $rows)
    {
        dd("IMPORT TRIGGERED", $rows->count());
    }
    // Show import form
    public function showImportForm()
    {
        return view('admin.masterlist.import');
    }

    // Import Excel / CSV file
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
    
        $file = $request->file('file');
        $path = $file->getRealPath();
    
        // Load spreadsheet rows (first row becomes array keys)
        $rows = IOFactory::load($path)->getActiveSheet()->toArray(null, true, true, false);
        
        dd($rows[2]);
    
        DB::beginTransaction();
        try {
            foreach ($rows as $index => $row) {
    
                if ($index == 0) continue; // Skip header row
    
                // Use the actual column names
                $studentNumber   = $row['Student Number'] ?? null;
                $lastName        = $row['Last Name'] ?? null;
                $firstName       = $row['First Name'] ?? null;
                $middleName      = $row['Middle Name'] ?? null;
                $auxiliaryName   = $row['Auxiliary Name'] ?? null;
                $birthdate       = $row['Birthdate'] ?? null;
                $gender          = $row['Gender'] ?? null;
                $programName     = $row['Program'] ?? null;
                $specializationName = $row['Specialization'] ?? null;
                $graduationYear  = $row['Graduation Year'] ?? null;
    
                if (!$studentNumber) continue;
    
                // Create or find Program
                $program = Program::firstOrCreate([
                    'program_name' => $programName ?: '—'
                ]);
    
                // Create or find Specialization
                $specialization = Specialization::firstOrCreate([
                    'specialization_name' => $specializationName ?: '—',
                    'programID' => $program->programID
                ]);
    
                // Insert / update masterlist record
                AlumniMasterlist::updateOrCreate(
                    ['student_number' => $studentNumber],
                    [
                        'last_name'        => $lastName,
                        'first_name'       => $firstName,
                        'middle_name'      => $middleName,
                        'auxiliary'        => $auxiliaryName,
                        'birthdate'        => $birthdate,
                        'gender'           => $gender,
                        'programID'        => $program->programID,
                        'specializationID' => $specialization->specializationID,
                        'graduation_year'  => $graduationYear,
                    ]
                );
            }
    
            DB::commit();
            return back()->with('success', 'Masterlist uploaded successfully!');
    
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Masterlist import error: '.$e->getMessage());
            return back()->with('error', 'Import failed: '.$e->getMessage());
        }
    }


    // View Masterlist
    public function index()
    {
        $masterlist = AlumniMasterlist::paginate(20);
        return view('admin.masterlist.index', compact('masterlist'));
    }

    // Placeholder for export
    public function export()
    {
        return back()->with('success', 'Export functionality not implemented yet.');
    }
}
