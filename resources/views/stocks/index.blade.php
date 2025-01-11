@extends('layouts.app')

@section('title', 'Stocks')

@section('content')
    <h1>Stocks</h1>
    @if (Auth::check() && (Auth::user()->role === 'manager' || Auth::user()->role === 'supervisor' || Auth::user()->role === 'warehouse_staff'))
    <a href="{{ route('stocks.create') }}" class="btn btn-primary mb-3">Add Stock</a>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Branch</th>
                <th>Product</th>
                <th>Quantity</th>
                @if (Auth::check() && (Auth::user()->role === 'manager' || Auth::user()->role === 'supervisor' || Auth::user()->role === 'warehouse_staff'))
                <th>Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($stocks as $stock)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $stock->branch->name }}</td>
                    <td>{{ $stock->product->name }}</td>
                    <td>{{ $stock->quantity }}</td>
                    @if (Auth::check() && (Auth::user()->role === 'manager' || Auth::user()->role === 'supervisor' || Auth::user()->role === 'warehouse_staff'))
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('stocks.edit', $stock) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('stocks.destroy', $stock->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this stock?');">
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