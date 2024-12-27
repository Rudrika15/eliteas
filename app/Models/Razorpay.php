<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Razorpay extends Model
{
    use HasFactory;

    protected $table = 'razorpays';
    protected $guarded = ['id'];

    protected $fillable = [
        'r_payment_id',
        'user_email',
        'amount',
    ];
}
