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
            }

            $shippingCost = (float) $validated['shipping_cost'];

            $totalAmount = $subtotal + $shippingCost;

            $order->update([
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'total_amount' => $totalAmount,
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

        $order->update([
            'status' => $validated['status'],
        ]);

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

        DB::transaction(function () use ($validated, $order) {

            $subtotal = 0;

            $order->update([
                'client_id' => $validated['client_id'],
                'source' => $validated['source'],
                'status' => $validated['status'],
                'shipping_cost' => $validated['shipping_cost'],
            ]);

            // Supprimer les anciens produits
            $order->items()->delete();

            // Ajouter les nouveaux produits
            foreach ($validated['products'] as $item) {

                $product = Product::findOrFail(
                    $item['product_id']
                );

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
