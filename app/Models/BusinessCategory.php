<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessCategory extends Model
{
    use HasFactory;

    protected $fillable = [
       'categoryName',
       'categoryIcon'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'memberId', 'id');
    }
}
