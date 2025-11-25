<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointRedemption extends Model
{
    protected $primaryKey = 'redemptionID';
    protected $fillable = ['alumniID', 'rewardID', 'raffleID', 'points_used'];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'alumniID');
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class, 'rewardID');
    }

    public function raffle()
    {
        return $this->belongsTo(Raffle::class, 'raffleID');
    }
}
