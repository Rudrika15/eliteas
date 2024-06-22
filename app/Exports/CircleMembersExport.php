<?php

namespace App\Exports;

use App\Models\CircleMember;
use App\Models\Member;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CircleMembersExport implements FromCollection, WithHeadings
{
    protected $circleId;

    public function __construct($circleId)
    {
        $this->circleId = $circleId;
    }

    public function collection()
    {
        return Member::where('circleId', $this->circleId)
            ->select('circleId', 'firstName', 'lastName', 'businessCategoryId', 'membershipType')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Circle ID',
            'First Name',
            'Last Name',
            'Business Category ID',
            'Membership Type',
        ];
    }
}
