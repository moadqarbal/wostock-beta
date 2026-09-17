<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Dashboard;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

    public function help()
    {
        return view('dashboard.help');
    }

    public function proposeFeature()
    {
        return view('dashboard.propose-feature');
    }

    public function sendFeatureProposal(Request $request)
    {
        $validated = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        try {
            Mail::raw($validated['message'], function ($mail) use ($validated, $request) {
                $mail->to('wobranding1@gmail.com')
                    ->subject('WoStock Feature Proposal - ' . $validated['subject'])
                    ->replyTo(
                        $request->user()->email,
                        $request->user()->name
                    );
            });

            return back()->with(
                'success',
                'Votre proposition a été envoyée avec succès.'
            );
        } catch (\Throwable $e) {
            return back()->with(
                'error',
                'Impossible d’envoyer votre proposition. Vérifiez la configuration SMTP.'
            );
        }
    }

    public function exportAnalytics(Request $request)
    {
        $period = $request->get('period', '7');

        $startDate = null;

        if ($period !== 'all') {
            $startDate = now()->subDays((int) $period);
        }

        /*
    |--------------------------------------------------------------------------
    | Orders
    |--------------------------------------------------------------------------
    */

        $ordersQuery = Order::with('client')
            ->whereNotIn('status', ['Annulée', 'Retournée']);

        if ($startDate) {
            $ordersQuery->where('created_at', '>=', $startDate);
        }

        $orders = $ordersQuery
            ->latest()
            ->get();

        /*
    |--------------------------------------------------------------------------
    | Order Items
    |--------------------------------------------------------------------------
    */

        $orderIds = $orders->pluck('id');

        $orderItems = OrderItem::with([
            'order',
            'product.category',
            'product.supplier',
        ])
            ->whereIn('order_id', $orderIds)
            ->get();

        /*
    |--------------------------------------------------------------------------
    | Summary
    |--------------------------------------------------------------------------
    */

        $totalRevenue = $orders->sum('total_amount');

        $totalOrders = $orders->count();

        $averageOrder = $totalOrders > 0
            ? $totalRevenue / $totalOrders
            : 0;

        $newClientsQuery = Client::query();

        if ($startDate) {
            $newClientsQuery->where('created_at', '>=', $startDate);
        }

        $newClients = $newClientsQuery->count();

        $totalUnitsSold = $orderItems->sum('quantity');

        $totalProductsSold = $orderItems
            ->pluck('product_id')
            ->unique()
            ->count();

        /*
    |--------------------------------------------------------------------------
    | Clients
    |--------------------------------------------------------------------------
    */

        $clientStats = $orders
            ->groupBy('client_id')
            ->map(function ($clientOrders) {

                $client = $clientOrders->first()->client;

                return [
                    'client_id' => $client?->id,
                    'client_name' => $client?->name ?? 'Client supprimé',
                    'orders_count' => $clientOrders->count(),
                    'total_spent' => $clientOrders->sum('total_amount'),
                    'average_order' => $clientOrders->count() > 0
                        ? $clientOrders->sum('total_amount') / $clientOrders->count()
                        : 0,
                    'last_order' => $clientOrders->max('created_at')?->format('Y-m-d H:i'),
                ];
            });

        /*
    |--------------------------------------------------------------------------
    | Products / Stock
    |--------------------------------------------------------------------------
    */

        $products = Product::with([
            'category',
            'supplier',
        ])
            ->get();

        /*
    |--------------------------------------------------------------------------
    | Filename
    |--------------------------------------------------------------------------
    */

        $filename = 'wostock-ai-report-' . now()->format('Y-m-d-H-i-s') . '.csv';

        return response()->streamDownload(function () use (
            $orders,
            $orderItems,
            $products,
            $clientStats,
            $period,
            $totalRevenue,
            $totalOrders,
            $averageOrder,
            $newClients,
            $totalUnitsSold,
            $totalProductsSold
        ) {

            $handle = fopen('php://output', 'w');

            /*
        |--------------------------------------------------------------------------
        | UTF-8 BOM
        |--------------------------------------------------------------------------
        */

            fprintf(
                $handle,
                chr(0xEF) . chr(0xBB) . chr(0xBF)
            );

            /*
        |--------------------------------------------------------------------------
        | REPORT INFO
        |--------------------------------------------------------------------------
        */

            fputcsv($handle, [
                'WOSTOCK AI BUSINESS REPORT'
            ], ';');

            fputcsv($handle, [
                'Period',
                $period === 'all'
                    ? 'Tout le temps'
                    : $period . ' jours'
            ], ';');

            fputcsv($handle, [
                'Generated At',
                now()->format('Y-m-d H:i:s')
            ], ';');

            fputcsv($handle, [], ';');


            /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */

            fputcsv($handle, [
                'SUMMARY'
            ], ';');

            fputcsv($handle, [
                'Metric',
                'Value'
            ], ';');

            fputcsv($handle, [
                'Total Revenue',
                number_format($totalRevenue, 2, '.', '')
            ], ';');

            fputcsv($handle, [
                'Total Orders',
                $totalOrders
            ], ';');

            fputcsv($handle, [
                'Average Order Value',
                number_format($averageOrder, 2, '.', '')
            ], ';');

            fputcsv($handle, [
                'New Clients',
                $newClients
            ], ';');

            fputcsv($handle, [
                'Total Units Sold',
                $totalUnitsSold
            ], ';');

            fputcsv($handle, [
                'Different Products Sold',
                $totalProductsSold
            ], ';');

            fputcsv($handle, [], ';');


            /*
        |--------------------------------------------------------------------------
        | ORDERS
        |--------------------------------------------------------------------------
        */

            fputcsv($handle, [
                'ORDERS'
            ], ';');

            fputcsv($handle, [
                'Order ID',
                'Order Number',
                'Date',
                'Client',
                'Source',
                'Status',
                'Subtotal',
                'Shipping Cost',
                'Total Amount',
            ], ';');

            foreach ($orders as $order) {

                fputcsv($handle, [
                    $order->id,
                    $order->order_number,
                    $order->created_at?->format('Y-m-d H:i'),
                    $order->client?->name ?? 'Client supprimé',
                    $order->source,
                    $order->status,
                    number_format($order->subtotal, 2, '.', ''),
                    number_format($order->shipping_cost, 2, '.', ''),
                    number_format($order->total_amount, 2, '.', ''),
                ], ';');
            }

            fputcsv($handle, [], ';');


            /*
        |--------------------------------------------------------------------------
        | ORDER ITEMS
        |--------------------------------------------------------------------------
        */

            fputcsv($handle, [
                'ORDER ITEMS'
            ], ';');

            fputcsv($handle, [
                'Order Number',
                'Date',
                'Product',
                'SKU',
                'Category',
                'Supplier',
                'Quantity',
                'Unit Price',
                'Subtotal',
            ], ';');

            foreach ($orderItems as $item) {

                fputcsv($handle, [
                    $item->order?->order_number,
                    $item->order?->created_at?->format('Y-m-d H:i'),
                    $item->product?->name ?? 'Produit supprimé',
                    $item->product?->sku ?? '',
                    $item->product?->category?->name ?? '',
                    $item->product?->supplier?->company_name ?? '',
                    $item->quantity,
                    number_format($item->price, 2, '.', ''),
                    number_format($item->subtotal, 2, '.', ''),
                ], ';');
            }

            fputcsv($handle, [], ';');


            /*
        |--------------------------------------------------------------------------
        | STOCK
        |--------------------------------------------------------------------------
        */

            fputcsv($handle, [
                'CURRENT STOCK'
            ], ';');

            fputcsv($handle, [
                'Product',
                'SKU',
                'Category',
                'Supplier',
                'Price',
                'Current Stock',
                'Minimum Stock',
                'Stock Status',
            ], ';');

            foreach ($products as $product) {

                if ($product->stock_quantity <= 0) {
                    $stockStatus = 'Out of Stock';
                } elseif ($product->stock_quantity <= $product->minimum_stock) {
                    $stockStatus = 'Low Stock';
                } else {
                    $stockStatus = 'Normal';
                }

                fputcsv($handle, [
                    $product->name,
                    $product->sku,
                    $product->category?->name ?? '',
                    $product->supplier?->company_name ?? '',
                    number_format($product->price, 2, '.', ''),
                    $product->stock_quantity,
                    $product->minimum_stock,
                    $stockStatus,
                ], ';');
            }

            fputcsv($handle, [], ';');


            /*
        |--------------------------------------------------------------------------
        | CLIENTS
        |--------------------------------------------------------------------------
        */

            fputcsv($handle, [
                'CLIENTS'
            ], ';');

            fputcsv($handle, [
                'Client ID',
                'Client Name',
                'Number of Orders',
                'Total Spent',
                'Average Order',
                'Last Order',
            ], ';');

            foreach ($clientStats as $client) {

                fputcsv($handle, [
                    $client['client_id'],
                    $client['client_name'],
                    $client['orders_count'],
                    number_format($client['total_spent'], 2, '.', ''),
                    number_format($client['average_order'], 2, '.', ''),
                    $client['last_order'],
                ], ';');
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }


    public function error404()
    {
        return view('errors.404');
    }

    public function error500()
    {
        return view('errors.500');
    }
}
