@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Edit Contract</h2>
    <form action="{{ route('contracts.update', $contract->id) }}" method="POST" class="bg-light p-4 rounded shadow-sm">
        @csrf
        @method('PUT')

        <!-- Status Dropdown -->
        <div class="form-group mb-3">
            <label for="status">Status:</label>
            <select id="status" name="status" class="form-control" required>
                <option value="მიმდინარე" {{ $contract->status == 'მიმდინარე' ? 'selected' : '' }}>მიმდინარე</option>
                <option value="ჩაბარებული" {{ $contract->status == 'ჩაბარებული' ? 'selected' : '' }}>ჩაბარებული</option>
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-success">Update Contract</button>
        <a href="{{ route('contracts.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
