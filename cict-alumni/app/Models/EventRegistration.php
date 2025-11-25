<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRegistration extends Model
{
    protected $primaryKey = 'registrationID';
    protected $fillable = ['eventID', 'alumniID'];

    public function event() { return $this->belongsTo(Event::class, 'eventID'); }
    public function alumni() { return $this->belongsTo(Alumni::class, 'alumniID'); }
}
