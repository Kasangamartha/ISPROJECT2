@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="form-card">
        <h2>Welcome back!</h2>
        <h2>Login</h2>
        
        <!-- Display success message if user is logged in -->
        @if (session('status'))
            <div class="message">
                {{ session('status') }}
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email" required class="form-control" value="{{ old('email') }}">
                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required class="form-control">
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn">Log in</button>
        </form>
    </div>
</div>
@endsection

<!-- Add this CSS for styling -->
<style>
    body {
        background-color: #f7f7f7; /* Light background for the page */
    }

    .auth-container {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f7f7f7;
    }

    .form-card {
        background-color: #fff;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
        text-align: center;
    }

    h2 {
        margin-bottom: 20px;
        font-size: 24px;
        color: #333;
    }

    .form-group {
        margin-bottom: 20px;
        text-align: left;
    }

    label {
        font-weight: bold;
        color: #333;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-top: 5px;
    }

    .btn {
        background-color: #3498db;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
        cursor: pointer;
        width: 100%;
        margin-top: 20px;
    }

    .btn:hover {
        background-color: #2980b9;
    }

    .error {
        color: #e74c3c;
        font-size: 14px;
        margin-top: 5px;
        display: block;
    }

    .message {
        background-color: #2ecc71;
        color: white;
        padding: 10px;
        margin-bottom: 20px;
        border-radius: 5px;
    }
</style>
