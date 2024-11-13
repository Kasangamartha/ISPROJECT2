<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    // Show registration form
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:1,2,3'], // Ensure role input is valid (1 for admin, 2 for manager, 3 for salesperson)
        ]);

        // Create the user and assign the selected role
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role, // Assign role based on user input
        ]);

        // Log the user in after registration
        Auth::login($user);

        // Redirect based on role
        if ($user->role_id == 1) {
            // Admin role
            return redirect()->route('admin.dashboard');
        } elseif ($user->role_id == 2) {
            // Manager role
            return redirect()->route('manager.dashboard');
        } elseif ($user->role_id == 3) {
            // Salesperson role
            return redirect()->route('salesperson.dashboard');
        }

        // Default redirect if no role is matched
        return redirect()->route('dashboard');
    }
}


