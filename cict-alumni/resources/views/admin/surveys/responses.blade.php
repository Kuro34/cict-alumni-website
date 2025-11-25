@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 fw-bold">{{ $survey->title }}</h1>

    @if($survey->description)
        <p class="text-muted">{{ $survey->description }}</p>
    @endif

    <!-- 🧭 Tutorial Section -->
    <div class="alert alert-info border-info shadow-sm mb-4">
        <h5 class="fw-semibold mb-2">📘 How to Display Google Sheet Responses</h5>
        <ol class="mb-2">
            <li>Open your <strong>Google Form</strong> that collects responses.</li>
            <li>Click on the <strong>Responses</strong> tab ➜ then click the <strong>green Sheets icon</strong> 📊 to open the linked Google Sheet.</li>
            <li>Once in the Sheet, click <strong>Share ➜ Copy link</strong> or use the address bar URL.</li>
            <li>Paste that link in the field below, then click <strong>“Save Link”</strong>.</li>
            <li>Make sure the sheet is <strong>public or anyone with the link can view</strong> — otherwise, it won’t display inside the page.</li>
        </ol>
        <p class="mb-0"><strong>Tip:</strong> Use the regular sheet URL (e.g. <code>https://docs.google.com/spreadsheets/d/.../edit?usp=sharing</code>).</p>
    </div>

    <!-- 🔗 Form to add/update Google Sheet URL -->
    <div class="card p-4 mb-4 shadow-sm">
        <form action="{{ route('admin.surveys.updateSheet', $survey->surveyID) }}" method="POST">
            @csrf
            @method('PUT')
            <label for="sheet_url" class="form-label fw-semibold">Google Sheet Link</label>
            <input type="text" name="sheet_url" id="sheet_url" 
                   value="{{ old('sheet_url', $survey->sheet_url) }}" 
                   class="form-control mb-2" placeholder="Paste your Google Sheet link here">
            <button type="submit" class="btn btn-primary">Save Link</button>
        </form>
    </div>

    <!-- ✅ Display Google Sheet if available -->
    @if($survey->sheet_url)
        <div class="mb-5">
            <h4 class="fw-semibold mb-3">Google Sheet Responses</h4>
            <div class="ratio ratio-16x9 border rounded shadow-sm">
                <iframe 
                    src="{{ preg_replace('/\/edit.*$/', '/preview', $survey->sheet_url) }}" 
                    width="100%" 
                    height="600" 
                    style="border:0;" 
                    allowfullscreen>
                </iframe>
            </div>
        </div>
    @else
        <div class="alert alert-warning mb-4">
            No Google Sheet link has been set for this survey yet.
        </div>
    @endif

    <!-- ✅ Table of Individual Alumni Responses -->
    <h4 class="fw-semibold mb-3">Individual Responses</h4>
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Alumni Name</th>
                    <th>Status</th>
                    <th>Points Earned</th>
                    <th>Completed At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($responses as $index => $response)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $response->alumni ? $response->alumni->first_name . ' ' . $response->alumni->last_name : 'N/A' }}</td>
                        <td>
                            @if($response->completed)
                                <span class="badge bg-success">Completed</span>
                            @else
                                <span class="badge bg-secondary">Pending</span>
                            @endif
                        </td>
                        <td>{{ $response->points_earned ?? 0 }}</td>
                        <td>{{ $response->completed_at ? $response->completed_at->format('M d, Y h:i A') : '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            No responses yet for this survey.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
