<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Engine</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background: #007bff;
            color: #fff;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <form action="{{ route('admin.updateEngine', $engine->id) }}" method="POST">
        @csrf
        @method('PUT')
        <h1>Edit Engine</h1>

        <label for="serial_number">Serial Number:</label>
        <input type="text" id="serial_number" name="serial_number" value="{{ $engine->serial_number }}" required>

        <label for="model">Model:</label>
        <input type="text" id="model" name="model" value="{{ $engine->model }}" required>

        <label for="type">Type:</label>
        <input type="text" id="type" name="type" value="{{ $engine->type }}" required>

        <label for="displacement">Displacement:</label>
        <input type="text" id="displacement" name="displacement" value="{{ $engine->displacement }}" required>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" value="{{ $engine->price }}" required>

        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="unsold" {{ $engine->status == 'unsold' ? 'selected' : '' }}>Unsold</option>
            <option value="sold" {{ $engine->status == 'sold' ? 'selected' : '' }}>Sold</option>
        </select>

        <button type="submit">Update Engine</button>
    </form>
</body>
</html>
