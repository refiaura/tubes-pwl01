@extends('layouts.app')

@section('title', 'Branches')

@section('content')
    <h1>Branches</h1>
    @if (Auth::check() && Auth::user()->role === 'admin')
    <a href="{{ route('branches.create') }}" class="btn btn-primary mb-3">Add Branch</a>
    {{-- <h1>Welcome, Admin!</h1>
    <p>Anda memiliki akses ke fitur ini.</p> --}}
    @endif
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($branches as $branch)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $branch->name }}</td>
                    <td>{{ $branch->location }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('branches.edit', $branch) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('branches.destroy', $branch->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this branch?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>                    
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection