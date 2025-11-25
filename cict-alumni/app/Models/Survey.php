<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $primaryKey = 'surveyID';
    protected $fillable = [
        'adminID',
        'title',
        'description',
        'status',
        'points',
        'expected_duration',
        'form_url',
        'start_date',
        'end_date'
    ];


    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class, 'surveyID', 'surveyID');
    }

    public function responses()
    {
        return $this->hasMany(SurveyResponse::class, 'surveyID', 'surveyID');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'adminID', 'adminID');
    }
}
