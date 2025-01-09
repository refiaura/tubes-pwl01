@extends('layouts.app')

@section('title', 'Transactions')

@section('content')
    <h1>Transactions</h1>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary mb-3">Add Transaction</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Branch</th>
                <th>User</th>
                <th>Date</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaction->branch->name }}</td>
                    <td>{{ $transaction->user->name }}</td>
                    <td>{{ $transaction->date }}</td>
                    <td>{{ $transaction->total }}</td>
                    <td>
                        <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-info btn-sm">Details</a>
                        <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection