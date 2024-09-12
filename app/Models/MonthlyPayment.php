<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyPayment extends Model
{
    use HasFactory;

    public function members()
    {
        return $this->belongsTo(Member::class, 'memberId', 'id');
    }
}
