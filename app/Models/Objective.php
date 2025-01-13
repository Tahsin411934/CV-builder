<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objective extends Model
{
    use HasFactory;

    // Define the table name (optional if it matches the default convention)
    protected $table = 'objective';
    public $timestamps = false;
    // Define the fillable fields
    protected $fillable = ['objective', 'user_email'];
}
