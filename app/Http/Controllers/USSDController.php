<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class USSDController extends Controller
{
    public function handleUSSD(Request $request)
    {
        $text = $request->input('text'); // Text entered by the user
        $sessionId = $request->input('sessionId');
        $phoneNumber = $request->input('+254799868379');
        $serviceCode = $request->input('serviceCode');
    
        $response = "";
    
        if ($text == "") {
            // Initial menu
            $response = "CON Welcome to the Engine Inventory System\n";
            $response .= "1. View Engine Status\n";
            $response .= "2. Update Engine Status\n";
        } elseif ($text == "1") {
            // Fetch engine status from database
            $unsoldEngines = DB::table('engines')->where('status', 'unsold')->count();
            $response = "END There are {$unsoldEngines} unsold engines.";
        } elseif (str_starts_with($text, "2*")) {
            $serialNumber = explode("*", $text)[1];
            DB::table('engines')->where('serial_number', $serialNumber)->update(['status' => 'sold']);
            $response = "END Engine Serial Number {$serialNumber} updated successfully.";
        } elseif ($text == "2") {
            // Ask for engine serial number
            $response = "CON Enter Engine Serial Number:\n";
        } else {
            $response = "END Invalid choice.";
        }
    
        return response($response, 200)
            ->header('Content-Type', 'text/plain');
    }
    
}

