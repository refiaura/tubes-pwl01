@extends('layouts.app')

@section('title', 'Transaction Details')

@section('content')
    <h1>Transaction Details</h1>

    <!-- Transaction Summary -->
    <div class="mb-3">
        <p><strong>User:</strong> {{ $transaction->user->name }}</p>
        <p><strong>Branch:</strong> {{ $transaction->branch->name }}</p>
        <p><strong>Date:</strong> {{ $transaction->date }}</p>
        <p><strong>Total:</strong> {{ number_format($transaction->total, 2) }}</p>
    </div>

    <!-- Transaction Details Table -->
    <h2>Transaction Items</h2>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaction->details as $detail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detail->product->name }}</td>
                        <td>{{ $detail->quantity }}</td>
                        <td>{{ number_format($detail->subtotal, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No items found in this transaction.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Back Button -->
    <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Back to Transactions</a>
@endsection
