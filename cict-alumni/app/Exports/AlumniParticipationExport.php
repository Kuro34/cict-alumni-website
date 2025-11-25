<?php

namespace App\Exports;

use App\Models\Alumni;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AlumniParticipationExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Alumni::with(['eventRegistrations', 'surveyResponses'])
            ->get()
            ->map(function($al) {
                return [
                    'Name' => $al->first_name . ' ' . ($al->middle_initial ? $al->middle_initial.'.' : '') . ' ' . $al->last_name,
                    'Gender' => $al->gender ?? 'Not specified',
                    'Age' => $al->age ?? '-',
                    'Degree Program' => $al->degree_program ?? '-',
                    'Graduation Year' => $al->graduation_year ?? '-',
                    'Events Attended' => $al->eventRegistrations->count(),
                    'Surveys Completed' => $al->surveyResponses->where('completed',1)->count(),
                    'Total Points' => $al->total_points
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Gender',
            'Age',
            'Degree Program',
            'Graduation Year',
            'Events Attended',
            'Surveys Completed',
            'Total Points'
        ];
    }
}
