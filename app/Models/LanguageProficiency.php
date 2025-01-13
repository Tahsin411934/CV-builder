<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LanguageProficiency extends Model
{
    use HasFactory;
    public $timestamps = false;
    // Table name (Laravel will automatically infer the table name from the model name, but this is explicitly stated here)
    protected $table = 'language_proficiency';

    // The primary key for the model (this is optional, as Laravel will use 'id' by default)
    protected $primaryKey = 'id';

    // Make sure to allow these fields to be mass-assigned
    protected $fillable = ['Language', 'Proficiency', 'user_email'];

    // You can define any relationships or custom methods as needed
}
