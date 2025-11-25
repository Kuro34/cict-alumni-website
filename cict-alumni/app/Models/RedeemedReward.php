<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RedeemedReward extends Model
{
    protected $table = 'redeemed_rewards';
    protected $fillable = ['alumniID', 'rewardID', 'redeemed_at'];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'alumniID', 'alumniID');
    }

    public function reward()
    {
        return $this->belongsTo(Reward::class, 'rewardID', 'rewardID');
    }
}
