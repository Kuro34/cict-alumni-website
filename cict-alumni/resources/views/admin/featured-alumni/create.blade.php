@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Add Featured Alumni</h1>

    <form action="{{ route('admin.featured-alumni.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" id="name" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="description"></textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" name="image" class="form-control" id="image" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Featured Alumni</button>
    </form>
</div>
@endsection
