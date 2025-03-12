<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PremiumCv extends Model
{
    use HasFactory;
 protected $table = 'premiumCv';
    protected $fillable = [
        'user_email',
        'selected_template_id',
        'file_path',
        'payment_amount',
        'instruction',
        'additional_info',
        'screenshot_upload', // New field
    ];
}