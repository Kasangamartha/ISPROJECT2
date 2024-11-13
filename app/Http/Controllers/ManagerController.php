<?php

namespace App\Http\Controllers;

use App\Models\Engine;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ManagerController extends Controller
{
    public function index()
    {
        // 1. Daily, weekly, and monthly sales counts
        $dailySales = Sale::selectRaw('DATE(date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->get();

        $weeklySales = Sale::selectRaw('WEEK(date) as week, COUNT(*) as count')
            ->groupBy('week')
            ->get();

        $monthlySales = Sale::selectRaw('MONTH(date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->get();

        // 2. Most sold and least sold models
        $mostSoldModels = Sale::join('engines', 'sales.engine_id', '=', 'engines.id')
            ->select('engines.model', DB::raw('COUNT(*) as count'))
            ->groupBy('engines.model')
            ->orderBy('count', 'desc')
            ->take(1)
            ->get();

        $leastSoldModels = Sale::join('engines', 'sales.engine_id', '=', 'engines.id')
            ->select('engines.model', DB::raw('COUNT(*) as count'))
            ->groupBy('engines.model')
            ->orderBy('count', 'asc')
            ->take(1)
            ->get();

        // 3. Count of unsold engines
        $unsoldCount = Engine::where('status', 'unsold')->count();

        // 4. Total amount earned and expected amount
        $amountEarned = Sale::sum('price');
        $expectedAmount = Engine::where('status', 'sold')->sum('price');

        // 5. Model sales count (Skygo, Honda, Yamaha)
        $modelSalesCounts = Sale::join('engines', 'sales.engine_id', '=', 'engines.id')
            ->select('engines.model', DB::raw('COUNT(*) as count'))
            ->groupBy('engines.model')
            ->get()
            ->pluck('count', 'model')
            ->toArray();

        // Ensure all models are represented in the data
        $models = ['Skygo', 'Honda', 'Yamaha'];
        foreach ($models as $model) {
            if (!isset($modelSalesCounts[$model])) {
                $modelSalesCounts[$model] = 0;
            }
        }

        // Return all data to the view
        return view('manager.dashboard', compact(
            'dailySales', 'weeklySales', 'monthlySales',
            'mostSoldModels', 'leastSoldModels', 'unsoldCount',
            'amountEarned', 'expectedAmount', 'modelSalesCounts'
        ));
    }

    // Method for searching an engine by serial number
    public function searchEngineBySerial(Request $request)
    {
        $serialNumber = $request->input('serial_number');
        $engine = Engine::where('serial_number', $serialNumber)->first();
    
        if (!$engine) {
            return redirect()->back()->with('error', 'Engine not found.');
        }
    
        return view('manager.search_result', compact('engine'));
    }
    
    // Method to update the engine status to "unsold" if marked "sold" incorrectly
    public function updateStatusToUnsold(Request $request, $id)
    {
        $engine = Engine::findOrFail($id);
    
        if ($engine->status === 'sold') {
            // Change engine status to "unsold"
            $engine->status = 'unsold';
            $engine->user_id = 0;
            $engine->save();
    
            // Remove the corresponding entry from the sales table
            Sale::where('engine_id', $engine->id)->delete();

            return redirect()->route('manager.dashboard')->with('success', 'Engine status updated to "unsold" and removed from sales records.');
        }

        return redirect()->route('manager.dashboard')->with('error', 'Engine status is already "unsold" and does not need correction.');
    }

    public function generateReport()
    {
        // Fetch necessary data from the database for the report
        $dailySales = Sale::whereDate('created_at', today())->count();
        $weeklySales = Sale::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $monthlySales = Sale::whereMonth('created_at', now()->month)->count();
    
        // Calculate model sales counts by joining sales and engines tables
        $modelSalesCounts = Sale::join('engines', 'sales.engine_id', '=', 'engines.id')
            ->select('engines.model', \DB::raw('count(*) as count'))
            ->groupBy('engines.model')
            ->get()
            ->pluck('count', 'model');
    
        // Count of unsold engines
        $unsoldCount = Engine::where('status', 'unsold')->count();
    
        // Total amount earned from all sales
        $amountEarned = Sale::sum('price');
    
        // Calculate expected amount
        // Assuming each unsold engine has a fixed expected price of 10,000 (or use a different formula if needed)
        $standardExpectedPrice = 1;
        $expectedAmount = $unsoldCount * $standardExpectedPrice;
    
        // Prepare the data array for the view
        $data = compact(
            'dailySales', 'weeklySales', 'monthlySales',
            'modelSalesCounts', 'unsoldCount', 'amountEarned', 'expectedAmount'
        );
    
        // Load the view and pass in data, then generate the PDF
        $pdf = PDF::loadView('manager.report', $data);
    
        return $pdf->stream('report.pdf');
    }
    
    
    
}
