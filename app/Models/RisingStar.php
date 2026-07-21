<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RisingStar extends Model
{
    use HasFactory;

    protected $table = 'rising_star';

    protected $fillable = [
        'member_id',
        'title',
        'image',
        'status',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
