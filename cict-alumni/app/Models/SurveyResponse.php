<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    use HasFactory;

    protected $primaryKey = 'responseID';

    protected $fillable = [
        'surveyID',
        'alumniID',
        'completed',
        'completed_at',
        'points_earned',
        'sheet_url'
    ];

    // ✅ This makes completed_at a Carbon date
    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'surveyID', 'surveyID');
    }

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'alumniID', 'alumniID');
    }

    public function answers()
    {
        return $this->hasMany(SurveyAnswer::class, 'responseID', 'responseID');
    }
}
