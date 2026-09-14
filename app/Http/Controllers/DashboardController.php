<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Dashboard;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::latest()->take(5)->get();

        $todayOrders = Order::whereDate('created_at', today())->count();

        return view('dashboard.index', compact('orders', 'todayOrders'));
    }

    public function analytics()
{
    $period = request('period', '7');

    /*
    |--------------------------------------------------------------------------
    | Date Range
    |--------------------------------------------------------------------------
    */

    $endDate = now()->endOfDay();

    if ($period === '7') {
        $startDate = now()->subDays(6)->startOfDay();
    } elseif ($period === '30') {
        $startDate = now()->subDays(29)->startOfDay();
    } elseif ($period === '90') {
        $startDate = now()->subDays(89)->startOfDay();
    } else {
        $startDate = null;
    }


    /*
    |--------------------------------------------------------------------------
    | Orders Query
    |--------------------------------------------------------------------------
    */

    $ordersQuery = Order::query()
        ->whereNotIn('status', [
            'Annulée',
            'Retournée',
        ]);

    if ($startDate) {
        $ordersQuery->whereBetween('created_at', [
            $startDate,
            $endDate
        ]);
    }


    $orders = $ordersQuery->get();


    /*
    |--------------------------------------------------------------------------
    | KPIs
    |--------------------------------------------------------------------------
    */

    $totalRevenue = $orders->sum('total_amount');

    $totalOrders = $orders->count();

    $averageOrder = $totalOrders > 0
        ? $totalRevenue / $totalOrders
        : 0;


    /*
    |--------------------------------------------------------------------------
    | New Clients
    |--------------------------------------------------------------------------
    */

    $clientsQuery = Client::query();

    if ($startDate) {
        $clientsQuery->whereBetween('created_at', [
            $startDate,
            $endDate
        ]);
    }

    $newClients = $clientsQuery->count();


    /*
    |--------------------------------------------------------------------------
    | Revenue Chart
    |--------------------------------------------------------------------------
    */

    $revenueChart = [];

    if ($period === '7') {

        $days = 7;

    } elseif ($period === '30') {

        $days = 30;

    } elseif ($period === '90') {

        $days = 90;

    } else {

        /*
        | Pour "Tout le temps", on récupère la date
        | de la première commande.
        */

        $firstOrderDate = Order::min('created_at');

        $days = $firstOrderDate
            ? now()->diffInDays(
                \Carbon\Carbon::parse($firstOrderDate)
            ) + 1
            : 1;
    }


    /*
    |--------------------------------------------------------------------------
    | Chart
    |--------------------------------------------------------------------------
    |
    | Pour éviter 90+ points dans le graphique,
    | on garde les jours pour 7 jours,
    | et on utilise les jours également pour 30/90.
    |
    */

    for ($i = $days - 1; $i >= 0; $i--) {

        $date = now()->subDays($i);

        $revenueQuery = Order::query()
            ->whereDate(
                'created_at',
                $date->toDateString()
            )
            ->whereNotIn('status', [
                'Annulée',
                'Retournée',
            ]);

        $revenue = $revenueQuery->sum('total_amount');

        $revenueChart[] = [
            'label' => $date->format('d/m'),
            'date' => $date->format('Y-m-d'),
            'revenue' => (float) $revenue,
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Sources
    |--------------------------------------------------------------------------
    */

    $sourceQuery = Order::query()
        ->whereNotIn('status', [
            'Annulée',
            'Retournée',
        ]);

    if ($startDate) {
        $sourceQuery->whereBetween('created_at', [
            $startDate,
            $endDate
        ]);
    }

    $sourceStats = $sourceQuery
        ->select(
            'source',
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('source')
        ->pluck('total', 'source');


    $sourceChart = [
        'whatsapp' => $sourceStats->get('whatsapp', 0),

        'woocommerce' => $sourceStats->get('woocommerce', 0),

        'manuelle' => $sourceStats->get('manuelle', 0),

        'site_web' => $sourceStats->get('site_web', 0),
    ];


    /*
    |--------------------------------------------------------------------------
    | Top Products
    |--------------------------------------------------------------------------
    */

    $topProductsQuery = OrderItem::query()
        ->whereHas('order', function ($query) use (
            $startDate,
            $endDate
        ) {

            $query->whereNotIn('status', [
                'Annulée',
                'Retournée',
            ]);

            if ($startDate) {
                $query->whereBetween('created_at', [
                    $startDate,
                    $endDate
                ]);
            }

        });


    $topProducts = $topProductsQuery
        ->select(
            'product_id',
            DB::raw('SUM(quantity) as total_quantity')
        )
        ->groupBy('product_id')
        ->orderByDesc('total_quantity')
        ->with('product')
        ->take(5)
        ->get();


    /*
    |--------------------------------------------------------------------------
    | Critical Stock
    |--------------------------------------------------------------------------
    */

    $criticalProducts = Product::with('supplier')
        ->whereColumn(
            'stock_quantity',
            '<=',
            'minimum_stock'
        )
        ->orderBy('stock_quantity')
        ->take(5)
        ->get();


    /*
    |--------------------------------------------------------------------------
    | View
    |--------------------------------------------------------------------------
    */

    return view('dashboard.analytics', compact(
        'period',
        'totalRevenue',
        'totalOrders',
        'averageOrder',
        'newClients',
        'revenueChart',
        'sourceChart',
        'topProducts',
        'criticalProducts'
    ));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Dashboard $dashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }
}
