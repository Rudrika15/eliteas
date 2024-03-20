<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactDetails extends Model
{
    use HasFactory;


    protected $fillable = [
        'showMeOnPublicWeb',
        'billingAddress',
        'phone',
        'showPhone',
        'directNo',
        'showDirectNo',
        'home',
        'mobileNo',
        'showMobileNo',
        'pager',
        'voiceMail',
        'tollFree',
        'showTollFree',
        'fax',
        'showFax',
        'email',
        'showEmail',
        'addressLine1',
        'addressLine2',
        'addressShow',
        'city',
        'state',
        'country',
        'pinCode',
        'status',
        'created_at',
        'updated_at',
    ];



    public function member()
    {
        return $this->belongsTo(Member::class, 'memberId', 'id');
    }
}
