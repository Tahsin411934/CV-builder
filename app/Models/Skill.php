<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    // Define the table name if it does not follow Laravel's default naming convention
    protected $table = 'skills';

    // Define the fillable attributes
    protected $fillable = [
        'hard_skills',
        'soft_skills',
        'user_email',
    ];

    // If you're using timestamps, ensure this is set to true (Laravel defaults to true)
    public $timestamps = false; // Set to false if you're not using timestamps (created_at/updated_at)
}
