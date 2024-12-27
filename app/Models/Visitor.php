<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    public function bCategory()
    {
        return $this->belongsTo(BusinessCategory::class, 'businessCategory', 'id');
    }
}
