@extends('layouts.admin')

@php
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Event Details</h1>

    <a href="{{ route('admin.events.index') }}" class="btn btn-secondary mb-3">← Back to Events</a>

    @php
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

    <div class="card shadow-sm mb-4">
        <img src="{{ $bannerPath }}" alt="Event Banner" class="img-fluid event-banner">

        <div class="card-body">
            <h3>{{ $event->title }}</h3>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}</p>
            <p><strong>Location:</strong> {{ $event->location }}</p>
            <p><strong>Description:</strong></p>
            <p>{{ $event->description }}</p>
            <p><strong>Hosted by:</strong> {{ $event->admin->name ?? 'Admin' }}</p>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5>Registered Alumni</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>Alumni Name</th>
                        <th>Email</th>
                        <th>Registered At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($event->registrations as $registration)
                        <tr>
                            <td>{{ $registration->alumni->first_name }} {{ $registration->alumni->last_name }}</td>
                            <td>{{ $registration->alumni->email }}</td>
                            <td>{{ $registration->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">No alumni registered yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Optional CSS for banner size --}}
<style>
    .event-banner {
        max-width: 400px;
        max-height: 200px;
        object-fit: cover;
        border-radius: 4px;
        display: block;
        margin: 0 auto 15px auto;
    }
</style>
@endsection
