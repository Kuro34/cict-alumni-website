<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPosting extends Model
{
    protected $primaryKey = 'jobID';
    protected $fillable = ['adminID', 'title', 'description', 'location', 'company', 'category'];

    public function admin() { return $this->belongsTo(Admin::class, 'adminID'); }
    public function applications() { return $this->hasMany(JobApplication::class, 'jobID'); }
    
    public function bookmarkedBy()
    {
        return $this->belongsToMany(
            Alumni::class,
            'bookmarks',
            'jobID',
            'alumniID'
        )->withTimestamps();
    }
    }
