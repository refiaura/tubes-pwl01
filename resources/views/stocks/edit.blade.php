@extends('layouts.app')

@section('title', 'Edit Stock')

@section('content')
    <h1>Edit Stock</h1>
    <form action="{{ route('stocks.update', $stocks->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="branch_id" class="form-label">Branch</label>
            <select name="branch_id" id="branch_id" class="form-select">
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}" {{ $stocks->branch_id == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="product_id" class="form-label">Product</label>
            <select name="product_id" id="product_id" class="form-select">
                @foreach ($products as $product)
                    <option value="{{ $product->id }}" {{ $stocks->product_id == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $stocks->quantity }}">
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
