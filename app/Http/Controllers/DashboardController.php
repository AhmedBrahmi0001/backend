<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Order; // Assuming you have an Order model
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the total number of drivers and orders.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Get the total number of drivers
        $totalDrivers = Driver::count();

        // Get the total number of orders
        $totalOrders = Order::count();

        // Dynamic baseline values (example)
        $orderTarget = 500; // The target number of orders
        $driverTarget = 100; // The target number of drivers

        // Calculate percentage based on the target for orders
        $orderPercentage = $totalOrders > 0 ? ($totalOrders / $orderTarget) * 100 : 0;

        // Calculate percentage based on the target for drivers
        $driverPercentage = $totalDrivers > 0 ? ($totalDrivers / $driverTarget) * 100 : 0;

        // Extra value: The difference between the current total and the target
        $orderExtra = $totalOrders - $orderTarget;
        $driverExtra = $totalDrivers - $driverTarget;

        return response()->json([
            'total_drivers' => $totalDrivers,
            'driver_percentage' => $driverPercentage,
            'driver_extra' => $driverExtra,
            'total_orders' => $totalOrders,
            'order_percentage' => $orderPercentage,
            'order_extra' => $orderExtra,
        ]);
    }

    public function weeklyStatistics()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $weeklyData = Order::selectRaw('DATE(delivered_date) as date, SUM(price) as total')
            ->whereBetween('delivered_date', [$startOfWeek, $endOfWeek])
            ->groupBy('date')
            ->get();

        $totalRevenue = $weeklyData->sum('total');
        $dailyTotals = $weeklyData->pluck('total');

        return response()->json([
            'total_revenue' => $totalRevenue,
            'daily_totals' => $dailyTotals,
        ]);
    }
}
