<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    // Specify the table name (optional if table name matches model name)
    protected $table = 'experience';
    public $timestamps = false;
    // Define the fillable fields
    protected $fillable = [
        'job_title',
        'employer',
        'start_date',
        'end_date',
        'current_work',
        'short_description',
        'user_email',
    ];
}
