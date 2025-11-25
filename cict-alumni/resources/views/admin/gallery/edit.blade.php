@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Edit Gallery Image</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.gallery.update', $image->galleryID) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Title (Optional)</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $image->title) }}">
        </div>

        <div class="mb-3">
            <label for="caption" class="form-label">Caption (Optional)</label>
            <textarea class="form-control" id="caption" name="caption" rows="3">{{ old('caption', $image->caption) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Replace Image (Optional)</label>
            <input type="file" class="form-control" id="image" name="image">
            @if($image->image_path)
                <img src="{{ asset('storage/' . $image->image_path) }}" class="img-fluid mt-2" style="max-height: 200px;" alt="{{ $image->title }}">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Image</button>
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
