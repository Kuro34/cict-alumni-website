<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointTransaction extends Model
{
    protected $primaryKey = 'transactionID';
    protected $fillable = ['alumniID', 'change', 'reason'];

    public function alumni() {
        return $this->belongsTo(Alumni::class, 'alumniID');
    }
}
