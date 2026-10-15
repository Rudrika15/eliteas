<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuePayment extends Model
{
    use HasFactory;

    protected $table = 'due_payments';

    protected $fillable = [
        'circle_id',
        'circle_name',
        'member_id',
        'userId',
        'payment_type',
        'amount',
        'status',
        'date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function getUserIdAttribute()
    {
        return $this->attributes['userId'] ?? null;
    }

    public function setUserIdAttribute($value)
    {
        $this->attributes['userId'] = $value;
    }

    public function circle()
    {
        return $this->belongsTo(Circle::class, 'circle_id', 'id');
    }
}
