@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="dashboard-container">

    <!-- Title at the top-left -->
    <div class="title">
        <h1>Admin Dashboard</h1>
    </div>

    <!-- Content can go here -->
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

</div>
@endsection

<!-- Add this CSS for positioning -->
<style>
    .dashboard-container {
        height: 100vh;
        position: relative;
    }

    .title {
        position: absolute;
        top: 0;
        left: 0;
        padding: 20px; /* Adjust padding if needed */
        font-size: 24px;
        font-weight: bold;
    }
</style>
