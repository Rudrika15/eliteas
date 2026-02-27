<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    use HasFactory;

    public function resourceCategory()
    {
        return $this->belongsTo(ResourceCategory::class, 'resourceCatId', 'id');
    }
}
