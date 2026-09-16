<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Product::with(['category', 'supplier']);

        // Search
        $search = request('search');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhereHas('supplier', function ($q) use ($search) {
                        $q->where('company_name', 'like', "%{$search}%");
                    });
            });
        }

        // Stock filter
        $stock = request('stock');

        if ($stock === 'disponible') {
            $query->where('stock_quantity', '>', 0);
        }

        if ($stock === 'faible') {
            $query->where('stock_quantity', '>', 0)
                ->whereColumn(
                    'stock_quantity',
                    '<=',
                    'minimum_stock'
                );
        }

        if ($stock === 'rupture') {
            $query->where('stock_quantity', 0);
        }

        // Pagination
        $products = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('company_name')->get();

        return view('products.create', compact('categories', 'suppliers'));
    }

    public function store(Request $request)
    {

        $request->merge([
            'stock_quantity' => (int) $request->stock_quantity,
            'minimum_stock' => $request->minimum_stock !== null
                ? (int) $request->minimum_stock
                : null,
        ]);

        $validated = $request->validate([
            // ...
            'stock_quantity' => 'required|integer|min:0',
            'minimum_stock' => 'nullable|integer|min:0',
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku',
            'category_id' => 'nullable|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'minimum_stock' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        if ($request->hasFile('image')) {

            $manager = new ImageManager(new Driver());

            $image = $manager->decode(
                $request->file('image')->getPathname()
            );

            // Resize large images
            if ($image->width() > 1600) {
                $image->scale(width: 1600);
            }

            $maxSize = 90 * 1024;
            $quality = 85;

            do {
                $encoded = $image->encodeUsingFormat(
                    Format::WEBP,
                    quality: $quality
                );

                if ($encoded->size() <= $maxSize) {
                    break;
                }

                if ($quality > 30) {
                    $quality -= 10;
                } else {
                    $image->scale(
                        width: max(300, (int) ($image->width() * 0.8))
                    );

                    $quality = 85;
                }
            } while (true);

            $tempPath = tempnam(sys_get_temp_dir(), 'product_');

            file_put_contents(
                $tempPath,
                (string) $encoded
            );

            $file = new \Illuminate\Http\UploadedFile(
                $tempPath,
                'product.webp',
                'image/webp',
                null,
                true
            );

            $validated['image'] = $file->store(
                'products',
                'public'
            );

            unlink($tempPath);
        }

        Product::create($validated);

        return to_route('products.index')
            ->with('success', 'Le produit a été ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load([
            'category',
            'supplier',
            'orderItems.order.client',
        ]);

        $totalSold = $product->orderItems->sum('quantity');

        $totalRevenue = $product->orderItems->sum('subtotal');

        return view('products.show', compact(
            'product',
            'totalSold',
            'totalRevenue'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $suppliers = Supplier::orderBy('company_name')->get();

        return view('products.edit', compact(
            'product',
            'categories',
            'suppliers'
        ));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->merge([
            'stock_quantity' => (int) $request->stock_quantity,
            'minimum_stock' => $request->minimum_stock !== null
                ? (int) $request->minimum_stock
                : null,
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
            'category_id' => 'nullable|exists:categories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'minimum_stock' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        if ($request->hasFile('image')) {

            $manager = new ImageManager(new Driver());

            $image = $manager->decode(
                $request->file('image')->getPathname()
            );

            // Resize large images
            if ($image->width() > 1600) {
                $image->scale(width: 1600);
            }

            $maxSize = 90 * 1024;
            $quality = 85;

            do {
                $encoded = $image->encodeUsingFormat(
                    Format::WEBP,
                    quality: $quality
                );

                if ($encoded->size() <= $maxSize) {
                    break;
                }

                if ($quality > 30) {
                    $quality -= 10;
                } else {
                    $image->scale(
                        width: max(300, (int) ($image->width() * 0.8))
                    );

                    $quality = 85;
                }
            } while (true);

            $tempPath = tempnam(sys_get_temp_dir(), 'product_');

            file_put_contents(
                $tempPath,
                (string) $encoded
            );

            $file = new \Illuminate\Http\UploadedFile(
                $tempPath,
                'product.webp',
                'image/webp',
                null,
                true
            );

            // Delete old image
            if ($product->image) {
                $oldImagePath = public_path('uploads/' . $product->image);

                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $validated['image'] = $file->store(
                'products',
                'public'
            );

            unlink($tempPath);
        }

        $product->update($validated);

        return to_route('products.show', $product)
            ->with('success', 'Le produit a été modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image) {
            $imagePath = public_path('uploads/' . $product->image);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $product->delete();

        return to_route('products.index')
            ->with('success', 'Le produit a été supprimé avec succès.');
    }

    public function trashed()
    {
        $products = Product::onlyTrashed()
            ->with(['category', 'supplier'])
            ->latest('deleted_at')
            ->paginate(10);

        return view('products.trashed', compact('products'));
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);

        $product->restore();

        return to_route('products.trashed')
            ->with('success', 'Le produit a été restauré avec succès.');
    }

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);

        $product->forceDelete();

        return to_route('products.trashed')
            ->with('success', 'Le produit a été supprimé définitivement.');
    }
}
