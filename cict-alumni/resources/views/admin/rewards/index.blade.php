@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Rewards</h1>

    <a href="{{ route('admin.rewards.create') }}" class="btn btn-primary mb-3">+ Add Reward</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($rewards->count())
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Points Cost</th>
                    <th>Associated Raffle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rewards as $reward)
                    <tr>
                        <td>
                            @if($reward->image)
                                <img src="{{ asset('storage/' . $reward->image) }}" alt="Reward Image" style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                            @else
                                <span class="text-muted">No Image</span>
                            @endif
                        </td>
                        <td>{{ $reward->name }}</td>
                        <td>{{ $reward->description }}</td>
                        <td>{{ $reward->point_cost }}</td>
                        <td>{{ $reward->raffle ? $reward->raffle->title : '-' }}</td>
                        <td>
                            <a href="{{ route('admin.rewards.edit', $reward->rewardID) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('admin.rewards.destroy', $reward->rewardID) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this reward?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No rewards found.</p>
    @endif
</div>
@endsection
