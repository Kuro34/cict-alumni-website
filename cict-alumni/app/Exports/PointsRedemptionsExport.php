<?php

namespace App\Exports;

use App\Models\Alumni;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PointsRedemptionsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Alumni::with(['rewardsRedeemed.reward', 'raffleEntries.raffle'])
            ->get()
            ->map(function($al) {
                return [
                    'Name' => $al->first_name . ' ' . ($al->middle_initial ? $al->middle_initial.'.' : '') . ' ' . $al->last_name,
                    'Total Points' => $al->total_points,
                    'Rewards Redeemed' => $al->rewardsRedeemed->pluck('reward.name')->implode(', '),
                    'Raffle Entries' => $al->raffleEntries->pluck('raffle.title')->implode(', ')
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Total Points',
            'Rewards Redeemed',
            'Raffle Entries'
        ];
    }
}
