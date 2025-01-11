@extends('layouts.app')

@section('title', 'Transactions')

@section('content')
    <h1>Transactions</h1>
    @if (Auth::check() && (Auth::user()->role === 'manager' || Auth::user()->role === 'supervisor' || Auth::user()->role === 'warehouse_staff'))
                
                <a href="{{ route('transactions.create') }}" class="btn btn-primary mb-3">Add Transaction</a>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Branch</th>
                <th>User</th>
                <th>Date</th>
                <th>Total</th>
                @if (Auth::check() && (Auth::user()->role === 'manager' || Auth::user()->role === 'supervisor' || Auth::user()->role === 'warehouse_staff'))
                <th>Actions</th>
                @endif
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
                    @if (Auth::check() && (Auth::user()->role === 'manager' || Auth::user()->role === 'supervisor'))
                    <td>
                        <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-info btn-sm">Details</a>
                        <a href="{{ route('transactions.edit', $transaction) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" style="display: inline;" onsubmit="return confirmDelete();">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                    @elseif (Auth::check() && Auth::user()->role === 'admin')
                    <td>
                        <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-info btn-sm">Details</a>
                    </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this transaction?");
        }
    </script>
@endsection