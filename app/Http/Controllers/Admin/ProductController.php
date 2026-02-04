<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'company']);

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(10);
        $categories = Category::active()->get();
        $companies = Company::all();

        return view('admin.products.index', compact('products', 'categories', 'companies'));
    }

    /**
     * Display stock of all products.
     */
    public function stock(Request $request)
    {
        $query = Product::with(['category', 'company']);

        // Search by name
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by stock level
        if ($request->filled('level')) {
            if ($request->level === 'out') {
                $query->where('stock', '<=', 0);
            } elseif ($request->level === 'low') {
                $query->where('stock', '>', 0)->where('stock', '<=', 5);
            }
        }

        $products = $query->latest()->paginate(15);
        
        return view('admin.products.stock', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::active()->get();
        $companies = Company::all();
        return view('admin.products.create', compact('categories', 'companies'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($data);

        // Handle features
        if ($request->filled('features')) {
            foreach ($request->features as $feature) {
                if ($feature) {
                    $product->features()->create(['name' => $feature]);
                }
            }
        }

        // Handle specifications
        if ($request->filled('specifications')) {
            foreach ($request->specifications as $specification) {
                if ($specification) {
                    $product->specifications()->create(['name' => $specification]);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'تم إضافة المنتج بنجاح');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        $companies = Company::all();
        return view('admin.products.edit', compact('product', 'categories', 'companies'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        // Sync features
        $product->features()->delete();
        if ($request->filled('features')) {
            foreach ($request->features as $feature) {
                if ($feature) {
                    $product->features()->create(['name' => $feature]);
                }
            }
        }

        // Sync specifications
        $product->specifications()->delete();
        if ($request->filled('specifications')) {
            foreach ($request->specifications as $specification) {
                if ($specification) {
                    $product->specifications()->create(['name' => $specification]);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'تم تحديث المنتج بنجاح');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Delete image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'تم حذف المنتج بنجاح');
    }
}
