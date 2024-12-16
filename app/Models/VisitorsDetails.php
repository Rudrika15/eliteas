<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorsDetails extends Model
{
    use HasFactory;

    public function member()
    {
        return $this->belongsTo(Member::class, 'invitedBy', 'id'); // Correct foreign key relationship
    }

    public function bCategory()
    {
        return $this->belongsTo(BusinessCategory::class, 'businessCategory', 'id');
    }


}
