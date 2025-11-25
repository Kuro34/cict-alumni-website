@extends('layouts.admin')

@php
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Events</h1>

    <a href="{{ route('admin.events.create') }}" class="btn btn-primary mb-3">+ Create New Event</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Banner</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                        @php
                            $bannerPath = null;
                            if ($event->banner_image) {
                                $bannerFile = Str::startsWith($event->banner_image, 'event-banners/') 
                                    ? $event->banner_image 
                                    : 'event-banners/' . $event->banner_image;

                                $bannerPath = Storage::disk('public')->exists($bannerFile)
                                    ? asset('storage/' . $bannerFile)
                                    : asset('images/default-banner.jpg');
                            } else {
                                $bannerPath = asset('images/default-banner.jpg');
                            }
                        @endphp
                        <tr>
                            <td>{{ $event->title }}</td>
                            <td>{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</td>
                            <td>{{ $event->location }}</td>
                            <td>
                                <img src="{{ $bannerPath }}" alt="Event Banner" class="img-fluid event-banner">
                            </td>
                            <td>
                                <a href="{{ route('admin.events.show', $event->eventID) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('admin.events.edit', $event->eventID) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.events.destroy', $event->eventID) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this event?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No events found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $events->links() }}
    </div>
</div>

{{-- Optional CSS for banner size --}}
<style>
    .event-banner {
        max-width: 150px;
        max-height: 80px;
        object-fit: cover;
        border-radius: 4px;
    }
</style>
@endsection
