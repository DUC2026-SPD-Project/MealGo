<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request; // You can keep this or remove it, it won't be used in the signature anymore
use Inertia\Inertia;
use Carbon\Carbon;

class ReportController extends Controller
{
    // CHANGE 1: Remove (Request $request) from here
    public function index() 
    {
        // CHANGE 2: Get the request using the helper function instead
        $request = request(); 

        // 1. Default to "Today" if no date selected
        $startDate = $request->start_date ?? Carbon::today()->toDateString();
        $endDate = $request->end_date ?? Carbon::today()->toDateString();

        // 2. Fetch Sales within that range
        $sales = Sale::with('user')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->latest()
            ->get();

        // 3. Calculate Totals
        $totalRevenue = $sales->sum('total_price');
        $totalTransactions = $sales->count();

        return Inertia::render('Reports/Index', [
            'sales' => $sales,
            'totalRevenue' => $totalRevenue,
            'totalTransactions' => $totalTransactions,
            'filters' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]
        ]);
    }
}