@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Gallery</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary mb-3">Add New Image</a>

    @if($images->count())
        <div class="row">
            @foreach($images as $item)
            <div class="col-md-3 mb-3">
                <div class="card">
                    <img src="{{ asset('storage/' . $item->image_path) }}" class="card-img-top" alt="{{ $item->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->title }}</h5>
                        <p class="card-text">{{ $item->caption }}</p>
                        <a href="{{ route('admin.gallery.edit', $item->galleryID) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.gallery.destroy', $item->galleryID) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $images->links() }}
        </div>
    @else
        <p>No gallery items found.</p>
    @endif
</div>
@endsection
