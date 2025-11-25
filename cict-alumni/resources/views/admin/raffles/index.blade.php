@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Raffles</h1>

    <a href="{{ route('admin.raffles.create') }}" class="btn btn-primary mb-3">+ Create Raffle</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($raffles as $raffle)
                <tr>
                    <td>{{ $raffle->title }}</td>
                    <td>{{ $raffle->description }}</td>
                    <td>{{ $raffle->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('admin.raffles.edit', $raffle->raffleID) }}" class="btn btn-sm btn-warning">Edit</a>
                    
                        <a href="{{ route('admin.raffles.entries', $raffle->raffleID) }}" class="btn btn-sm btn-info">View Entries</a>
                    
                        <form action="{{ route('admin.raffles.destroy', $raffle->raffleID) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Delete this raffle?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">No raffles found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
