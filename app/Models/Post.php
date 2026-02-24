<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'userId',
        'caption',
        'attachment',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'postId', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'postId', 'id');
    }

    public function media()
    {
        return $this->hasMany(PostMedia::class, 'postId', 'id');
    }
}
