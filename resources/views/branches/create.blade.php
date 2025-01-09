@extends('layouts.app')

@section('title', 'Add Branch')

@section('content')
    <h1>Add Branch</h1>

    <form action="{{ route('branches.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Branch Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter branch name" required>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" placeholder="Enter branch location" required>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('branches.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection