<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'userId');
    }
    public function sender()
    {
        return $this->hasOne(Member::class, 'userId', 'userId');
    }
    public function receiver()
    {
        return $this->hasOne(Member::class, 'id', 'memberId');
    }

    public function member()
    {
        return $this->hasOne(Member::class, 'id', 'memberId');
    }
}
