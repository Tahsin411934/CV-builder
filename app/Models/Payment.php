<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
protected  $table = 'payments';
    protected $fillable = [
        'user_email',
        'method',
        'transaction_number',
        'upload_ss'
    ];
}
