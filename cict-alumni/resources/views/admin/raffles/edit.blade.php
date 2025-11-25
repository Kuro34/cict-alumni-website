@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 fw-bold">Edit Raffle</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.raffles.update', $raffle->raffleID) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ $raffle->title }}" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $raffle->description }}</textarea>
        </div>

        <button class="btn btn-success">Update Raffle</button>
    </form>
</div>
@endsection
