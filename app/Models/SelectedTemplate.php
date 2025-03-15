<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectedTemplate extends Model
{
    use HasFactory;
    protected $table = 'selectedtamplate'; 
    public $timestamps = false;
    protected $fillable = ['tamplate_id', 'user_email']; 
}
