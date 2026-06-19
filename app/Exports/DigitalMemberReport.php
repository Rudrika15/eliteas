<?php

namespace App\Exports;

use App\Models\Member;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DigitalMemberReport implements FromCollection, WithHeadings
{
    /**
     * @return Collection
     */
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Member::where('status', 'Active')
            ->whereNull('circleId')
            ->whereHas('contactDetails')
            ->with([
                'contactDetails',
                'user',
                'topsProfile',
                'billingAddress',
                'bCategory',
            ]);

        if (! empty($this->request->categoryId)) {

            $query->whereHas('bCategory', function ($q) {
                $q->where('id', $this->request->categoryId);
            });
        }

        if (! empty($this->request->membershipType)) {
            $query->where(
                'membershipType',
                $this->request->membershipType
            );
        }

        // Search Filter
        if (! empty($this->request->search)) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('firstName', 'like', "%{$search}%")
                    ->orWhere('lastName', 'like', "%{$search}%")
                    ->orWhereHas('contactDetails', function ($q2) use ($search) {
                        $q2->where('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('user', function ($q3) use ($search) {
                        $q3->where('firstName', 'like', "%{$search}%")
                            ->orWhere('lastName', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        return $query->get()->map(function ($member, $key) {
            return [
                'Sr No' => $key + 1,
                'Member Name' => $member->firstName.' '.$member->lastName,
                'Email' => $member->contactDetails->email ?? '',
                'Mobile No' => $member->contactDetails->mobileNo ?? '',
                'Business Category' => $member->bCategory->categoryName ?? '',
                'Membership Type' => $member->membershipType,
                'Created By' => $member->user->firstName ?? '',

            ];
        });
    }

    public function headings(): array
    {
        return [

            'Sr No',
            'Member Name',
            'Email',
            'Mobile No',
            'Business Category',
            'Membership Type',
            'Created By',
        ];
    }
}
