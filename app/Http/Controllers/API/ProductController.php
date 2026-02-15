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
        $products = Product::query()
            ->active()
            ->with(['category', 'company', 'features', 'specifications'])

            // Multiple Categories Filter
            ->when($request->filled('category_ids'), function ($query) use ($request) {

                $categoryIds = is_array($request->category_ids)
                    ? $request->category_ids
                    : explode(',', $request->category_ids);

                if (!empty($categoryIds)) {
                    $query->whereIn('category_id', $categoryIds);
                }
            })

            // Price Range
            ->when($request->filled('min_price'), fn($q) =>
                $q->where('price', '>=', $request->min_price)
            )

            ->when($request->filled('max_price'), fn($q) =>
                $q->where('price', '<=', $request->max_price)
            )

            // Search
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('description', 'like', '%' . $request->search . '%');
                });
            })
            
            // Company Name Search
            ->when($request->filled('company_name'), function ($q) use ($request) {
                $q->whereHas('company', function ($sub) use ($request) {
                    $sub->where('name', 'like', '%' . $request->company_name . '%');
                });
            })

            // In Stock
            ->when($request->boolean('in_stock'), fn($q) =>
                $q->inStock()
            )

            // Sorting
            ->when($request->filled('sort_by'), function ($q) use ($request) {

                match ($request->sort_by) {
                    'price_asc'  => $q->orderBy('price', 'asc'),
                    'price_desc' => $q->orderBy('price', 'desc'),
                    'name'       => $q->orderBy('name', 'asc'),
                    default      => $q->latest(),
                };
            }, fn($q) => $q->latest())

            ->paginate($request->input('per_page', 15));
 
        $wishlistProductIds = [];
        if (auth('sanctum')->check()) {
            $wishlistProductIds = auth('sanctum')->user()->wishlistItems()->pluck('product_id')->toArray();
        }

        $products->through(function ($product) use ($wishlistProductIds) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'image' => $product->image_url,
                'price' => $product->price,
                'discount_price' => $product->discount_price,
                'final_price' => $product->final_price,
                'stock' => $product->stock,
                'is_favourite' => in_array($product->id, $wishlistProductIds),
                'category' => [
                    'id' => $product->category->id,
                    'name' => $product->category->name,
                ],
                'company' => $product->company ? [
                    'id' => $product->company->id,
                    'name' => $product->company->name,
                ] : null,
                'features' => $product->features->map(fn($f) => [
                    'id' => $f->id,
                    'name' => $f->name,
                ]),
                'specifications' => $product->specifications->map(fn($s) => [
                    'id' => $s->id,
                    'name' => $s->name,
                ]),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'تم جلب المنتجات بنجاح',
            'data' => $products->items(),
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
            ->with(['category', 'company', 'features', 'specifications'])
            ->find($id);

        if(! $product) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير موجود',
                'data' => null,
            ], 404);
        }
 
        $isFavourite = false;
        if (auth('sanctum')->check()) {
            $isFavourite = auth('sanctum')->user()->wishlistItems()->where('product_id', $product->id)->exists();
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
                'is_favourite' => $isFavourite,
                'category' => [
                    'id' => $product->category->id,
                    'name' => $product->category->name,
                ],
                'company' => $product->company ? [
                    'id' => $product->company->id,
                    'name' => $product->company->name,
                ] : null,
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
