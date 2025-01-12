<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    // Specify the table name (if not using the default plural naming convention)
    protected $table = 'educations';

    // Specify the fields that can be mass assigned
    protected $fillable = [
        'name_of_institute',
        'name_of_exam',
        'institute',
        'board',
        'CGPA',
        'user_mail',
    ];
    public $timestamps = false;
    // Specify any fields that should be cast to specific data types
    protected $casts = [
        'CGPA' => 'float',
    ];
}
