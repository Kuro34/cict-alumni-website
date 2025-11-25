@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Entries for: {{ $raffle->title }}</h1>

    <a href="{{ route('admin.raffles.index') }}" class="btn btn-secondary mb-3">Back to Raffles</a>

    {{-- Pick Winner Form --}}
    @if($raffle->entries->count() > 0)
        <form action="{{ route('admin.raffles.pickWinner', $raffle->raffleID) }}" method="POST" class="mb-3">
            @csrf
            <button class="btn btn-success">Pick Random Winner 🎉</button>
        </form>

        @if(session('winner'))
            <div class="alert alert-success">
                🎉 Winner: {{ session('winner')->first_name }} {{ session('winner')->last_name }} ({{ session('winner')->email }})
            </div>
        @endif
    @endif

    @if($raffle->entries->count() > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Alumni Name</th>
                    <th>Email</th>
                    <th>Points Used</th>
                    <th>Entered At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($raffle->entries as $index => $entry)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $entry->alumni->first_name }} {{ $entry->alumni->last_name }}</td>
                    <td>{{ $entry->alumni->email }}</td>
                    <td>{{ $entry->points_used }}</td>
                    <td>{{ $entry->created_at->format('M d, Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No entries yet for this raffle.</p>
    @endif
</div>
@endsection
