<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alumni extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'alumni';
    protected $primaryKey = 'alumniID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'student_number',      // new
        'last_name',
        'first_name',
        'middle_name',         // renamed from middle_initial
        'auxiliary_name',      // can be null
        'birthdate',           // renamed from age
        'gender',
        'civil_status',        // new
        'program',             // renamed from degree_program
        'specialization',      // new column
        'graduation_year',
        'employment_status',   // renamed from current_job
        'address',
        'country',             // new
        'region',              // new
        'province',            // new
        'city',                // keep city as is
        'postal_code',         // new
        'phone_number',
        'email',
        'password',
        'answered_alumni_tracer', // new
    ];

    protected $hidden = [
        'password',
    ];

    // ------------------------
    // Relationships
    // ------------------------

    public function bookmarkedJobs()
    {
        return $this->belongsToMany(JobPosting::class, 'job_bookmarks', 'alumniID', 'jobID')
                    ->withTimestamps();
    }

    public function eventRegistrations()
    {
        return $this->hasMany(EventRegistration::class, 'alumniID');
    }

    public function raffleEntries()
    {
        return $this->hasMany(RaffleEntry::class, 'alumniID');
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class, 'alumniID');
    }

    public function points()
    {
        return $this->hasMany(Point::class, 'alumniID'); 
    }

    public function pointRedemptions()
    {
        return $this->hasMany(PointRedemption::class, 'alumniID', 'alumniID');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'alumniID');
    }

    public function surveyResponses()
    {
        return $this->hasMany(SurveyResponse::class, 'alumniID', 'alumniID');
    }

    public function rewardsRedeemed()
    {
        return $this->hasMany(\App\Models\RedeemedReward::class, 'alumniID', 'alumniID');
    }

    public function getTotalPointsAttribute()
    {
        return $this->points()->sum('total_points');
    }

    public function getRewardsRedeemedWithRewardAttribute()
    {
        return $this->rewardsRedeemed()->with('reward')->get();
    }

    public function getRafflesEnteredAttribute()
    {
        return $this->raffleEntries()->with('raffle')->get();
    }
}
