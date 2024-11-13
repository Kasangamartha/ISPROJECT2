<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        // Validate the incoming request data
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt to authenticate the user with the provided credentials
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Get the currently authenticated user
            $user = Auth::user();

            // Check the user's role and redirect accordingly
            if ($user->role_id == 1) {
                // Redirect to Admin dashboard with success message
                return redirect()->route('admin.dashboard')->with('status', 'Successfully logged in as Admin');
            } elseif ($user->role_id == 2) {
                // Redirect to Manager dashboard with success message
                return redirect()->route('manager.dashboard')->with('status', 'Successfully logged in as Manager');
            } elseif ($user->role_id == 3) {
                // Redirect to Salesperson dashboard with success message
                return redirect()->route('salesperson.dashboard')->with('status', 'Successfully logged in as Salesperson');
            }

            // Default redirect (optional)
            return redirect()->intended('dashboard');
        }

        // If authentication fails, redirect back with an error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
