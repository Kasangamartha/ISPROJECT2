<?php

namespace App\Http\Controllers;

use App\Models\Engine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EngineController extends Controller
{
    // Search for an engine by serial number
    public function search(Request $request)
    {
        // Validate the search input
        $request->validate([
            'serial_number' => 'required|string|max:255',
        ]);

        // Find the engine by serial number
        $engine = Engine::where('serial_number', $request->serial_number)->first();

        // If the engine is found, return the view with the engine details
        if ($engine) {
            return view('salesperson.engine_details', compact('engine'));
        } else {
            return redirect()->back()->with('status', 'Engine not found.');
        }
    }

    // Update the status of the engine, record user_id, and insert sale details
    public function update(Request $request, $id)
    {
        // Validate the update request
        $request->validate([
            'status' => 'required|string',
        ]);

        // Find the engine by ID
        $engine = Engine::findOrFail($id);

        if ($engine) {
            // Update the engine status to 'sold' and set the current user's ID
            if ($request->status === 'sold') {
                $engine->status = 'sold';
                $engine->user_id = Auth::id(); // Set the ID of the logged-in user

                // Insert into sales table using engine's price and default quantity of 1
                \DB::table('sales')->insert([
                    'engine_id' => $engine->id,
                    'date' => now(), // Current date/time
                    'quantity' => 1, // Set default quantity to 1
                    'price' => $engine->price, // Use the price from the engines table
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $engine->save();

            return redirect()->back()->with('success', 'Engine status updated and sale recorded successfully.');
        } else {
            return redirect()->back()->with('error', 'Engine not found.');
        }
    }
}
