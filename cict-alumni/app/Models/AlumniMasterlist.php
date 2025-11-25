<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniMasterlist extends Model
{
    use HasFactory;

    protected $table = 'alumni_masterlist';
    protected $primaryKey = 'masterlistID';

    protected $fillable = [
        'student_number',
        'last_name',
        'first_name',
        'middle_name',
        'auxiliary',
        'birthdate',
        'gender',
        'programID',
        'specializationID',
        'graduation_year',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, 'programID', 'programID');
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class, 'specializationID', 'specializationID');
    }
}
