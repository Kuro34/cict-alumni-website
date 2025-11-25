<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    use HasFactory;

    protected $primaryKey = 'questionID';
    protected $fillable = ['surveyID', 'question_text', 'question_type']; // fixed column name

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'surveyID', 'surveyID');
    }

    public function options()
    {
        return $this->hasMany(SurveyOption::class, 'questionID', 'questionID');
    }

    public function answers()
    {
        return $this->hasMany(SurveyAnswer::class, 'questionID', 'questionID');
    }
}
