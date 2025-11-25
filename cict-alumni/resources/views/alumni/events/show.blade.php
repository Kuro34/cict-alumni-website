@extends('layouts.alumni')

@section('content')
@php
use Illuminate\Support\Str;
@endphp

<style>
.event-details-container { padding: 20px; max-width: 900px; margin: auto; }
.event-card { border-radius: 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); background-color: #fff; transition: transform 0.2s; margin-top: 2rem; }
.event-card:hover { transform: translateY(-3px); }
.event-card img { width: 100%; height: 300px; object-fit: cover; }
.event-card-body { padding: 25px; }
.event-card h2 { font-size: 1.8rem; margin-bottom: 10px; font-weight: 700; }
.event-meta { font-size: 0.9rem; color: #6c757d; margin-bottom: 15px; }
.event-meta i { margin-right: 5px; color: #0d6efd; }
.event-description { font-size: 1rem; margin-bottom: 20px; white-space: pre-line; }
.btn-event { display: inline-flex; align-items: center; gap: 8px; font-weight: 600; padding: 10px 20px; border-radius: 8px; transition: 0.2s; }
.btn-event i { font-size: 1.1rem; }
.btn-event:hover { transform: translateY(-2px); }
.modal-overlay { position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); display: none; justify-content: center; align-items: center; z-index: 999; }
.modal { background: #fff; width: 500px; max-width: 90%; border-radius: 12px; padding: 20px; display: flex; flex-direction: column; gap: 15px; }
.modal h3 { margin-bottom: 10px; }
.modal p { color: #555; }
.modal-buttons { display: flex; justify-content: flex-end; gap: 10px; }
.modal-buttons button { padding: 8px 15px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; }
.btn-back { background-color: #6c757d; color: #fff; }
.btn-register { background-color: #0d6efd; color: #fff; }
.btn-outline-primary { border-radius: 50px; font-weight: 500; padding: 8px 20px; cursor: pointer; }
</style>

<div class="event-details-container">
    <button class="btn btn-outline-primary btn-job-action mb-3" onclick="window.location.href='{{ route('events.index') }}'">
        <i class="bi bi-arrow-left-circle me-1"></i> Back to Events
    </button>

    <div class="event-card">
        @php
            $bannerPath = $event->banner_image
                ? asset('storage/' . (Str::startsWith($event->banner_image,'event-banners/') ? $event->banner_image : 'event-banners/' . $event->banner_image))
                : asset('images/default-banner.jpg');
        @endphp
        <img src="{{ $bannerPath }}" alt="{{ $event->title }}">

        <div class="event-card-body">
            <h2>{{ $event->title }}</h2>
            <p class="event-meta">
                <i class="bi bi-calendar-event"></i> {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y H:i') }} &nbsp;&nbsp;
                <i class="bi bi-geo-alt"></i> {{ $event->location ?? '-' }} &nbsp;&nbsp;
                <i class="bi bi-person-circle"></i> Hosted by: {{ $event->admin->name ?? 'Admin' }}
            </p>
            <p class="event-description">{!! nl2br(e($event->description)) !!}</p>

            @auth('alumni')
                @php
                    $isRegistered = $alumni->registrations?->contains('eventID', $event->eventID) ?? false;
                @endphp

                @if($isRegistered)
                    <button class="btn btn-success btn-event" disabled>
                        <i class="bi bi-check-circle"></i> Registered
                    </button>
                @else
                    <button type="button" class="btn btn-primary btn-event" id="openRegisterModal">
                        <i class="bi bi-pencil-square"></i> Register
                    </button>
                @endif
            @endauth
        </div>
    </div>
</div>

<!-- Registration Modal -->
<div class="modal-overlay" id="registerModal">
    <div class="modal">
        <h3>Confirm Registration</h3>
        <p><strong>Event:</strong> {{ $event->title }}</p>
        <p><strong>Date & Location:</strong> {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y H:i') }}, {{ $event->location ?? '-' }}</p>
        <p style="color:red;">Registering will finalize your participation. This action cannot be undone.</p>
        <div class="modal-buttons">
            <button class="btn-back" id="modalBack">Back</button>
            <form action="{{ route('events.register', $event->eventID) }}" method="POST">
                @csrf
                <button type="submit" class="btn-register">Confirm</button>
            </form>
        </div>
    </div>
</div>

<script>
const openModalBtn = document.getElementById('openRegisterModal');
const modal = document.getElementById('registerModal');
const modalBack = document.getElementById('modalBack');

if(openModalBtn){
    openModalBtn.addEventListener('click', () => { modal.style.display = 'flex'; });
}

modalBack.addEventListener('click', () => { modal.style.display = 'none'; });
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection
