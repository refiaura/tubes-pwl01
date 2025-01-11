@extends('layouts.anonymous')

@section('title', 'Login')

@section('content')
    <div class="container-fluid min-vh-100 d-flex justify-content-center align-items-center" style="background: linear-gradient(to right, #d3d3d3 30%, #ffffff 50%, #000000 100%);">
        <div class="col-md-6 p-5 bg-white shadow rounded">
            <h3 class="text-center mb-4">Login</h3>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
@endsection
