<?php

namespace App\Exports;

use App\Models\JobPosting;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JobsReportExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $totalAlumni = \App\Models\Alumni::count();

        return JobPosting::withCount('applications')->get()->map(function($job) use ($totalAlumni) {
            return [
                'Title' => $job->title,
                'Company' => $job->company ?? '-',
                'Posted By' => $job->admin->name ?? '-',
                'Applications' => $job->applications_count,
                'Application Rate (%)' => $totalAlumni > 0 ? round(($job->applications_count / $totalAlumni) * 100, 2) : 0
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Title',
            'Company',
            'Posted By',
            'Applications',
            'Application Rate (%)'
        ];
    }
}
