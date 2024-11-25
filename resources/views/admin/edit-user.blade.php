<!-- resources/views/admin/edit-user.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            font-family: 'Cursive', sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        h1 {
            text-align: center;
            font-style: italic;
            color: #2c3e50;
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
            font-style: italic;
            font-size: 16px;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: 'Cursive', sans-serif;
            font-size: 16px;
        }
        button {
            background: #2c3e50;
            color: #fff;
            cursor: pointer;
            font-style: italic;
        }
        button:hover {
            background: #34495e;
        }
    </style>
</head>
<body>
    <form action="{{ route('admin.updateUser', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <h1>Edit User</h1>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ $user->name }}" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ $user->email }}" required>

        <label for="role_id">Role:</label>
        <select id="role_id" name="role_id">
            <option value="1" {{ $user->role_id == 1 ? 'selected' : '' }}>Admin</option>
            <option value="2" {{ $user->role_id == 2 ? 'selected' : '' }}>Manager</option>
            <option value="3" {{ $user->role_id == 3 ? 'selected' : '' }}>Salesperson</option>
        </select>

        <button type="submit">Update User</button>
    </form>
</body>
</html>
