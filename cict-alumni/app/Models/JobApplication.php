<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $primaryKey = 'applicationID';
    protected $fillable = ['jobID', 'alumniID', 'cover_letter', 'resume_path'];

    public function job() { return $this->belongsTo(JobPosting::class, 'jobID'); }
    public function alumni() { return $this->belongsTo(Alumni::class, 'alumniID'); }
}
