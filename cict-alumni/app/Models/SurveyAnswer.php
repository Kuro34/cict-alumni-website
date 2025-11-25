<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
    use HasFactory;

    protected $primaryKey = 'answerID';
    protected $fillable = ['responseID', 'questionID', 'answer'];

    public function response()
    {
        return $this->belongsTo(SurveyResponse::class, 'responseID', 'responseID');
    }

    public function question()
    {
        return $this->belongsTo(SurveyQuestion::class, 'questionID', 'questionID');
    }
}
