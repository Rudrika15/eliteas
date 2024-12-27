<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberSubscriptions extends Model
{
    use HasFactory;

    public function allPayments()
    {
        return $this->belongsTo(AllPayments::class, 'userId', 'memberId');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

}
