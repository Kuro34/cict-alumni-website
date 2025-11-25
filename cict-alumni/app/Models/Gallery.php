<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $primaryKey = 'galleryID';

    protected $fillable = [
        'title',
        'caption',
        'image_path',
        'posted_at',
    ];

    protected $dates = [
        'posted_at',
        'created_at',
        'updated_at',
    ];
}
