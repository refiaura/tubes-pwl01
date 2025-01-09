@extends('layouts.app')

@section('title', 'Edit Transaction')

@section('content')
    <h1>Edit Transaction</h1>

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Branch Selection -->
        <div class="mb-3">
            <label for="branch_id" class="form-label">Branch</label>
            <select name="branch_id" id="branch_id" class="form-select" required>
                <option value="">-- Select Branch --</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}" {{ old('branch_id', $transaction->branch_id) == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
            @error('branch_id') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <!-- User Selection -->
        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select name="user_id" id="user_id" class="form-select" required>
                <option value="">-- Select User --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id', $transaction->user_id) == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            @error('user_id') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <!-- Date Input -->
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" name="date" id="date" class="form-control" value="{{ old('date', $transaction->date) }}" required>
            @error('date') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <!-- Total Input -->
        <div class="mb-3">
            <label for="total" class="form-label">Total</label>
            <input type="number" name="total" id="total" class="form-control" value="{{ old('total', $transaction->total) }}" required>
            @error('total') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <!-- Transaction Details Section -->
        <div class="mb-3">
            <label class="form-label">Transaction Details</label>
            <div id="transaction-details">
                @foreach ($transaction->details as $index => $detail)
                    <div class="transaction-row mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="details[{{ $index }}][product_id]" class="form-label">Product</label>
                                <select name="details[{{ $index }}][product_id]" class="form-select" required>
                                    <option value="">-- Select Product --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" {{ old("details.$index.product_id", $detail->product_id) == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="details[{{ $index }}][quantity]" class="form-label">Quantity</label>
                                <input type="number" name="details[{{ $index }}][quantity]" class="form-control" value="{{ old("details.$index.quantity", $detail->quantity) }}" required>
                            </div>
                            <div class="col-md-3">
                                <label for="details[{{ $index }}][subtotal]" class="form-label">Subtotal</label>
                                <input type="number" name="details[{{ $index }}][subtotal]" class="form-control" value="{{ old("details.$index.subtotal", $detail->subtotal) }}" required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger mt-4 remove-row">Remove</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" id="add-row" class="btn btn-success">Add Product</button>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Update</button>
    </form>

    <script>
        let rowIndex = {{ $transaction->details->count() }};

        // Add new transaction detail row
        document.getElementById('add-row').addEventListener('click', function () {
            const transactionDetails = document.getElementById('transaction-details');
            const newRow = document.createElement('div');
            newRow.classList.add('transaction-row', 'mb-3');
            newRow.innerHTML = `
                <div class="row">
                    <div class="col-md-4">
                        <label for="details[${rowIndex}][product_id]" class="form-label">Product</label>
                        <select name="details[${rowIndex}][product_id]" class="form-select" required>
                            <option value="">-- Select Product --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="details[${rowIndex}][quantity]" class="form-label">Quantity</label>
                        <input type="number" name="details[${rowIndex}][quantity]" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label for="details[${rowIndex}][subtotal]" class="form-label">Subtotal</label>
                        <input type="number" name="details[${rowIndex}][subtotal]" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger mt-4 remove-row">Remove</button>
                    </div>
                </div>
            `;
            transactionDetails.appendChild(newRow);
            rowIndex++;
        });

        // Remove transaction detail row
        document.addEventListener('click', function (event) {
            if (event.target.classList.contains('remove-row')) {
                event.target.closest('.transaction-row').remove();
            }
        });
    </script>
@endsection
