<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvTemplate extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the default (optional)
   protected $table = 'cv_templates';

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'image',
        'title',
        'description',
    ];
    public $timestamps = false;
}
