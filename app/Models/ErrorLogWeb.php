<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorLogWeb extends Model
{
    use HasFactory;

    protected $fillable = [
        'error_message',
        'error_file',
        'error_line',
        'url',
        'method',
        'ip_address',
        'user_agent',
        'additional_info',
    ];
}
