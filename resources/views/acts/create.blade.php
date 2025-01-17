@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>აქტის დამტება ხელშეკრულება #{{ $contract->id }}_სთვის</h2>
    <form action="{{ route('acts.store', $contract->id) }}" method="POST" class="bg-light p-4 rounded shadow-sm">
        @csrf
        <div class="form-group mb-3">
            <label for="date_of_act">აქტის თარიღი</label>
            <input type="date" id="date_of_act" name="date_of_act" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="number_of_act">აქტის ნომერი</label>
            <input type="text" id="number_of_act" name="number_of_act" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="receive_date">ჩაბარების თარიღი</label>
            <input type="date" id="receive_date" name="receive_date" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="quantity">რაოდენობა</label>
            <input type="number" id="quantity" name="quantity" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">დამატება</button>
        <a href="{{ route('contracts.index') }}" class="btn btn-secondary">უკან</a>
    </form>
</div>
@endsection
