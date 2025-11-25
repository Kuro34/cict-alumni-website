@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Featured Alumni</h1>

    <a href="{{ route('admin.featured-alumni.create') }}" class="btn btn-primary mb-3">Add New Featured Alumni</a>

    @if($featuredAlumni->count())
    <div class="row">
        @foreach($featuredAlumni as $alumnus)
        <div class="col-md-3 mb-3">
            <div class="card">
                <img src="{{ asset('storage/' . $alumnus->image_path) }}" class="card-img-top" alt="{{ $alumnus->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $alumnus->name }}</h5>
                    <p class="card-text">{{ $alumnus->description }}</p>

                    <!-- Edit button -->
                    <a href="{{ route('admin.featured-alumni.edit', $alumnus->id) }}" class="btn btn-sm btn-warning">Edit</a>

                    <!-- Delete form -->
                    <form action="{{ route('admin.featured-alumni.destroy', $alumnus->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{ $featuredAlumni->links() }} <!-- pagination links -->

    @else
    <p>No featured alumni found.</p>
    @endif
</div>
@endsection
