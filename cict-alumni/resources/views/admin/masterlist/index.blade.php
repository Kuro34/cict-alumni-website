@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">📘 Alumni Masterlist</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Error!</strong> {{ $errors->first('file') }}
        </div>
    @endif

    <!-- Import / Export -->
    <div class="bg-white p-3 rounded shadow-sm mb-4">
        <form action="{{ route('admin.masterlist.import') }}" method="POST" enctype="multipart/form-data" class="d-flex flex-wrap align-items-center gap-2">
            @csrf
            <div class="flex-grow-1">
                <input type="file" name="file" class="form-control form-control-sm" accept=".xlsx,.xls,.csv" required>
            </div>
            <button type="submit" class="btn btn-sm btn-primary">
                <i class="fa fa-upload me-1"></i> Import Excel
            </button>
            <a href="{{ route('admin.masterlist.export') }}" class="btn btn-sm btn-success">
                <i class="fa fa-download me-1"></i> Export Excel
            </a>
        </form>
    </div>

    <!-- Masterlist Table -->
    <div class="table-responsive bg-white p-3 rounded shadow-sm">
        <table class="table table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Student #</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Auxiliary Name</th> <!-- Added -->
                    <th>Birthdate</th>
                    <th>Gender</th>
                    <th>Program</th>
                    <th>Specialization</th>
                    <th>Graduation Year</th>
                </tr>
            </thead>
            <tbody>
                @forelse($masterlist as $alumni)
                <tr>
                    <td>{{ $alumni->student_number }}</td>
                    <td>{{ $alumni->last_name }}</td>
                    <td>{{ $alumni->first_name }}</td>
                    <td>{{ $alumni->middle_name }}</td>
                    <td>{{ $alumni->auxiliary_name ?? '—' }}</td> <!-- Added -->
                    <td>{{ $alumni->birthdate ?? '—' }}</td>
                    <td>{{ $alumni->gender ?? '—' }}</td>
                    <td>{{ $alumni->program->program_name ?? '—' }}</td>
                    <td>{{ $alumni->specialization->specialization_name ?? '—' }}</td>
                    <td>{{ $alumni->graduation_year ?? '—' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center text-muted">No records found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-3">
            {{ $masterlist->links() }}
        </div>
    </div>
</div>
@endsection
