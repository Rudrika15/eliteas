<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DuplicateVisitorDetails extends Model
{
    use HasFactory;

    protected $table = 'duplicate_visitors_details';

    protected $fillable = [
        'city',
        'firstName',
        'lastName',
        'email',
        'mobileNo',
        'businessName',
        'businessCategory',
        'invitedBy',
        'circleId',
        'meetingId',
        'otherDetails',
        'status',
        'createdBy',
        'isUser',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'invitedBy', 'id');
    }

    public function bCategory()
    {
        return $this->belongsTo(BusinessCategory::class, 'businessCategory', 'id');
    }
}
