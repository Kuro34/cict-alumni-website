<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $primaryKey = 'notificationID';
    protected $fillable = [
        'adminID',
        'title',
        'description',
        'image_path',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'adminID');
    }
}
