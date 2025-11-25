@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Edit Admin</h2>
        <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">Back</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @php
        $currentAdmin = auth('admin')->user();
        $isStaffEditingSuperadmin = $currentAdmin->role !== 'superadmin' && $admin->role === 'superadmin';
        $disableFields = $isStaffEditingSuperadmin;
    @endphp

    @if($isStaffEditingSuperadmin)
        <div class="alert alert-warning">
            You need higher authority to edit this admin.
        </div>
    @endif

    <form action="{{ route('admin.admins.update', $admin->adminID) }}" method="POST">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $admin->name }}" class="form-control" required {{ $disableFields ? 'disabled' : '' }}>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ $admin->email }}" class="form-control" required {{ $disableFields ? 'disabled' : '' }}>
        </div>

        <div class="mb-3">
            <label>New Password (leave blank to keep current)</label>
            <input type="password" name="password" class="form-control" {{ $disableFields ? 'disabled' : '' }}>
        </div>

        <div class="mb-3">
            <label>Role</label>
            <select name="role" class="form-select" {{ $disableFields ? 'disabled' : '' }}>
                <option value="superadmin" {{ $admin->role == 'superadmin' ? 'selected' : '' }}
                    @if($currentAdmin->role !== 'superadmin') disabled @endif>
                    Super Admin
                </option>
                <option value="staff" {{ $admin->role == 'staff' ? 'selected' : '' }}>Staff</option>
            </select>
        </div>

        <button class="btn btn-primary" {{ $disableFields ? 'disabled' : '' }}>Update Admin</button>
    </form>
</div>
@endsection
