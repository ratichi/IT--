@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Acts for Contract: {{ $contract->contract_name }}</h2>

    <a href="{{ route('contracts.index') }}" class="btn btn-secondary mb-4">Back to Contracts</a>

    @if($acts->isEmpty())
        <p>აქტი არ განხორციელებულა</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>აქტის თარიღი</th>
                    <th>აქტის ნომერი</th>
                    <th>ჩაბარების თარიღი</th>
                    <th>რაოდენობა</th>
                </tr>
            </thead>
            <tbody>
                @foreach($acts as $act)
                    <tr>
                        <td>{{ $act->id }}</td>
                        <td>{{ $act->date_of_act }}</td>
                        <td>{{ $act->number_of_act }}</td>
                        <td>{{ $act->receive_date }}</td>
                        <td>{{ $act->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
