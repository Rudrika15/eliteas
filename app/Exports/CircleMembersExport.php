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
        return Member::where('members.circleId', $this->circleId)
            ->join('users', 'users.id', '=', 'members.userId')
            ->join('circles', 'circles.id', '=', 'members.circleId')
            ->join('business_categories', 'business_categories.id', '=', 'members.businessCategoryId')
            ->select(
                'circles.circleName as CircleName',
                // 'members.circleId as CircleId',
                'members.firstName as FirstName',
                'members.lastName as LastName',
                'business_categories.categoryName as BusinessCategoryName',
                'members.membershipType as MembershipType',
                'users.contactNo as ContactNo'
            )
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
            'Contact No'
        ];
    }
}
