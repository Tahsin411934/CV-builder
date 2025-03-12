<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test1 extends Model
{
    use HasFactory;
    protected $table = 'test1';  // The table associated with the model
    protected $fillable = ['image'];  // The fields that are mass assignable
    public $timestamps = false;
}
