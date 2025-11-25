@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Edit Featured Alumni</h1>

    <form action="{{ route('admin.featured-alumni.update', $alumnus->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ $alumnus->name }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="description">{{ $alumnus->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" name="image" class="form-control" id="image">
            @if($alumnus->image_path)
                <img src="{{ asset('storage/' . $alumnus->image_path) }}" class="img-thumbnail mt-2" width="150" alt="{{ $alumnus->name }}">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Featured Alumni</button>
    </form>
</div>
@endsection
