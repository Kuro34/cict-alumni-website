<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyOption extends Model
{
    use HasFactory;

    protected $primaryKey = 'optionID';
    protected $fillable = ['questionID', 'option_text'];

    public function question()
    {
        return $this->belongsTo(SurveyQuestion::class, 'questionID', 'questionID');
    }
}
