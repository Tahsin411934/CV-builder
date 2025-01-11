<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Heading extends Model
{
    use HasFactory;
public $timestamps = true;
    protected $fillable = [
        'image',
        'first_name',
        'surname',
        'profession',
        'city',
        'postal_code',
        'country',
        'phone',
        'email',
    ];
}
