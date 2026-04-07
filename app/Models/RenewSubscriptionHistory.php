<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RenewSubscriptionHistory extends Model
{
    use HasFactory;

    protected $table = 'renew_Subscription';

    protected $fillable = [
        'userId',
        'renewedBy',
        'renewalDate',
        'subscriptionId',
        'amount',
        'status',
    ];
}
