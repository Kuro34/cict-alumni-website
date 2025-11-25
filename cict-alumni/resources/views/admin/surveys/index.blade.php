@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Surveys Management</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.surveys.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Create New Survey
        </a>
    </div>

    @if($surveys->count())
        <table class="table table-striped table-hover align-middle">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Points</th>
                    <th>Duration (mins)</th>
                    <th>End Date</th>
                    <th>Created By</th>
                    <th>Responses</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($surveys as $survey)
                <tr>
                    <td>{{ $survey->title }}</td>
                    <td>{{ $survey->points }}</td>
                    <td>{{ $survey->expected_duration ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($survey->end_date)->format('M d, Y') }}</td>
                    <td>{{ $survey->admin->name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('admin.surveys.responses', $survey->surveyID) }}" class="btn btn-sm btn-info">
                            View ({{ $survey->responses->count() }})
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('admin.surveys.edit', $survey->surveyID) }}" class="btn btn-sm btn-warning">
                           <i class="bi bi-pencil-square"></i> Edit
                        </a>

                        <form action="{{ route('admin.surveys.destroy', $survey->surveyID) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this survey?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $surveys->links() }}
        </div>
    @else
        <p class="text-center">No surveys found. <a href="{{ route('admin.surveys.create') }}">Create one now.</a></p>
    @endif
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection
