@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Edit Reward</h1>

    <form action="{{ route('admin.rewards.update', $reward->rewardID) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Reward Name</label>
            <input type="text" name="name" class="form-control" value="{{ $reward->name }}" required>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Reward Image</label>
            <input type="file" name="image" class="form-control">
            @if(isset($reward) && $reward->image)
                <img src="{{ asset('storage/' . $reward->image) }}" alt="Reward Image" style="width: 100px; margin-top: 10px;">
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ $reward->description }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Points Cost</label>
            <input type="number" name="point_cost" class="form-control" value="{{ $reward->point_cost }}" min="1" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Associated Raffle (Optional)</label>
            <select name="raffleID" class="form-control">
                <option value="">-- None --</option>
                @foreach($raffles as $raffle)
                    <option value="{{ $raffle->raffleID }}" {{ $reward->raffleID == $raffle->raffleID ? 'selected' : '' }}>
                        {{ $raffle->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Update Reward</button>
        <a href="{{ route('admin.rewards.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
