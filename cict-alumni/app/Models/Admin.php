<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'adminID';
    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password'];

    public function events() { return $this->hasMany(Event::class, 'adminID'); }
    public function surveys() { return $this->hasMany(Survey::class, 'adminID'); }
    public function jobPostings() { return $this->hasMany(JobPosting::class, 'adminID'); }
    public function raffles() { return $this->hasMany(Raffle::class, 'adminID'); }
}