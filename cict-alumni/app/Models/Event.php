<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $primaryKey = 'eventID';
    protected $fillable = ['adminID', 'title', 'description', 'event_date', 'location', 'banner_image'];

    public function admin() { return $this->belongsTo(Admin::class, 'adminID'); }
    public function registrations() { return $this->hasMany(EventRegistration::class, 'eventID'); }
}
