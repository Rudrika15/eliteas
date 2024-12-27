<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopsProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'idealRef',
        'topProduct',
        'topProblemSolved',
        'myFavBniStory',
        'myIdealRefPartner',
        'weeklyPresent1',
        'weeklyPresent2',
        'yearsInBusiness',
        'prevJobs',
        'spouse',
        'children',
        'pets',
        'hobbiesInterests',
        'yearsInCity',
        'cityofRes',
        'myBurningDesire',
        'dontKnowAboutMe',
        'mKeyToSuccess',
        'status',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'memberId', 'id');
    }
}
