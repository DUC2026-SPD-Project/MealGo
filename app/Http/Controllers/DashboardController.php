<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\User;
use App\Models\Sale;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Real-time comprehensive stats
        $totalProducts = Product::count();
        $totalEmployees = User::role(['staff', 'admin'])->count();
        $totalCustomers = Customer::count();
        $totalCategories = Category::count();
        
        // Sales analytics
        $totalSales = Sale::sum('total') ?? 0;
        $todaySales = Sale::whereDate('created_at', today())->sum('total') ?? 0;
        $monthlySales = Sale::whereMonth('created_at', now()->month)->sum('total') ?? 0;
        $totalOrders = Sale::count();
        
        // Performance metrics
        $avgOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;
        $todayOrders = Sale::whereDate('created_at', today())->count();
        
        // Low stock alerts
        $lowStockProducts = Product::where('qty', '<=', DB::raw('alert_qty'))
            ->where('status', 'active')
            ->get(['id', 'name_en', 'qty', 'alert_qty', 'image']);
        
        // Recent sales with relationships
        $recentSales = Sale::with(['saleItems' => function($query) {
            $query->with('product:id,name_en,image');
        }])
            ->latest()
            ->take(10)
            ->get();
        
        // Top selling products
        $topProducts = DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->select('products.name_en', 'products.image', DB::raw('SUM(sale_items.quantity) as total_sold'), DB::raw('SUM(sale_items.quantity * sale_items.price) as revenue'))
            ->groupBy('products.id', 'products.name_en', 'products.image')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();
        
        // Sales chart data (last 30 days)
        $salesChartData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $sales = Sale::whereDate('created_at', $date)->sum('total') ?? 0;
            $orders = Sale::whereDate('created_at', $date)->count();
            $salesChartData[] = [
                'date' => $date->format('M d'),
                'sales' => $sales,
                'orders' => $orders,
                'full_date' => $date->format('Y-m-d')
            ];
        }
        
        // Monthly comparison & growth
        $currentMonth = Sale::whereMonth('created_at', now()->month)->sum('total') ?? 0;
        $lastMonth = Sale::whereMonth('created_at', now()->subMonth()->month)->sum('total') ?? 0;
        $salesGrowth = $lastMonth > 0 ? (($currentMonth - $lastMonth) / $lastMonth) * 100 : 0;
        
        // Today's attendance
        $todayAttendance = Attendance::whereDate('date', today())
            ->with('user:id,name,email')
            ->get();
        
        // Active employees (currently working)
        $activeEmployees = Attendance::whereDate('date', today())
            ->whereNotNull('clock_in')
            ->whereNull('clock_out')
            ->count();
        
        // Category performance
        $categoryStats = DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(sale_items.quantity * sale_items.price) as revenue'), DB::raw('COUNT(*) as items_sold'))
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('revenue', 'desc')
            ->take(5)
            ->get();
        
        // Recent activities (last 20 activities)
        $recentActivities = collect();
        
        // Add recent sales
        $recentSalesActivity = Sale::latest()->take(5)->get()->map(function($sale) {
            return [
                'type' => 'sale',
                'title' => 'New Sale',
                'description' => "Order #{$sale->order_number} - $" . number_format($sale->total, 2),
                'time' => $sale->created_at,
                'icon' => 'mdi-cash-register',
                'color' => 'success'
            ];
        });
        
        // Add recent products
        $recentProductsActivity = Product::latest()->take(3)->get()->map(function($product) {
            return [
                'type' => 'product',
                'title' => 'Product Added',
                'description' => $product->name_en,
                'time' => $product->created_at,
                'icon' => 'mdi-package-variant',
                'color' => 'info'
            ];
        });
        
        $recentActivities = $recentActivities->merge($recentSalesActivity)->merge($recentProductsActivity)
            ->sortByDesc('time')->take(10)->values();

        return Inertia::render('Dashboard', [
            'stats' => [
                [
                    'title' => 'Total Revenue',
                    'value' => '$' . number_format($totalSales, 2),
                    'icon' => 'mdi-cash-multiple',
                    'color' => 'success',
                    'trend' => round($salesGrowth, 1),
                    'subtitle' => 'All time sales',
                    'change' => $salesGrowth > 0 ? '+' . round($salesGrowth, 1) . '%' : round($salesGrowth, 1) . '%'
                ],
                [
                    'title' => 'Today\'s Sales',
                    'value' => '$' . number_format($todaySales, 2),
                    'icon' => 'mdi-chart-line',
                    'color' => 'primary',
                    'subtitle' => number_format($todayOrders) . ' orders today',
                    'trend' => $todayOrders
                ],
                [
                    'title' => 'Total Products',
                    'value' => number_format($totalProducts),
                    'icon' => 'mdi-package-variant',
                    'color' => 'info',
                    'subtitle' => number_format($lowStockProducts->count()) . ' low stock',
                    'alert' => $lowStockProducts->count() > 0
                ],
                [
                    'title' => 'Active Staff',
                    'value' => $activeEmployees . '/' . $totalEmployees,
                    'icon' => 'mdi-account-clock',
                    'color' => 'secondary',
                    'subtitle' => 'Currently working',
                    'percentage' => $totalEmployees > 0 ? round(($activeEmployees / $totalEmployees) * 100) : 0
                ],
                [
                    'title' => 'Total Orders',
                    'value' => number_format($totalOrders),
                    'icon' => 'mdi-shopping',
                    'color' => 'warning',
                    'subtitle' => 'Avg: $' . number_format($avgOrderValue, 2),
                    'trend' => $avgOrderValue
                ],
                [
                    'title' => 'Customers',
                    'value' => number_format($totalCustomers),
                    'icon' => 'mdi-account-group',
                    'color' => 'purple',
                    'subtitle' => 'Registered users',
                    'growth' => '+12%'
                ]
            ],
            'charts' => [
                'sales' => $salesChartData,
                'categories' => $categoryStats,
                'topProducts' => $topProducts
            ],
            'tables' => [
                'recentSales' => $recentSales,
                'lowStock' => $lowStockProducts,
                'attendance' => $todayAttendance
            ],
            'activities' => $recentActivities,
            'insights' => [
                'monthly_sales' => $monthlySales,
                'sales_growth' => round($salesGrowth, 1),
                'low_stock_count' => $lowStockProducts->count(),
                'active_employees' => $activeEmployees,
                'total_employees' => $totalEmployees,
                'avg_order_value' => $avgOrderValue,
                'today_orders' => $todayOrders
            ]
        ]);
    }
    
    public function realTimeData()
    {
        // Real-time API endpoint for live updates
        $todaySales = Sale::whereDate('created_at', today())->sum('total') ?? 0;
        $todayOrders = Sale::whereDate('created_at', today())->count();
        $activeEmployees = Attendance::whereDate('date', today())
            ->whereNotNull('clock_in')
            ->whereNull('clock_out')
            ->count();
        $lowStockCount = Product::where('qty', '<=', DB::raw('alert_qty'))
            ->where('status', 'active')
            ->count();
        $recentSale = Sale::latest()->first();
        
        return response()->json([
            'today_sales' => $todaySales,
            'today_orders' => $todayOrders,
            'active_employees' => $activeEmployees,
            'low_stock_count' => $lowStockCount,
            'recent_sale' => $recentSale,
            'timestamp' => now()->toISOString(),
            'status' => 'connected'
        ]);
    }
    
    public function notifications()
    {
        // Get system notifications
        $notifications = [];
        
        // Get cached notifications from checkout process
        $cachedNotifications = cache()->get('admin_notifications', []);
        $notifications = array_merge($notifications, $cachedNotifications);
        
        // Low stock notifications
        $lowStock = Product::where('qty', '<=', DB::raw('alert_qty'))
            ->where('status', 'active')
            ->get();
            
        foreach ($lowStock as $product) {
            $notifications[] = [
                'id' => 'low-stock-' . $product->id,
                'type' => 'warning',
                'title' => 'Low Stock Alert',
                'message' => "{$product->name_en} is running low ({$product->qty} left)",
                'icon' => 'mdi-alert-circle',
                'time' => now()->toISOString(),
                'action' => [
                    'text' => 'Restock',
                    'url' => route('products.edit', $product->id)
                ]
            ];
        }
        
        return response()->json([
            'notifications' => collect($notifications)->sortByDesc('time')->take(20)->values(),
            'count' => count($notifications)
        ]);
    }
}