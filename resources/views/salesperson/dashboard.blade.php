@extends('layouts.app')

@section('title', 'Salesperson Dashboard')

@section('content')
<div class="dashboard-container">
    <!-- Title styled in red -->
    <div class="title">
        <h1>Salesperson Dashboard</h1>
        <h3>Hello, welcome back!</h3>
        <h5>In case you mark the wrong engine as sold, kindly see the manager for assistance</h5>
    </div>
    <div class="engine-image">
        <!-- Display the engine image; replace 'engine_image_url' with the actual path to your image -->
        <img src="{{ asset('images/blueengine.png') }}" alt="Engine Image">
    </div>

    <!-- Search Form -->
    <div class="search-container">
        <h2>Search Engine by Serial Number</h2>
        <form action="{{ route('engine.search') }}" method="GET">
            @csrf
            <div class="form-group">
                <label for="serial_number">Enter Serial Number:</label>
                <input type="text" name="serial_number" id="serial_number" required class="form-control">
            </div>
            <button type="submit" class="btn">Search</button>
        </form>
    </div>

    <!-- Display Engine Details if found -->
    @if(isset($engine))
        <div class="engine-details">
            <h3>Engine Details</h3>
            <p><strong>Model:</strong> {{ $engine->model }}</p>
            <p><strong>Type:</strong> {{ $engine->type }}</p>
            <p><strong>Displacement:</strong> {{ $engine->displacement }}</p>
            <p><strong>Status:</strong> {{ $engine->status }}</p>

            <!-- Update status to 'sold' -->
            @if($engine->status === 'unsold')
            <form action="{{ route('engine.update', $engine->engine_id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="sold">
                <button type="submit" class="btn btn-success">Mark as Sold</button>
            </form>
            @endif
        </div>
    @elseif(isset($message))
        <p>{{ $message }}</p>
    @endif

    <!-- Display success message if status was updated -->
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
</div>
@endsection

<style>
    /* Set the background image for the body */
    body {
        color:blue ; /* Ensures text is readable on the background image */
    }

    /* Center and limit the size of the container */
    .dashboard-container {
        width: 40%;
        margin: 0 auto;
        padding: 20px;
        text-align: center;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 10px;
        margin-top: 0%;
        background-color: rgba(249, 249, 249, 0.9); ; /* Light background to improve readability */
        height: 50%;
    }
       /* Engine Image Styling */
       .engine-image img {
        max-width: 100%;
        width: 100%;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        height: 100%;
    }

    /* Styling for the details container */
    .engine-details-container {
        width: 30%;
        height: 80%;
    }


    /* Style the title in red */
    .title h1 {
        color: red;
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 0;
    }
    
    .title h3 {
        color: black;
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    
    .title h5 {
        color: black;
        font-size: 15px;
        margin-bottom: 0;
    }

    .form-group {
        margin-top: 2%;
    }

    .btn {
        padding: 10px 20px;
        background-color: #28a745;
        color: red;
        border: none;
        cursor: pointer;
        border-radius: 5px;
    }

    .btn:hover {
        background-color: red;
    }
</style>