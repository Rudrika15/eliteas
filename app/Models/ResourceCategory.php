<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceCategory extends Model
{
    use HasFactory;

    protected $table = 'resource_categories';

    public function resources()
    {
        return $this->hasMany(Help::class, 'resourceCatId', 'id');
    }
}
