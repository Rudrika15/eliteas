<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'event_date', 'start_time', 'end_time', 'amount'];

    public function circle()
    {
        return $this->belongsTo(Circle::class, 'circleId', 'id');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($event) {
            $event->event_slug = Str::slug($event->title);
        });
    }
}
