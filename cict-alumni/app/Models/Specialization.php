<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    use HasFactory;

    protected $primaryKey = 'specializationID';

    protected $fillable = [
        'programID',
        'specialization_name',
    ];

    // A Specialization belongs to a Program
    public function program()
    {
        return $this->belongsTo(Program::class, 'programID', 'programID');
    }

    // A Specialization has many AlumniMasterlist entries
    public function alumni()
    {
        return $this->hasMany(AlumniMasterlist::class, 'specializationID', 'specializationID');
    }
}
