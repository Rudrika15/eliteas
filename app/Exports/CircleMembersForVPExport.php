<?php

namespace App\Exports;

use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CircleMembersForVPExport implements FromCollection, WithHeadings
{
    protected $circleId;

    public function __construct($circleId)
    {
        $this->circleId = $circleId;
    }
    public function collection()
    {
        return Member::where('members.status', 'Active')
            ->where('members.circleId', $this->circleId)
            ->join('users', 'users.id', '=', 'members.userId')
            ->join('circles', 'circles.id', '=', 'members.circleId')
            ->join('business_categories', 'business_categories.id', '=', 'members.businessCategoryId')
            ->where('users.status', 'Active')
            ->select(
                'circles.circleName as Circle',
                DB::raw("CONCAT(members.firstName,' ',members.lastName) as Member_Name"),
                'members.companyName as Company',
                'business_categories.categoryName as Category',
                'users.email as Email',
                'users.contactNo as Phone'
            )
            ->get();
    }
    public function headings(): array
    {
        return [
            'Circle',
            'Member Name',
            'Company',
            'Category',
            'Email',
            'Phone Number',
        ];
    }
}
