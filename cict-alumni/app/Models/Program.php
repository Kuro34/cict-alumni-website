<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $primaryKey = 'programID';

    protected $fillable = [
        'program_name',
    ];

    // A Program has many Specializations
    public function specializations()
    {
        return $this->hasMany(Specialization::class, 'programID', 'programID');
    }

    // A Program has many AlumniMasterlist entries
    public function alumni()
    {
        return $this->hasMany(AlumniMasterlist::class, 'programID', 'programID');
    }
}
