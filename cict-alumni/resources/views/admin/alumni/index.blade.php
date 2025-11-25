@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">🎓 Registered Alumni Directory</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Filters -->
    <form method="GET" action="{{ route('admin.alumni.index') }}" class="mb-3 d-flex flex-wrap align-items-center gap-2">
        <!-- Search bar -->
        <input type="text" name="search" class="form-control flex-grow-1" placeholder="Search name, email..." value="{{ request('search') }}">

        <!-- Narrower filters -->
        <select name="degree_program" class="form-select form-select-sm" style="width: 150px;">
            <option value="">All Programs</option>
            @foreach($degreePrograms as $program)
                <option value="{{ $program }}" {{ request('degree_program') == $program ? 'selected' : '' }}>
                    {{ $program }}
                </option>
            @endforeach
        </select>

        <select name="graduation_year" class="form-select form-select-sm" style="width: 120px;">
            <option value="">All Years</option>
            @foreach($graduationYears as $year)
                <option value="{{ $year }}" {{ request('graduation_year') == $year ? 'selected' : '' }}>
                    {{ $year }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
    </form>

    <!-- Alumni Table -->
    <div class="table-responsive bg-white p-3 rounded shadow-sm">
        <table class="table table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Degree Program</th>
                    <th>Graduation Year</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alumni as $a)
                @php
                    $profilePath = !empty($a->profile_picture)
                        ? asset('storage/' . $a->profile_picture)
                        : asset('images/default-avatar.png');
                @endphp
                <tr>
                    <td>
                        <img src="{{ $profilePath }}"
                             onerror="this.src='{{ asset('images/default-avatar.png') }}';"
                             width="50" height="50" class="rounded-circle" alt="Profile">
                    </td>
                    <td>{{ $a->first_name }} {{ $a->middle_initial ? $a->middle_initial . '.' : '' }} {{ $a->last_name }}</td>
                    <td>{{ $a->email }}</td>
                    <td>{{ $a->degree_program ?? 'N/A' }}</td>
                    <td>{{ $a->graduation_year ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('admin.alumni.show', $a->alumniID) }}" class="btn btn-sm btn-info" title="View Details">
                            <i class="fa fa-eye"></i>
                        </a>
                        <form action="{{ route('admin.alumni.destroy', $a->alumniID) }}" 
                              method="POST" class="d-inline" 
                              onsubmit="return confirm('Are you sure you want to delete this alumni?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No alumni found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination and Per-page Selection -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <!-- Per-page selector on the left -->
            <form method="GET" action="{{ route('admin.alumni.index') }}" class="d-flex gap-1 align-items-center">
                <label for="per_page" class="mb-0 small">Show:</label>
                <select name="per_page" id="per_page" class="form-select form-select-sm" style="width: 80px;" onchange="this.form.submit()">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>
            </form>

            <!-- Pagination links on the right -->
            <div>
                {{ $alumni->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
