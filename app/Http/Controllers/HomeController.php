<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Sale;
use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Fetch products with categories
            $products = Product::with('category')->get();
            
            // Fetch all categories
            $categories = Category::all();
            
            // Calculate stats
            $stats = [
                'total_products' => $products->count(),
                'customers' => Customer::count(),
                'total_sales' => Sale::sum('total'),
                'orders_today' => Sale::whereDate('created_at', today())->count(),
            ];

            Log::info('HomeController data:', [
                'products_count' => $products->count(),
                'categories_count' => $categories->count(),
                'stats' => $stats,
                'search' => $request->get('search')
            ]);

            return Inertia::render('Welcome', [
                'products' => $products,
                'categories' => $categories,
                'stats' => $stats,
                'search' => $request->get('search'), // Pass search query to frontend
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
            ]);
        } catch (\Exception $e) {
            Log::error('HomeController error: ' . $e->getMessage());
            
            // Return minimal data to prevent black screen
            return Inertia::render('Welcome', [
                'products' => [],
                'categories' => [],
                'stats' => [
                    'total_products' => 0,
                    'customers' => 0,
                    'total_sales' => 0,
                    'orders_today' => 0,
                ],
                'search' => $request->get('search'),
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
            ]);
        }
    }

    /**
     * Get latest products data (for real-time updates)
     */
    public function getProducts()
    {
        try {
            $products = Product::with('category')->get();
            $categories = Category::all();
            
            $stats = [
                'total_products' => $products->count(),
                'customers' => Customer::count(),
                'total_sales' => Sale::sum('total'),
                'orders_today' => Sale::whereDate('created_at', today())->count(),
            ];

            return response()->json([
                'success' => true,
                'products' => $products,
                'categories' => $categories,
                'stats' => $stats,
            ]);
        } catch (\Exception $e) {
            Log::error('HomeController getProducts error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch products',
            ], 500);
        }
    }
}