<?php

namespace App\Exports;

use App\Mail\MemberSubscription;
use App\Models\Subscription;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SubscriptionsExport implements FromCollection, WithHeadings
{
    protected $membershipType;

    public function __construct($membershipType)
    {
        $this->membershipType = $membershipType;
    }

    public function collection()
    {
        if ($this->membershipType) {
            return MemberSubscription::where('membershipType', $this->membershipType)->get();
        } else {
            return MemberSubscription::all();
        }
    }

    public function headings(): array
    {
        return [
            'Name',
            'Membership Type',
            'Amount',
            'Validity',
            'Status',
        ];
    }
}
