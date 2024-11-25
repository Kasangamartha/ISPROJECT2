<!-- resources/views/manager/search_result.blade.php -->
@extends('layouts.app')

@section('content')
<div class="search-result-container">
    <div class="engine-image">
        <!-- Display the engine image; replace 'engine_image_url' with the actual path to your image -->
        <img src="{{ asset('images/engine.png') }}" alt="Engine Image">
    </div>

    <div class="engine-details-container">
        <div class="header">
            <h2>Engine Details</h2>
        </div>

        <!-- Display success and error messages -->
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Engine Details Section -->
        <div class="engine-details">
            <p><strong>Serial Number:</strong> {{ $engine->serial_number }}</p>
            <p><strong>Status:</strong> 
                <span class="{{ $engine->status === 'sold' ? 'status-sold' : 'status-unsold' }}">
                    {{ ucfirst($engine->status) }}
                </span>
            </p>
        </div>

        <!-- Form to change status if the engine is currently sold -->
        @if ($engine->status === 'sold')
            <form action="{{ route('manager.updateStatusToUnsold', $engine->id) }}" method="POST" class="status-form">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-change-status">Change Status to Unsold</button>
            </form>
        @else
            <p class="no-correction">Status is already "unsold". No correction needed.</p>
        @endif
    </div>
</div>
@endsection

<style>
    /* Main container styling with flexbox layout */
    .search-result-container {
        display: flex;
        align-items: flex-start;
        justify-content: center;
        gap: 30px;
        width: 80%;
        margin: 0 auto;
        padding: 30px;
        background-color: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Engine Image Styling */
    .engine-image img {
        max-width: 300px;
        width: 100%;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Styling for the details container */
    .engine-details-container {
        width: 50%;
    }

    .header h2 {
        color: #333;
        font-size: 28px;
        font-weight: 600;
        margin-bottom: 20px;
    }

    /* Alerts styling */
    .alert {
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    /* Engine details styling */
    .engine-details {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .engine-details p {
        font-size: 16px;
        margin: 10px 0;
        color: #555;
    }

    /* Status label styles */
    .status-sold {
        color: #dc3545;
        font-weight: 700;
    }

    .status-unsold {
        color: #28a745;
        font-weight: 700;
    }

    /* Button styles for changing status */
    .status-form {
        text-align: left;
        margin-top: 20px;
    }

    .btn-change-status {
        padding: 10px 20px;
        font-size: 16px;
        font-weight: 500;
        background-color: #007bff;
        color: #ffffff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn-change-status:hover {
        background-color: #0056b3;
    }

    /* Styling for the no correction message */
    .no-correction {
        font-size: 14px;
        color: #888;
        margin-top: 20px;
    }
</style>
