<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPostingRequest extends Model
{
    use HasFactory;

    protected $table = 'job_posting_requests';

    protected $fillable = [
        'company_name',
        'company_email',
        'company_address',
        'contact_number',
        'contact_person',
        'company_website',
        'company_type',
        'message',
        'agreed_privacy_policy',
    ];
}
