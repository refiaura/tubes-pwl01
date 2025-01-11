@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <h1>Products</h1>
    @if (Auth::check() && (Auth::user()->role === 'manager' || Auth::user()->role === 'supervisor' || Auth::user()->role === 'warehouse_staff'))
                <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add Product</a>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price</th>
                <th>Category</th>
                @if (Auth::check() && Auth::user()->role === 'manager')
                <th>Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->category }}</td>
                    @if (Auth::check() && (Auth::user()->role === 'manager' || Auth::user()->role === 'supervisor' || Auth::user()->role === 'warehouse_staff'))
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this products?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </div>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection