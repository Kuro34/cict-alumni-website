@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Edit Survey</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.surveys.update', $survey->surveyID) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">Survey Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $survey->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $survey->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="form_url" class="form-label">Form URL (Google Form link)</label>
            <input type="url" class="form-control" id="form_url" name="form_url" value="{{ old('form_url', $survey->form_url) }}">
        </div>

        <div class="mb-3">
            <label for="points" class="form-label">Points <span class="text-danger">*</span></label>
            <input type="number" class="form-control" id="points" name="points" value="{{ old('points', $survey->points) }}" min="0" required>
        </div>

        <div class="mb-3">
            <label for="expected_duration" class="form-label">Expected Duration (minutes)</label>
            <input type="number" class="form-control" id="expected_duration" name="expected_duration" value="{{ old('expected_duration', $survey->expected_duration) }}" min="1">
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
            <input type="date" class="form-control" id="end_date" name="end_date"
                value="{{ old('end_date', $survey->end_date ? \Carbon\Carbon::parse($survey->end_date)->format('Y-m-d') : '') }}"
                required>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.surveys.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left-circle"></i> Back
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Update Survey
            </button>
        </div>
    </form>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection
