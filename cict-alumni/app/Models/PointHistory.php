<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointHistory extends Model
{
    use HasFactory;

    protected $table = 'point_histories'; // Table name

    protected $primaryKey = 'id'; // Primary key

    protected $fillable = [
        'alumniID',
        'adminID',
        'points_changed',
        'reason',
    ];

    // Optional: if you want to automatically cast created_at and updated_at to Carbon instances
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Get the alumni associated with this point history entry.
     */
    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'alumniID', 'alumniID');
    }

    /**
     * Get the admin who made this adjustment.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'adminID', 'adminID');
    }
}
