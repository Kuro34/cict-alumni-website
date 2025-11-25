<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Raffle extends Model
{
    protected $primaryKey = 'raffleID';
    protected $fillable = ['adminID', 'title', 'description', 'eventID'];

    public function admin() { return $this->belongsTo(Admin::class, 'adminID'); }
    public function event() { return $this->belongsTo(Event::class, 'eventID'); }
    public function entries() { return $this->hasMany(RaffleEntry::class, 'raffleID'); }
}
