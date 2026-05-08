<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberGallery extends Model
{
    use HasFactory;

    protected $table = 'member_galleries';
    protected $fillable = [
        'memberId',
        'image',
        'status'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
