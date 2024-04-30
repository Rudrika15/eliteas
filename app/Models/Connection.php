<?php

namespace App\Models;

// use App\Models\Connection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    use HasFactory;

    public function members()
    {
        return $this->belongsTo(Member::class, 'memberId', 'id');
    }


}
