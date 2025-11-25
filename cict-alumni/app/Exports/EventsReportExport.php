<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EventsReportExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $totalAlumni = \App\Models\Alumni::count();

        return Event::withCount('eventRegistrations')->get()->map(function($event) use ($totalAlumni) {
            return [
                'Title' => $event->title,
                'Organizer' => $event->admin->name ?? '-',
                'Event Date' => $event->event_date,
                'Participants' => $event->event_registrations_count,
                'Participation Rate (%)' => $totalAlumni > 0 ? round(($event->event_registrations_count / $totalAlumni) * 100, 2) : 0
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Title',
            'Organizer',
            'Event Date',
            'Participants',
            'Participation Rate (%)'
        ];
    }
}
