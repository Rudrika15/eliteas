<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorForm extends Model
{
    use HasFactory;

    protected $table = 'visitor_forms';

    protected $fillable = [
        'circle_id',
        'description',
        'date',
        'time',
        'venue',
        'visitor_registration_fee',
        'form_slug',
        'status',
        'created_by',
    ];

    public function circle()
    {
        return $this->belongsTo(Circle::class, 'circle_id', 'id');
    }
}
