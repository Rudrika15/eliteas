<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateMaster extends Model
{
    use HasFactory;

    function TemplateDetail()
    {
        return $this->hasOne(TemplateDetail::class, 'templateId', 'id');
    }
}
