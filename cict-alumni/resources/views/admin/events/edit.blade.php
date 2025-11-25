@extends('layouts.admin')

@php
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Edit Event</h1>

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
            <form action="{{ route('admin.events.update', $event->eventID) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $event->title) }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" required>{{ old('description', $event->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="event_date" class="form-label">Event Date</label>
                    <input type="date" name="event_date" class="form-control" 
                        value="{{ old('event_date', \Carbon\Carbon::parse($event->event_date)->format('Y-m-d')) }}" required>
                </div>

                <div class="mb-3">
                    <label for="event_time" class="form-label">Event Time</label>
                    <input type="time" name="event_time" class="form-control" 
                        value="{{ old('event_time', $event->event_time ?? '') }}">
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location', $event->location) }}" required>
                </div>

                <div class="mb-3">
                    <label for="banner_image" class="form-label">Banner Image</label>
                    @if($event->banner_image)
                        @php
                            $bannerFile = Str::startsWith($event->banner_image, 'event-banners/') 
                                ? $event->banner_image 
                                : 'event-banners/' . $event->banner_image;

                            $bannerPath = Storage::disk('public')->exists($bannerFile)
                                ? asset('storage/' . $bannerFile)
                                : asset('images/default-banner.jpg');
                        @endphp
                        <div class="mb-2">
                            <img src="{{ $bannerPath }}" alt="Banner" style="max-width:150px; max-height:80px; object-fit:cover; border-radius:4px;">
                        </div>
                    @endif
                    <input type="file" name="banner_image" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Update Event</button>
            </form>
        </div>
    </div>
</div>
@endsection
