<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of active products.
     */
    public function index(Request $request)
    {
        $query = Product::active()->with('category')->with('features')->with('specifications');

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Search by name or description
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by in stock
        if ($request->filled('in_stock') && $request->in_stock) {
            $query->inStock();
        }

        // Sort
        $sortBy = $request->get('sort_by', 'latest');
        switch ($sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default:
                $query->latest();
        }

        $products = $query->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'تم جلب المنتجات بنجاح',
            'data' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'image' => $product->image_url,
                    'price' => $product->price,
                    'discount_price' => $product->discount_price,
                    'final_price' => $product->final_price,
                    'stock' => $product->stock,
                    'category' => [
                        'id' => $product->category->id,
                        'name' => $product->category->name,
                    ],
                    'features' => $product->features->map(function ($feature) {
                        return [
                            'id' => $feature->id,
                            'name' => $feature->name,
                        ];
                    }),
                    'specifications' => $product->specifications->map(function ($specification) {
                        return [
                            'id' => $specification->id,
                            'name' => $specification->name,
                        ];
                    }),
                ];
            }),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
        ]);
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        $product = Product::active()
            ->with(['category', 'features', 'specifications'])
            ->find($id);

        if(! $product) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير موجود',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم جلب المنتج بنجاح',
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'image' => $product->image_url,
                'price' => $product->price,
                'discount_price' => $product->discount_price,
                'final_price' => $product->final_price,
                'stock' => $product->stock,
                'category' => [
                    'id' => $product->category->id,
                    'name' => $product->category->name,
                ],
                'features' => $product->features->map(function ($feature) {
                    return [
                        'id' => $feature->id,
                        'name' => $feature->name,
                    ];
                }),
                'specifications' => $product->specifications->map(function ($specification) {
                    return [
                        'id' => $specification->id,
                        'name' => $specification->name,
                    ];
                }),
            ],
        ]);
    }
}
