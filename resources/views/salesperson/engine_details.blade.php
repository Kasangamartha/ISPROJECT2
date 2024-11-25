@extends('layouts.app')

@section('title', 'Engine Details')

@section('content')
<div style="text-align: center;">
    <img src="{{ asset('images/skygo-logo.png') }}" alt="Centered Image" style="max-width: 100%; height: auto;">
</div>

<div class="engine-details-container">

    <h1>Engine Details</h1>

    <p><strong>Model:</strong> {{ $engine->model }}</p>
    <p><strong>Type:</strong> {{ $engine->type }}</p>
    <p><strong>Displacement:</strong> {{ $engine->displacement }}</p>
    <p><strong>Status:</strong> {{ $engine->status }}</p>
    <p><strong>Serial Number:</strong> {{ $engine->serial_number }}</p>
    <p><strong>Price:</strong> {{ $engine->price }}</p> <!-- Display engine price -->

    <!-- Update status to 'sold' if it's unsold -->
    @if($engine->status === 'unsold')
    <form action="{{ route('engine.update', $engine->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Hidden field for status -->
        <input type="hidden" name="status" value="sold">

        <!-- Removed Quantity input -->
        <!-- No longer required since we're using default value of 1 -->

        <!-- Submit button -->
        <button type="submit" class="btn btn-success">Mark as Sold</button>
    </form>
    @endif
</div>
@endsection

<!-- Add any necessary CSS styles -->
<style>
        img {
            width: 150px;
            height: auto;
            margin-bottom: 30px;
            margin left : 70%;
        }

    .engine-details-container {
        text-align: center;
        margin-top: 50px;
        background-color: lavender;
        
    }

    .btn {
        padding: 10px 20px;
        background-color: #28a745;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    .btn:hover {
        background-color: #218838;
    }

    .form-group {
        margin: 20px 0;
    }

    input.form-control {
        padding: 10px;
        width: 50%;
        margin: 0 auto;
        text-align: center;
    }
</style>