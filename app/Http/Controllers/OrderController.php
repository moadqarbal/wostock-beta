<?php

namespace App\Http\Controllers;

use App\Models\Client;
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
        $pendingCount = Order::where('status', 'En attente')
            ->count();

        $shippedCount = Order::where('status', 'Expédiée')
            ->count();

        $deliveredCount = Order::where('status', 'Livrée')
            ->count();

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

        return view('orders.create', compact('clients', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],

            'source' => [
                'required',
                'in:manuelle,whatsapp,site_web,woocommerce',
            ],

            'status' => [
                'required',
                'in:En attente,Confirmée,Expédiée,Livrée,Annulée,Retournée',
            ],

            'shipping_cost' => ['required', 'numeric', 'min:0'],

            'products' => ['required', 'array', 'min:1'],

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

            foreach ($validated['products'] as $item) {

                $product = Product::findOrFail($item['product_id']);

                $quantity = (int) $item['quantity'];

                if (
                    $validated['status'] === 'Livrée' &&
                    $quantity > $product->stock_quantity
                ) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'products' => "Stock insuffisant pour le produit : {$product->name}.",
                    ]);
                }
            }

            $order = Order::create([
                'client_id' => $validated['client_id'],
                'order_number' => 'CMD-' . now()->format('Ymd-His') . '-' . strtoupper(Str::random(4)),
                'source' => $validated['source'],
                'status' => $validated['status'],
                'subtotal' => 0,
                'shipping_cost' => $validated['shipping_cost'],
                'total_amount' => 0,
            ]);

            foreach ($validated['products'] as $item) {

                $product = Product::findOrFail($item['product_id']);

                $quantity = (int) $item['quantity'];
                $price = $product->price;

                $itemSubtotal = $price * $quantity;

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $itemSubtotal,
                ]);

                $subtotal += $itemSubtotal;

                if ($validated['status'] === 'Livrée') {
                    $product->decrement('stock_quantity', $quantity);
                }
            }

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

        return view('orders.show', compact(
            'order',
            'statuses'
        ));
    }

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

        DB::transaction(function () use ($order, $oldStatus, $newStatus) {

            $order->load('items.product');

            // Order devient Livrée → diminuer le stock
            if (
                $oldStatus !== 'Livrée' &&
                $newStatus === 'Livrée'
            ) {
                foreach ($order->items as $item) {

                    $product = $item->product;

                    if ($item->quantity > $product->stock_quantity) {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'status' => "Stock insuffisant pour le produit : {$product->name}.",
                        ]);
                    }

                    $product->decrement(
                        'stock_quantity',
                        $item->quantity
                    );
                }
            }

            // Order quitte Livrée vers Retournée → restaurer le stock
            if (
                $oldStatus === 'Livrée' &&
                $newStatus === 'Retournée'
            ) {
                foreach ($order->items as $item) {

                    $item->product->increment(
                        'stock_quantity',
                        $item->quantity
                    );
                }
            }

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

            $subtotal = 0;

            /*
        |--------------------------------------------------------------------------
        | Stock adjustment
        |--------------------------------------------------------------------------
        */

            if ($order->status === 'Livrée') {

                $oldItems = $order->items()
                    ->get()
                    ->keyBy('product_id');

                $newItems = collect($validated['products'])
                    ->groupBy('product_id')
                    ->map(function ($items) {
                        return $items->sum('quantity');
                    });

                // Products الموجودة قبل وما بقاتش في order
                foreach ($oldItems as $productId => $oldItem) {

                    $newQuantity = $newItems->get($productId, 0);

                    $difference = $newQuantity - $oldItem->quantity;

                    if ($difference > 0) {

                        $product = Product::findOrFail($productId);

                        if ($difference > $product->stock_quantity) {
                            throw \Illuminate\Validation\ValidationException::withMessages([
                                'products' => "Stock insuffisant pour le produit : {$product->name}.",
                            ]);
                        }

                        $product->decrement(
                            'stock_quantity',
                            $difference
                        );
                    } elseif ($difference < 0) {

                        Product::findOrFail($productId)->increment(
                            'stock_quantity',
                            abs($difference)
                        );
                    }
                }

                // Products جديدة ما كانتش في order
                foreach ($newItems as $productId => $newQuantity) {

                    if (!$oldItems->has($productId)) {

                        $product = Product::findOrFail($productId);

                        if ($newQuantity > $product->stock_quantity) {
                            throw \Illuminate\Validation\ValidationException::withMessages([
                                'products' => "Stock insuffisant pour le produit : {$product->name}.",
                            ]);
                        }

                        $product->decrement(
                            'stock_quantity',
                            $newQuantity
                        );
                    }
                }
            }

        /*
        |--------------------------------------------------------------------------
        | Update order
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

            foreach ($validated['products'] as $item) {

                $product = Product::findOrFail($item['product_id']);

                $quantity = (int) $item['quantity'];
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
        $order->delete();

        return to_route('orders.index')
            ->with('success', 'La commande a été supprimée avec succès.');
    }
}
