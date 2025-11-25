@extends('layouts.admin')

@section('content')
<div class="container py-4" style="max-width: 700px;">
    <h1 class="mb-4">Create Job Posting</h1>

    <a href="{{ route('admin.jobs.index') }}" class="btn btn-secondary rounded-pill mb-3">
        <i class="bi bi-arrow-left me-1"></i> Back to Jobs
    </a>

    @if ($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.jobs.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Job Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
        </div>
        <div class="mb-3">
            <label for="company" class="form-label">Company</label>
            <input type="text" name="company" id="company" class="form-control" value="{{ old('company') }}">
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}">
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <input type="text" name="category" id="category" class="form-control" value="{{ old('category') }}">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Job Description</label>
            <textarea name="description" id="description" rows="6" class="form-control">{{ old('description') }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary rounded-pill">
            <i class="bi bi-save me-1"></i> Create Job
        </button>
    </form>
</div>
@endsection
