<?php

namespace App\Exports;

use App\Models\Trainer;
use App\Models\Training;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TrainersListExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Training::with(['trainers', 'user'])->get()->map(function ($trainerData) {
            return [
                'Training Name' => $trainerData->training->title ?? '-',
                'Date' => \Carbon\Carbon::parse($trainerData->training->date)->format('d-m-y') ?? '-',
                'Trainer Name' => $trainerData->user->firstName . ' ' . $trainerData->user->lastName ?? '-',
                // 'Status' => $trainerData->status,
            ];
        });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Training Name',
            'Date',
            'Trainer Name',
            // 'Status',
        ];
    }
}
