<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'bAddressLine1',
        'bAddressLine2',
        'bCity',
        'bState',
        'bCountry',
        'bPinCode',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'memberId', 'id');
    }
}
