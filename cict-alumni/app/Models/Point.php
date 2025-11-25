<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $table = 'points';
    protected $primaryKey = 'pointID';
    protected $fillable = ['alumniID', 'total_points'];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'alumniID');
    }
}


