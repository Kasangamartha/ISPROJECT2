<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            background-color: grey;
            color: #fff;
            display: flex;
            flex-direction: column;
            padding: 20px;
            height: 100vh;
            position: fixed;
        }

        .sidebar h2 {
            font-size: 20px;
            margin-bottom: 20px;
            text-align: center;
        }

        .sidebar a {
            display: block;
            color: #fff;
            text-decoration: none;
            padding: 10px 15px;
            margin-bottom: 10px;
            border-radius: 4px;
            font-size: 16px;
        }

        .sidebar a:hover {
            background-color: #555;
        }

        .create-user-btn {
            background-color: red; /* Blue */
        }

        .manage-engines-btn {
            background-color: red; /* Green */
        }

        .manager-dashboard-btn {
            background-color: red; /* Yellow */
            color: #333;
        }

        /* Main Content Area */
        .main-content {
            margin-left: 300px;
            padding: 20px;
            flex-grow: 1;
            background-color: lavender;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #c3e6cb;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <a href="{{ route('admin.createUser') }}" class="create-user-btn">Create New User</a>
        <a href="{{ route('admin.engines') }}" class="manage-engines-btn">Manage Engines</a>
        <a href="{{ route('manager.dashboard') }}" class="manager-dashboard-btn">Manager Dashboard</a>

            <!-- Logout Button -->
    <form action="{{ route('logout') }}" method="POST" style="margin-top: 100%;">
        @csrf
        <button type="submit" class="btn logout-btn" style="background-color: #dc3545; color: white; width: 100%; padding: 10px; border: none; border-radius: 4px; font-size: 16px;">
            Logout
        </button>
    </form>
    </div>

    <!-- Main Content -->
    <div class="main-content">
    <img src="{{ asset('images/skygo-logo.png') }}" alt="Centered Image" style="height:20%">
        <h1>Manage users</h1>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Users Table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if ($user->role_id == 1) Admin
                            @elseif ($user->role_id == 2) Manager
                            @else Salesperson
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.editUser', $user->id) }}" class="btn create-user-btn">Edit</a>
                            <form action="{{ route('admin.deleteUser', $user->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn manager-dashboard-btn" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
