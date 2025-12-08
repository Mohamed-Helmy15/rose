<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    use \App\Traits\LogActivity;

    public function index()
    {
        $products = Product::with(['categories', 'primaryImage'])
            ->latest()
            ->get();

            $lowStockCount = Product::lowStockCount();

        return view('dashboard.products.index', compact('products', 'lowStockCount'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('dashboard.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'reorder_level' => 'required|integer|min:0',
            'color' => 'required|string|max:7',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5048',
            'is_active' => 'sometimes|boolean',
        ]);

        $data = $request->only(['name', 'description', 'price', 'cost_price', 'reorder_level', 'color']);
        $data['is_active'] = $request->has('is_active');

        $product = Product::create($data);
        $product->categories()->sync($request->category_ids);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                \App\Models\ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index,
                ]);
            }
        }

        $this->logActivity('product_created', "تم إنشاء منتج جديد: {$product->name} (SKU: {$product->sku})");

        return redirect()->route('products.index')
            ->with('toast', ['type' => 'success', 'message' => 'تم إضافة المنتج بنجاح']);
    }

    public function show(Product $product)
    {
        $product->load(['categories', 'images']);
        return view('dashboard.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $product->load('categories');
        $categories = Category::active()->get();
        $productCategories = $product->categories->pluck('id')->toArray();
        return view('dashboard.products.edit', compact('product', 'categories', 'productCategories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'reorder_level' => 'required|integer|min:0',
            'color' => 'required|string|max:7',
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5048',
            'is_active' => 'sometimes|boolean',
        ]);

        $data = $request->only(['name', 'description', 'price', 'cost_price', 'reorder_level', 'color']);
        $data['is_active'] = $request->has('is_active');

        $product->update($data);
        $product->categories()->sync($request->category_ids);

        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = \App\Models\ProductImage::find($imageId);
                if ($image && $image->product_id == $product->id) {
                    Storage::disk('public')->delete($image->image_path);
                    $image->delete();
                }
            }
        }

        if ($request->hasFile('images')) {
            $currentMaxOrder = $product->images()->max('sort_order') ?? 0;

            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                \App\Models\ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => $product->images()->where('is_primary', true)->count() === 0 && $index === 0,
                    'sort_order' => $currentMaxOrder + 1 + $index,
                ]);
            }
        }


        $this->logActivity('product_updated', "تم تحديث المنتج: {$product->name}");

        return redirect()->route('products.index')
            ->with('toast', ['type' => 'success', 'message' => 'تم تحديث المنتج بنجاح']);
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $name = $product->name;
        $product->delete();

        $this->logActivity('product_deleted', "تم حذف المنتج: {$name}");

        return redirect()->route('products.index')
            ->with('toast', ['type' => 'success', 'message' => 'تم حذف المنتج بنجاح']);
    }
}