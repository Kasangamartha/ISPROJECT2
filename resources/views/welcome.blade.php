<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SkyInventory</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Figtree', sans-serif;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            background-image: url('{{ asset('images/backimage.jpg') }}'); /* Path to your background image */
            background-size: cover; /* Ensures the image covers the entire background */
            background-position: center; /* Center the background image */
            background-repeat: no-repeat; /* Prevents the background image from repeating */
        }

        /* Navigation Bar Styles */
        .navbar {
            width: 100%;
            background-color: transparent;
            padding: 10px;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            justify-content: flex-end; /* Aligns buttons to the right */
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .navbar ul li {
            margin-left: 20px;
        }

        .navbar ul li a {
            color: white;
            text-decoration: none;
            font-weight: 600;
            padding: 8px 20px;
            transition: background-color 0.3s ease;
        }

        .navbar ul li a:hover {
            background-color: #2980b9;
            border-radius: 5px;
        }

        /* Main Container */
        .container {
            margin-top: 100px; /* Adjust to prevent overlap with fixed navbar */
            text-align: center;
        }

        img {
            width: 150px;
            height: auto;
            margin-bottom: 30px;
        }

        .buttons {
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin: 0 10px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        /* Inventory Logs Container */
        .inventory-logs {
            margin-top: 50px;
            background-color: black;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 800px;
            text-align: center;
            font-size: 3.2rem;
            color: white;
        }
    </style>
</head>
<body class="antialiased">
    <!-- Navigation Bar -->
    <div class="navbar">
        <ul>
            <li><a href="#">Home</a></li>
            @if (Route::has('login'))
                @auth
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                @else
                    <li><a href="{{ route('login') }}">Log in</a></li>
                    @if (Route::has('register'))
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @endif
                @endauth
            @endif
        </ul>
    </div>

    <!-- Main Container -->
    <div class="container">
        <!-- Centered Logo -->
        <img src="{{ asset('images/skygo-logo.png') }}" alt="Logo">

        <!-- Inventory Logs Container -->
        <div class="inventory-logs">
            MOTORBIKE ENGINES INVENTORY
        </div>
    </div>
</body>
</html>
