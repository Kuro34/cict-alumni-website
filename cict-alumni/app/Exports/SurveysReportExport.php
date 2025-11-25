<?php

namespace App\Exports;

use App\Models\Survey;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SurveysReportExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $totalAlumni = \App\Models\Alumni::count();

        return Survey::withCount(['surveyResponses' => function($q) {
                $q->where('completed', 1);
            }])
            ->get()
            ->map(function($survey) use ($totalAlumni) {
                return [
                    'Title' => $survey->title,
                    'Organizer' => $survey->admin->name ?? '-',
                    'Responses' => $survey->survey_responses_count,
                    'Participation Rate (%)' => $totalAlumni > 0 ? round(($survey->survey_responses_count / $totalAlumni) * 100, 2) : 0
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Title',
            'Organizer',
            'Responses',
            'Participation Rate (%)'
        ];
    }
}
