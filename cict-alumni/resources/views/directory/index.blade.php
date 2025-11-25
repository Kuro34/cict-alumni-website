@extends('layouts.alumni')

@section('content')
<div class="directory-container">
    <h1>Alumni Directory</h1>

    <form method="GET" action="{{ route('directory.index') }}" class="search-form">
        <input type="text" name="search" value="{{ $search }}" placeholder="Search alumni by name, job, program, or year">
        <button type="submit">Search</button>
    </form>

    <div class="alumni-list">
        @forelse ($alumni as $alumnus)
            @php
                $profilePath = !empty($alumnus->profile_picture)
                    ? asset('storage/' . $alumnus->profile_picture)
                    : asset('images/default-avatar.png');
            @endphp
            <div class="alumni-card">
                <div class="alumni-card-top" style="display: flex; align-items: center; gap: 12px;">
                    <img src="{{ $profilePath }}" alt="Profile Picture" style="width:60px; height:60px; border-radius:50%; object-fit:cover;"/>
                    <h3>{{ $alumnus->first_name }} {{ $alumnus->middle_initial }}. {{ $alumnus->last_name }}</h3>
                </div>
                <p><strong>Current Job:</strong> {{ $alumnus->current_job }}</p>
                <p><strong>Degree Program:</strong> {{ $alumnus->degree_program }}</p>
                <p><strong>Graduation Year:</strong> {{ $alumnus->graduation_year }}</p>

                <div class="alumni-actions" style="margin-top: 8px;">
                    <a href="{{ route('profile.public', ['alumniID' => $alumnus->alumniID, 'from_directory' => 1]) }}" class="view-profile-btn" title="View Profile">
                        <i class="fas fa-user"></i>
                    </a>
                </div>
            </div>
        @empty
            <p>No alumni found.</p>
        @endforelse
    </div>

    {{ $alumni->withQueryString()->links() }}
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    function attachMessageButtons() {
        const btns = document.querySelectorAll('.message-btn');
        if(btns.length && typeof openConversationWithUser === 'function') {
            btns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const alumniID = this.dataset.alumniid;
                    if(!alumniID) return;

                    const nameEl = this.closest('.alumni-card').querySelector('h3');
                    const alumniName = nameEl ? nameEl.textContent : 'Chat';

                    // Hide other popups
                    document.getElementById('chatPopup').style.display = 'none';
                    document.getElementById('newChatPopup').style.display = 'none';
                    document.getElementById('conversationPopup').style.display = 'flex';

                    openConversationWithUser({
                        id: alumniID,
                        type: 'alumni',
                        name: alumniName
                    });
                });
            });
        } else {
            setTimeout(attachMessageButtons, 100);
        }
    }

    attachMessageButtons();
});
</script>
@endpush

<style>
.alumni-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.alumni-card {
    padding: 16px;
    border-radius: 10px;
    background-color: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}
.alumni-card h3 {
    margin: 0;
    font-size: 1.25rem;
}
.alumni-card p {
    margin: 2px 0;
    color: #555;
    font-size: 0.95rem;
}
.alumni-actions button,
.alumni-actions a {
    margin-right: 8px;
    cursor: pointer;
}
</style>
@endsection
