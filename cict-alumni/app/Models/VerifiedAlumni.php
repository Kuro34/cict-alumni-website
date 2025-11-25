<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifiedAlumni extends Model
{
    use HasFactory;

    protected $table = 'verified_alumni';
    protected $primaryKey = 'verifiedID';
    public $timestamps = false;

    protected $fillable = [
        'student_number',
        'last_name',
        'first_name',
        'middle_name',
        'birthdate',
        'gender',
        'program_id',
        'specialization_id',
        'graduation_year'
    ];
}
