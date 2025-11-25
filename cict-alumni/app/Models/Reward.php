<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $primaryKey = 'rewardID';

    // Include 'image' in fillable
    protected $fillable = ['adminID', 'name', 'description', 'point_cost', 'raffleID', 'image'];

    public function admin() { 
        return $this->belongsTo(Admin::class, 'adminID'); 
    }

    public function redemptions() { 
        return $this->hasMany(PointRedemption::class, 'rewardID'); 
    }

    public function raffle() { 
        return $this->belongsTo(Raffle::class, 'raffleID', 'raffleID'); 
    }
}
