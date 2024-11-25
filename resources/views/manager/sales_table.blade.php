@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sales Table</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Serial Number</th>
                <th>Model</th>
                <th>Salesperson</th>
                <th>Date Sold</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
            <tr>
                <td>{{ $sale->id }}</td>
                <td>{{ $sale->serial_number }}</td>
                <td>{{ $sale->model }}</td>
                <td>{{ $sale->salesperson_name }}</td>
                <td>{{ $sale->date }}</td>
                <td>{{ number_format($sale->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
