<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Member;
use Illuminate\Http\Request;


class DeletedMemberListExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $request;
    protected $type;
    public function __construct(Request $request, $type = 'active')
    {
        $this->request = $request;
        $this->type = $type;
    }

    public function collection()
    {
        $request = $this->request;

        $query = Member::query()
            ->with(['circle', 'user', 'bCategory']);
        $query->where('status', 'Deleted');


        // 🔍 APPLY SAME FILTERS
        if ($request->filled('circleId')) {
            $query->where('circleId', $request->circleId);
        }

        if ($request->filled('categoryId')) {
            $query->where('categoryId', $request->categoryId);
        }

        if ($request->filled('membershipType')) {
            $query->where('membershipType', $request->membershipType);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('firstName', 'like', "%$search%")
                    ->orWhere('lastName', 'like', "%$search%")
                    ->orWhereHas('circle', function ($c) use ($search) {
                        $c->where('circleName', 'like', "%$search%");
                    });
            });
        }

        return $query->get()->map(function ($member) {
            return [
                'Created By' => $member->user->firstName ?? '',
                'Circle Name' => $member->circle->circleName ?? '',
                'Member Name' => $member->firstName . ' ' . $member->lastName,
                'Category' => $member->bCategory->categoryName ?? '',
                'Membership Type' => $member->membershipType ?? '',
                'Joing Date' => $member->created_at ? $member->created_at->format('d-m-y') : '',
                'Deleted Date' => $member->updated_at ? $member->updated_at->format('d-m-y') : '',
            ];
        });
    }
    public function headings(): array
    {
        return [
            'Created By',
            'Circle Name',
            'Member Name',
            'Category',
            'Membership Type',
            'Joing Date',
            'Deleted Date',
        ];
    }
}
