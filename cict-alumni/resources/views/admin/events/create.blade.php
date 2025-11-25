@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Create New Event</h1>

    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary mb-3">← Back to Events</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="event_date" class="form-label">Event Date & Time</label>
                    <input type="datetime-local" name="event_date" class="form-control"
                        value="{{ old('event_date', isset($event) ? \Carbon\Carbon::parse($event->event_date)->format('Y-m-d\TH:i') : '') }}" required>
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location') }}" required>
                </div>

                <div class="mb-3">
                    <label for="banner_image" class="form-label">Banner Image (optional)</label>
                    <input type="file" name="banner_image" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Create Event</button>
            </form>
        </div>
    </div>
</div>
@endsection
