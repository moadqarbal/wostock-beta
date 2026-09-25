<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Dashboard;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with([
            'client',
            'items.product',
        ]);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhereHas('client', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Source filter
        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        // Orders
        $orders = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Statistics
        $pendingCount = Order::where('status', 'En attente')->count();

        $shippedCount = Order::where('status', 'Expédiée')->count();

        $deliveredCount = Order::where('status', 'Livrée')->count();

        $todayTotal = Order::whereDate('created_at', today())
            ->sum('total_amount');

        return view('orders.index', compact(
            'orders',
            'pendingCount',
            'shippedCount',
            'deliveredCount',
            'todayTotal'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::orderBy('name')->get();

        $products = Product::where('stock_quantity', '>', 0)
            ->orderBy('name')
            ->get();

        return view('orders.create', compact(
            'clients',
            'products'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => [
                'required',
                'exists:clients,id',
            ],

            'source' => [
                'required',
                'in:manuelle,whatsapp,site_web,woocommerce',
            ],

            'status' => [
                'required',
                'in:En attente,Confirmée,Expédiée,Livrée,Annulée,Retournée',
            ],

            'shipping_cost' => [
                'required',
                'numeric',
                'min:0',
            ],

            'products' => [
                'required',
                'array',
                'min:1',
            ],

            'products.*.product_id' => [
                'required',
                'exists:products,id',
            ],

            'products.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        DB::transaction(function () use ($validated) {

            $subtotal = 0;

            /*
            |--------------------------------------------------------------------------
            | Group products
            |--------------------------------------------------------------------------
            */

            $products = collect($validated['products'])
                ->groupBy('product_id')
                ->map(function ($items) {
                    return $items->sum('quantity');
                });

            /*
            |--------------------------------------------------------------------------
            | Check stock
            |--------------------------------------------------------------------------
            |
            | Toujours vérifier le stock avant de créer la commande.
            |
            */

            foreach ($products as $productId => $quantity) {

                $product = Product::findOrFail($productId);

                if ($quantity > $product->stock_quantity) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'products' =>
<<<<<<< HEAD
                            "Stock insuffisant pour le produit : {$product->name}. " .
=======
                        "Stock insuffisant pour le produit : {$product->name}. " .
>>>>>>> 22a6ca1 (fix: improve product management, supplier search, lightbox, help , print branding and force-delete protection)
                            "Stock disponible : {$product->stock_quantity}. " .
                            "Quantité demandée : {$quantity}.",
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Create order
            |--------------------------------------------------------------------------
            */

            $order = Order::create([
                'client_id' => $validated['client_id'],

                'order_number' =>
<<<<<<< HEAD
                    'CMD-' .
=======
                'CMD-' .
>>>>>>> 22a6ca1 (fix: improve product management, supplier search, lightbox, help , print branding and force-delete protection)
                    now()->format('Ymd-His') .
                    '-' .
                    strtoupper(Str::random(4)),

                'source' => $validated['source'],
                'status' => $validated['status'],
                'subtotal' => 0,
                'shipping_cost' => $validated['shipping_cost'],
                'total_amount' => 0,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Create order items
            |--------------------------------------------------------------------------
            */

            foreach ($products as $productId => $quantity) {

                $product = Product::findOrFail($productId);

                $price = $product->price;

                $itemSubtotal = $price * $quantity;

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $itemSubtotal,
                ]);

                $subtotal += $itemSubtotal;
            }

            /*
            |--------------------------------------------------------------------------
            | Decrement stock only if Livrée
            |--------------------------------------------------------------------------
            */

            if ($validated['status'] === 'Livrée') {

                foreach ($products as $productId => $quantity) {

                    Product::findOrFail($productId)
                        ->decrement('stock_quantity', $quantity);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Update totals
            |--------------------------------------------------------------------------
            */

            $shippingCost = (float) $validated['shipping_cost'];

            $order->update([
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total_amount' => $subtotal + $shippingCost,
            ]);
        });

        return to_route('orders.index')
            ->with('success', 'La commande a été créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load([
            'client',
            'items.product',
        ]);

        $statuses = [
            'En attente',
            'Confirmée',
            'Expédiée',
            'Livrée',
            'Annulée',
            'Retournée',
        ];

        $dashboard = Dashboard::first();

        return view('orders.show', compact(
            'order',
            'statuses',
            'dashboard'
        ));
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:En attente,Confirmée,Expédiée,Livrée,Annulée,Retournée',
            ],
        ]);

        $oldStatus = $order->status;
        $newStatus = $validated['status'];

        if ($oldStatus === $newStatus) {
            return response()->json([
                'success' => true,
                'message' => 'Le statut est déjà ' . $newStatus . '.',
                'status' => $order->status,
            ]);
        }

        DB::transaction(function () use (
            $order,
            $oldStatus,
            $newStatus
        ) {

            $order->load('items.product');

            /*
            |--------------------------------------------------------------------------
            | Any status → Livrée
            |--------------------------------------------------------------------------
            |
            | Check ALL products first.
            |
            */

            if (
                $oldStatus !== 'Livrée' &&
                $newStatus === 'Livrée'
            ) {

                foreach ($order->items as $item) {

                    $product = $item->product;

                    if ($item->quantity > $product->stock_quantity) {

                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'status' =>
<<<<<<< HEAD
                                "Stock insuffisant pour le produit : {$product->name}. " .
=======
                            "Stock insuffisant pour le produit : {$product->name}. " .
>>>>>>> 22a6ca1 (fix: improve product management, supplier search, lightbox, help , print branding and force-delete protection)
                                "Stock disponible : {$product->stock_quantity}. " .
                                "Quantité demandée : {$item->quantity}.",
                        ]);
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | Decrement only after ALL checks passed
                |--------------------------------------------------------------------------
                */

                foreach ($order->items as $item) {

                    $item->product->decrement(
                        'stock_quantity',
                        $item->quantity
                    );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Livrée → Any other status
            |--------------------------------------------------------------------------
            |
            | Restore stock.
            |
            */

            if (
                $oldStatus === 'Livrée' &&
                $newStatus !== 'Livrée'
            ) {

                foreach ($order->items as $item) {

                    $item->product->increment(
                        'stock_quantity',
                        $item->quantity
                    );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Update status
            |--------------------------------------------------------------------------
            */

            $order->update([
                'status' => $newStatus,
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Le statut a été mis à jour avec succès.',
            'status' => $order->status,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $order->load([
            'client',
            'items.product',
        ]);

        $clients = Client::orderBy('name')->get();

        $products = Product::orderBy('name')->get();

        return view('orders.edit', compact(
            'order',
            'clients',
            'products'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'client_id' => [
                'required',
                'exists:clients,id',
            ],

            'source' => [
                'required',
                'in:manuelle,whatsapp,site_web,woocommerce',
            ],

            'shipping_cost' => [
                'required',
                'numeric',
                'min:0',
            ],

            'products' => [
                'required',
                'array',
                'min:1',
            ],

            'products.*.product_id' => [
                'required',
                'exists:products,id',
            ],

            'products.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        DB::transaction(function () use ($validated, $order) {

            /*
            |--------------------------------------------------------------------------
            | Old items
            |--------------------------------------------------------------------------
            */

            $oldItems = $order->items()
                ->get()
                ->groupBy('product_id')
                ->map(function ($items) {
                    return $items->sum('quantity');
                });

            /*
            |--------------------------------------------------------------------------
            | New items
            |--------------------------------------------------------------------------
            */

            $newItems = collect($validated['products'])
                ->groupBy('product_id')
                ->map(function ($items) {
                    return $items->sum('quantity');
                });

            /*
            |--------------------------------------------------------------------------
            | IMPORTANT
            |--------------------------------------------------------------------------
            |
            | If old status was Livrée and we change anything:
            |
            | First restore the OLD stock.
            |
            | Example:
            |
            | Old:
            | Product A = 3
            | Status = Livrée
            |
            | Stock already contains -3.
            |
            | If we change quantity to 5:
            |
            | Restore 3 first.
            | Then check the new quantity.
            |
            */

            if ($order->status === 'Livrée') {

                foreach ($oldItems as $productId => $oldQuantity) {

                    Product::findOrFail($productId)
                        ->increment(
                            'stock_quantity',
                            $oldQuantity
                        );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Check NEW stock
            |--------------------------------------------------------------------------
            |
            | At this point:
            |
            | - If old status was Livrée:
            |   old quantity has already been restored.
            |
            | - If old status wasn't Livrée:
            |   stock is unchanged.
            |
            */

            foreach ($newItems as $productId => $quantity) {

                $product = Product::findOrFail($productId);

                if ($quantity > $product->stock_quantity) {

                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'products' =>
<<<<<<< HEAD
                            "Stock insuffisant pour le produit : {$product->name}. " .
=======
                        "Stock insuffisant pour le produit : {$product->name}. " .
>>>>>>> 22a6ca1 (fix: improve product management, supplier search, lightbox, help , print branding and force-delete protection)
                            "Stock disponible : {$product->stock_quantity}. " .
                            "Quantité demandée : {$quantity}.",
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Update order information
            |--------------------------------------------------------------------------
            */

            $order->update([
                'client_id' => $validated['client_id'],
                'source' => $validated['source'],
                'shipping_cost' => $validated['shipping_cost'],
            ]);

            /*
            |--------------------------------------------------------------------------
            | Replace order items
            |--------------------------------------------------------------------------
            */

            $order->items()->delete();

            $subtotal = 0;

            foreach ($newItems as $productId => $quantity) {

                $product = Product::findOrFail($productId);

                $price = $product->price;

                $itemSubtotal = $price * $quantity;

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $itemSubtotal,
                ]);

                $subtotal += $itemSubtotal;
            }

            /*
            |--------------------------------------------------------------------------
            | New status is Livrée
            |--------------------------------------------------------------------------
            |
            | Decrement NEW quantities.
            |
            */

            if ($order->status === 'Livrée') {

                foreach ($newItems as $productId => $quantity) {

                    Product::findOrFail($productId)
                        ->decrement(
                            'stock_quantity',
                            $quantity
                        );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Update totals
            |--------------------------------------------------------------------------
            */

            $shippingCost = (float) $validated['shipping_cost'];

            $order->update([
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total_amount' => $subtotal + $shippingCost,
            ]);
        });

        return to_route('orders.show', $order)
            ->with('success', 'La commande a été mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        /*
        |--------------------------------------------------------------------------
        | If a delivered order is deleted,
        | restore its stock first.
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use ($order) {

            if ($order->status === 'Livrée') {

                $order->load('items.product');

                foreach ($order->items as $item) {

                    $item->product->increment(
                        'stock_quantity',
                        $item->quantity
                    );
                }
            }

            $order->delete();
        });

        return to_route('orders.index')
            ->with('success', 'La commande a été supprimée avec succès.');
    }
}