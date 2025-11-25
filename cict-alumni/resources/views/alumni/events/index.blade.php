@extends('layouts.alumni')

@php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
@endphp

@section('content')
<style>
    .events-container h1 {
        margin-bottom: 30px;
        font-weight: 700;
        text-align: center;
    }

    .event-card {
        margin-bottom: 20px;
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        flex-direction: column;
    }

    .event-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }

    .event-card img {
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
        width: 100%;
        height: 250px; /* increased from 200px */
        object-fit: cover;
    }

    .event-card-body {
        display: flex;
        flex-direction: column;
        flex: 1;
        padding: 16px;
    }

    .event-card-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .event-card-text {
        flex: 1;
        color: #555;
        margin-bottom: 12px;
        display: -webkit-box;
        -webkit-line-clamp: 3; /* limit to 3 lines */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .event-card-meta {
        font-size: 0.9rem;
        color: #777;
        margin-bottom: 12px;
    }

    .view-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 8px;
        text-decoration: none;
        color: #000000;
        background-color: #fff;
        border: none;
        transition: transform 0.2s, box-shadow 0.2s;
        align-self: flex-start;
    }

    .view-btn:hover {
        background-color: rgb(187, 192, 198);
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .view-btn i {
        font-size: 0.95rem;
    }

    @media (max-width: 767px) {
        .events-container {
            padding: 15px;
        }
    }
</style>

<div class="events-container" style="max-width: 1200px; margin: auto; padding: 20px;">
    <h1>Upcoming Events</h1>
    <div class="row g-4 mt-3">
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
            <div class="col-md-4 col-sm-6">
                <div class="card event-card h-100">
                    <img src="{{ $bannerPath }}" alt="{{ $event->title }}">

                    <div class="event-card-body">
                        <h5 class="event-card-title">{{ $event->title }}</h5>
                        <p class="event-card-text">{{ $event->description }}</p>
                        <p class="event-card-meta">
                            📅 {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y h:i A') }} |
                            📍 {{ $event->location ?? '-' }}
                        </p>

                        <a href="{{ route('events.show', $event->eventID) }}" class="view-btn mt-auto">
                            <i class="bi bi-eye"></i> View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">No events available at the moment.</p>
        @endforelse
    </div>
</div>
@endsection
