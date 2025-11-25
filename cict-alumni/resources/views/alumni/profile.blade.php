@extends('layouts.alumni')

@section('content')
<style>
    .profile-banner {
        position: relative;
        width: 100%;
        height: 250px;
        overflow: hidden;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    .profile-banner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
    }

    .change-banner-btn {
        background-color: rgba(0,0,0,0.6);
        color: #fff;
        padding: 6px 12px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.9rem;
        position: absolute;
        bottom: 10px;
        right: 50px;
        transition: background-color 0.2s ease;
    }
    .change-banner-btn:hover {
        background-color: rgba(0,0,0,0.8);
    }

    .clear-banner-btn {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background-color: rgba(255, 0, 0, 0.8);
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        font-size: 16px;
        font-weight: bold;
        line-height: 24px;
        text-align: center;
        cursor: pointer;
    }
    .clear-banner-btn:hover {
        background-color: rgba(200, 0, 0, 0.9);
    }

    .profile-card {
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        padding: 40px;
        overflow: hidden;
        position: relative;
    }

    .profile-header {
        display: flex;
        gap: 30px;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 30px;
    }
    .profile-header img {
        width: 140px;
        height: 140px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #e0e0e0;
        display: block;
    }

    .profile-pic-wrapper {
        position: relative;
        display: inline-block;
        width: 140px;
        height: 140px;
    }

    .clear-profile-btn {
        position: absolute;
        bottom: 5px;
        right: 5px;
        background-color: rgba(255, 0, 0, 0.9);
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 26px;
        height: 26px;
        font-size: 14px;
        font-weight: bold;
        line-height: 24px;
        text-align: center;
        cursor: pointer;
    }
    .clear-profile-btn:hover {
        background-color: rgba(200, 0, 0, 1);
    }

    .profile-summary h2 {
        margin-bottom: 5px;
        font-weight: 700;
    }
    .profile-summary small {
        color: #6c757d;
        font-size: 0.95rem;
    }

    .profile-details .row {
        margin-bottom: 20px;
    }
    .profile-details label {
        font-weight: 600;
        display: block;
        margin-bottom: 5px;
    }
    .profile-details input, .profile-details select {
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 8px 12px;
    }

    .profile-actions {
        margin-top: 30px;
        text-align: right;
    }
    .profile-actions .btn {
        border-radius: 8px;
        padding: 8px 20px;
        font-weight: 600;
    }
    .profile-actions .btn-primary {
        background-color: #ccc;
        border-color: #ccc;
    }
    .profile-actions .btn-primary:hover {
        background-color: #e1d7d7;
        border-color: #e1d7d7;
    }

    .profile-actions .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }
    .profile-actions .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .change-profile-btn {
        background-color: rgba(0,0,0,0.6);
        color: #fff;
        border: 1px solid #fff;
        padding: 6px 12px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 0.9rem;
        display: block;
        text-align: center;
        margin-top: 8px;
        transition: background-color 0.2s ease;
    }
    .change-profile-btn:hover {
        background-color: rgba(0,0,0,0.8);
    }

    .profile-pic-section {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .points-summary-box {
        background: #f8f9fa;
        color: #000000;
        padding: 25px 20px;
        border-radius: 12px;
        text-align: center;
        width: 220px;
        float: right;
        margin-left: 20px;
        box-shadow: 0 8px 18px rgba(0,0,0,0.2);
        font-family: 'Segoe UI', sans-serif;
    }
    .points-summary-box h4 {
        font-size: 1.3rem;
        margin-bottom: 10px;
        font-weight: 700;
    }
    .points-summary-box p {
        font-size: 28px;
        font-weight: 800;
        margin: 0;
    }
    .points-summary-box small {
        font-size: 0.95rem;
        opacity: 0.85;
    }
    .btn-outline-primary { border-radius: 50px; font-weight: 500; padding: 8px 20px; cursor: pointer; margin-bottom:20px; }
</style>

<div class="container py-5">
    <div class="row">
        <div class="col-md-12">

            {{-- EDIT MODE --}}
            @if($editMode && $isOwner)
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    {{-- Banner --}}
                    <div class="profile-banner position-relative">
                        @php
                            $bannerPath = ($alumni->banner_picture && trim($alumni->banner_picture) !== '')
                                          ? asset('storage/' . ltrim($alumni->banner_picture, '/'))
                                          : asset('images/default-banner.jpg');
                        @endphp
                        <img id="bannerPreview" src="{{ $bannerPath }}" alt="Banner">

                        <label class="change-banner-btn">
                            Change Banner
                            <input type="file" name="banner_picture" accept="image/*" style="display:none;" onchange="previewImage(this, 'bannerPreview')">
                        </label>
                        <button type="button" class="clear-banner-btn" onclick="clearImage('bannerPreview', 'clear_banner_picture', '{{ asset('images/default-banner.jpg') }}')">&times;</button>
                        <input type="hidden" name="clear_banner_picture" id="clear_banner_picture" value="0">

                        @error('banner_picture')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Profile Card --}}
                    <div class="profile-card">
                        <div class="profile-header">
                            <div class="profile-pic-section">
                                <div class="profile-pic-wrapper">
                                    @php
                                        $profilePath = ($alumni->profile_picture && trim($alumni->profile_picture) !== '')
                                                       ? asset('storage/' . ltrim($alumni->profile_picture, '/'))
                                                       : asset('images/default-avatar.png');
                                    @endphp
                                    <img id="profilePreview" src="{{ $profilePath }}" alt="Profile Picture">

                                    <button type="button" class="clear-profile-btn" onclick="clearImage('profilePreview', 'clear_profile_picture', '{{ asset('images/default-avatar.png') }}')">&times;</button>
                                    <input type="hidden" name="clear_profile_picture" id="clear_profile_picture" value="0">
                                </div>

                                <label class="change-profile-btn">
                                    Change Profile Picture
                                    <input type="file" name="profile_picture" accept="image/*" hidden onchange="previewImage(this, 'profilePreview')">
                                </label>

                                @error('profile_picture')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="profile-summary">
                                <h2>{{ $alumni->first_name }} {{ $alumni->middle_initial }} {{ $alumni->last_name }}</h2>
                                <small>{{ $alumni->degree_program }} • Class of {{ $alumni->graduation_year }}</small><br>
                                <small>{{ $alumni->current_job ?? 'No current job listed' }}</small>
                            </div>
                        </div>

                        @if(session('status'))
                            <div class="alert alert-success mt-4">{{ session('status') }}</div>
                        @endif

                        <div class="points-summary-box">
                            <h4>Points</h4>
                            <p>{{ $totalPoints ?? 0 }}</p>
                            <small>points earned</small>
                        </div>

                        <div class="profile-details mt-4 clearfix">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" value="{{ old('first_name', $alumni->first_name) }}" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label>Middle Initial</label>
                                    <input type="text" name="middle_initial" value="{{ old('middle_initial', $alumni->middle_initial) }}" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" value="{{ old('last_name', $alumni->last_name) }}" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <label>Age</label>
                                    <input type="number" name="age" value="{{ old('age', $alumni->age) }}" class="form-control">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label>Gender</label>
                                    <select name="gender" class="form-control">
                                        <option value="" disabled {{ old('gender', $alumni->gender) == '' ? 'selected' : '' }}>Select Gender</option>
                                        <option value="Male" {{ old('gender', $alumni->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender', $alumni->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                        <option value="Other" {{ old('gender', $alumni->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                        <option value="Prefer not to say" {{ old('gender', $alumni->gender) == 'Prefer not to say' ? 'selected' : '' }}>Prefer not to say</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Address</label>
                                    <input type="text" name="address" value="{{ old('address', $alumni->address) }}" class="form-control">
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label>Phone Number</label>
                                    <input type="text" name="phone_number" value="{{ old('phone_number', $alumni->phone_number) }}" class="form-control">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label>Current Job</label>
                                    <input type="text" name="current_job" value="{{ old('current_job', $alumni->current_job) }}" class="form-control">
                                </div>
                                <div class="col-md-3 mt-3">
                                    <label>Graduation Year</label>
                                    <input type="number" name="graduation_year" value="{{ old('graduation_year', $alumni->graduation_year) }}" class="form-control">
                                </div>
                                <div class="col-md-5 mt-3">
                                    <label>Degree Program</label>
                                    <input type="text" name="degree_program" value="{{ old('degree_program', $alumni->degree_program) }}" class="form-control">
                                </div>
                                <div class="col-md-6 mt-3">
                                    <label>Email</label>
                                    <input type="email" name="email" value="{{ old('email', $alumni->email) }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="profile-actions mt-4">
                            <button type="button" onclick="window.location='{{ route('profile.view') }}'" class="btn btn-primary">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </div>
                </form>

            {{-- VIEW MODE --}}
            @else
                @if(!empty($fromDirectory))
                    <button class="btn btn-outline-primary btn-job-action mb-3" onclick="window.location.href='{{ route('directory.index') }}'">
                        <i class="bi bi-arrow-left-circle me-1"></i> Back to Alumni Directory
                    </button>
                @endif

                <div class="profile-card">
                    <div class="profile-banner">
                        @php
                            $bannerPath = ($alumni->banner_picture && trim($alumni->banner_picture) !== '')
                                          ? asset('storage/' . ltrim($alumni->banner_picture, '/'))
                                          : asset('images/default-banner.jpg');
                        @endphp
                        <img src="{{ $bannerPath }}" alt="Banner">
                    </div>

                    <div class="profile-header">
                        <div>
                            @php
                                $profilePath = ($alumni->profile_picture && trim($alumni->profile_picture) !== '')
                                               ? asset('storage/' . ltrim($alumni->profile_picture, '/'))
                                               : asset('images/default-avatar.png');
                            @endphp
                            <img src="{{ $profilePath }}" alt="Profile Picture">
                        </div>
                        <div class="profile-summary">
                            <h2>{{ $alumni->first_name }} {{ $alumni->middle_initial }} {{ $alumni->last_name }}</h2>
                            <small>{{ $alumni->degree_program }} • Class of {{ $alumni->graduation_year }}</small><br>
                            <small>{{ $alumni->current_job ?? 'No current job listed' }}</small>
                        </div>
                    </div>

                    <div class="points-summary-box">
                        <h4>Points</h4>
                        <p>{{ $totalPoints ?? 0 }}</p>
                        <small>points earned</small>
                    </div>

                    <div class="profile-details mt-4 clearfix">
                        <div class="row"><div class="col-md-4"><label>Name:</label></div><div class="col-md-8">{{ $alumni->first_name }} {{ $alumni->middle_initial }} {{ $alumni->last_name }}</div></div>
                        <div class="row"><div class="col-md-4"><label>Gender:</label></div><div class="col-md-8">{{ $alumni->gender ?? '—' }}</div></div>
                        <div class="row"><div class="col-md-4"><label>Age:</label></div><div class="col-md-8">{{ $alumni->age }}</div></div>
                        <div class="row"><div class="col-md-4"><label>Address:</label></div><div class="col-md-8">{{ $alumni->address }}</div></div>
                        <div class="row"><div class="col-md-4"><label>Phone Number:</label></div><div class="col-md-8">{{ $alumni->phone_number }}</div></div>
                        <div class="row"><div class="col-md-4"><label>Current Job:</label></div><div class="col-md-8">{{ $alumni->current_job }}</div></div>
                        <div class="row"><div class="col-md-4"><label>Graduation Year:</label></div><div class="col-md-8">{{ $alumni->graduation_year }}</div></div>
                        <div class="row"><div class="col-md-4"><label>Degree Program:</label></div><div class="col-md-8">{{ $alumni->degree_program }}</div></div>
                        <div class="row"><div class="col-md-4"><label>Email:</label></div><div class="col-md-8">{{ $alumni->email }}</div></div>

                        @if($isOwner)
                            <div class="profile-actions mt-3">
                                <button type="button" onclick="window.location='{{ route('profile.edit') }}'" class="btn btn-primary">
                                    Edit Profile
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

<script>
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById(previewId).src = e.target.result;
        reader.readAsDataURL(input.files[0]);
    }
}

function clearImage(previewId, hiddenInputId, defaultPath) {
    document.getElementById(previewId).src = defaultPath;
    document.getElementById(hiddenInputId).value = 1;
}
</script>

@endsection
