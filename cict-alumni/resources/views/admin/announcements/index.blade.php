@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4 fw-bold text-primary">Announcements</h2>

    {{-- Create Announcement Form --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form action="{{ route('admin.announcements.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    {{-- Image Upload --}}
                    <div class="col-md-4 text-center">
                        <label class="form-label fw-bold">Announcement Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    {{-- Title & Description --}}
                    <div class="col-md-8">
                        <div class="mb-3">
                            <input type="text" name="title" class="form-control form-control-lg" placeholder="Announcement Title" required>
                        </div>
                        <div class="mb-3">
                            <textarea name="description" class="form-control form-control-lg" rows="5" placeholder="Write your announcement..." required></textarea>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fa-solid fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Display Announcements --}}
    @if(!empty($notifications) && count($notifications) > 0)
        <ul class="list-group list-group-flush">
            @foreach($notifications as $notif)
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div>
                        @if($notif->image_path)
                            <img src="{{ asset('storage/'.$notif->image_path) }}" class="img-fluid mb-2 border" style="max-height: 150px;" alt="Announcement Image">
                        @endif
                        <strong>{{ $notif->title }}</strong>
                        <p class="mb-0">{{ $notif->description }}</p>
                        <p class="mb-0 text-muted small">{{ $notif->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="d-flex gap-2 align-items-center">
                        {{-- Edit Icon --}}
                        <button type="button" class="btn btn-sm btn-primary p-2" data-bs-toggle="modal" data-bs-target="#editAnnouncementModal{{ $notif->notificationID }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        {{-- Delete Icon --}}
                        <form action="{{ route('admin.announcements.destroy', $notif->notificationID) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger p-2">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>

                    {{-- Edit Modal --}}
                    <div class="modal fade" id="editAnnouncementModal{{ $notif->notificationID }}" tabindex="-1" aria-labelledby="editAnnouncementModalLabel{{ $notif->notificationID }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('admin.announcements.update', $notif->notificationID) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editAnnouncementModalLabel{{ $notif->notificationID }}">Edit Announcement</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Announcement Image</label>
                                            <input type="file" name="image" class="form-control" accept="image/*">
                                        </div>
                                        <div class="mb-3">
                                            <input type="text" name="title" class="form-control" value="{{ $notif->title }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <textarea name="description" class="form-control" rows="4" required>{{ $notif->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </li>
            @endforeach
        </ul>
    @else
        <p class="text-muted">No announcements yet.</p>
    @endif
</div>
@endsection
