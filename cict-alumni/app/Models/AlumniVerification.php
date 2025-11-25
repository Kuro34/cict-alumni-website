<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class AlumniVerification extends Model
{
    protected $primaryKey = 'verificationID';
    protected $fillable = ['email', 'otp', 'expires_at'];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'alumniID');
    }

    public function isExpired()
    {
        return Carbon::now()->greaterThan($this->expires_at);
    }
}

