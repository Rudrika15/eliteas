<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberSubscription extends Model
{
    use HasFactory;

    public function allPayments()
    {
        return $this->belongsTo(AllPayments::class, 'userId', 'memberId');
    }

}
