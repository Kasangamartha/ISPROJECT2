<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Engine Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            width: 90%;
            margin: 20px auto;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .stats div {
            background-color: #f4f4f4;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            flex: 1;
            margin: 0 10px;
        }

        .stats div h3 {
            margin: 0;
            font-size: 1.2em;
        }

        .stats div p {
            margin: 5px 0 0;
            font-size: 1em;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .btn {
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
        }

        .edit-btn {
            background-color: #008cba;
            color: white;
        }

        .edit-btn:hover {
            background-color: #007bb5;
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
    <div class="container">
        <h1>Engine Management</h1>
        
        <!-- Success Message -->
        @if (session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Stats Section -->
        <div class="stats">
            <div>
                <h3>Sold Engines</h3>
                <p>{{ $soldCount }}</p>
            </div>
            <div>
                <h3>Unsold Engines</h3>
                <p>{{ $unsoldCount }}</p>
            </div>
        </div>

        <!-- Engines Table -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Model</th>
                    <th>Serial Number</th>
                    <th>Type</th>
                    <th>Displacement</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($engines as $engine)
                    <tr>
                        <td>{{ $engine->id }}</td>
                        <td>{{ $engine->model }}</td>
                        <td>{{ $engine->serial_number }}</td>
                        <td>{{ $engine->type }}</td>
                        <td>{{ $engine->displacement }}</td>
                        <td>{{ $engine->price }}</td>
                        <td>{{ ucfirst($engine->status) }}</td> <!-- Capitalizes the first letter of the status -->
                        <td>
                            <a href="{{ route('admin.editEngine', $engine->id) }}" class="btn edit-btn">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
