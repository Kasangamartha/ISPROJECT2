<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Engine; // Include the Engine model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Display the admin dashboard
    public function index()
    {
        $users = User::all(); // Fetch all users
        return view('admin.dashboard', compact('users'));
    }

    // Show the create user form
    public function create()
    {
        return view('admin.create-user'); // View for adding a new user
    }

    // Store a new user in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role_id' => 'required|in:1,2,3',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'User created successfully!');
    }

    // Show the edit user form
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit-user', compact('user'));
    }

    // Update the user details in the database
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,$id",
            'role_id' => 'required|in:1,2,3',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'User updated successfully!');
    }

    // Delete a user from the database
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully!');
    }

    // Display all engines
    public function showEngines()
    {
        $engines = Engine::all();
        $soldCount = Engine::where('status', 'sold')->count();
        $unsoldCount = Engine::where('status', 'unsold')->count();
        return view('admin.engines.index', compact('engines', 'soldCount', 'unsoldCount'));
    }

    // Show the edit form for a specific engine
    public function editEngine($id)
    {
        $engine = Engine::findOrFail($id);
        return view('admin.engines.edit', compact('engine'));
    }

    public function markAsSold($id)
    {
        $engine = Engine::findOrFail($id);

        if ($engine->status === 'sold') {
            return redirect()->back()->with('error', 'Engine is already sold.');
        }

        $engine->update([
            'status' => 'sold',
            'user_id' => auth()->id(), // Assign the engine to the logged-in salesperson
        ]);

        // Log the sale in the sales table
        Sale::create([
            'engine_id' => $engine->id,
            'date' => now(),
            'quantity' => 1,
            'price' => $engine->price,
        ]);

        return redirect()->back()->with('success', 'Engine marked as sold successfully.');
    }
    // Update the engine details
    public function updateEngine(Request $request, $id)
    {
        $engine = Engine::findOrFail($id);

        $request->validate([
            'serial_number' => 'required|string|unique:engines,serial_number,' . $id,
            'model' => 'required|string',
            'type' => 'required|string',
            'displacement' => 'required|string',
            'price' => 'required|numeric',
            'status' => 'required|in:unsold,sold',
        ]);

        $engine->update([
            'serial_number' => $request->serial_number,
            'model' => $request->model,
            'type' => $request->type,
            'displacement' => $request->displacement,
            'price' => $request->price,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.engines')->with('success', 'Engine details updated successfully!');
    }
    
}
