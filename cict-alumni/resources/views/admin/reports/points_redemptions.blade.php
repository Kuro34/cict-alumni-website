@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">💰 Points & Redemptions Report</h1>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th>#</th>
                    <th>Alumni Name</th>
                    <th>Degree Program</th>
                    <th>Graduation Year</th>
                    <th>Points Earned</th>
                    <th>Rewards Redeemed</th>
                    <th>Raffles Entered</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alumni as $index => $al)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $al->first_name }} {{ $al->middle_initial ? $al->middle_initial.'.' : '' }} {{ $al->last_name }}</td>
                        <td>{{ $al->degree_program ?? '-' }}</td>
                        <td class="text-center">{{ $al->graduation_year ?? '-' }}</td>
                        <!-- Total points -->
                        <td class="text-center">{{ $al->total_points }}</td>
                        <!-- Rewards Redeemed -->
                        <td class="text-center">
                            @forelse($al->rewardsRedeemed as $redemption)
                                {{ $redemption->reward ? $redemption->reward->name : 'N/A' }}<br>
                            @empty
                                -
                            @endforelse
                        </td>
                        <!-- Raffles Entered -->
                        <td class="text-center">
                            @forelse($al->raffleEntries as $entry)
                                {{ $entry->raffle ? $entry->raffle->title ?? $entry->raffle->name : 'N/A' }}<br>
                            @empty
                                -
                            @endforelse
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">No alumni found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <a href="{{ route('admin.reports.points.export') }}" class="btn btn-success mb-3">
            Export CSV
        </a>
    </div>
</div>
@endsection
