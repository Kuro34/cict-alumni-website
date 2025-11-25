<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RaffleEntry extends Model
{
    protected $primaryKey = 'entryID';
    protected $fillable = ['raffleID', 'alumniID', 'points_used'];

    public function raffle() { return $this->belongsTo(Raffle::class, 'raffleID'); }
    public function alumni() { return $this->belongsTo(Alumni::class, 'alumniID'); }
}
