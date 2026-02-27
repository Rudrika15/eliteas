<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RenewSubscriptionHistory extends Model
{
    use HasFactory;

    protected $table = 'renewSubscription';

    protected $fillable = [
        'userId',
        'renewedBy',
        'renewalDate',
        'subscriptionId',
        'amount',
        'status',
    ];
}
