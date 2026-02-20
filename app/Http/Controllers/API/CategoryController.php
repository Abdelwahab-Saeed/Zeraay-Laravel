<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of active categories.
     */
    public function index()
    {
        $categories = Category::active()
            ->withCount('products')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'تم جلب الفئات بنجاح',
            'data' => $categories->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'description' => $category->description,
                    'image' => $category->image_url,
                    'products_count' => $category->products_count,
                ];
            }),
            'pagination' => [
                'current_page' => $categories->currentPage(),
                'last_page' => $categories->lastPage(),
                'per_page' => $categories->perPage(),
                'total' => $categories->total(),
            ],
        ]);
    }

    /**
     * Display the specified category with its products.
     */
    public function show($id)
    {
        $category = Category::active()
            ->with(['products' => function ($query) {
                $query->active()->inStock();
            }])
            ->find($id);

        if(! $category) {
            return response()->json([
                'success' => false,
                'message' => 'الفئة غير موجودة',
                'data' => null,
            ], 404);
        }

        $wishlistProductIds = [];
        $cartProductIds = [];
        if (auth('sanctum')->check()) {
            $user = auth('sanctum')->user();
            $wishlistProductIds = $user->wishlistItems()->pluck('product_id')->toArray();
            $cartProductIds = $user->cartItems()->pluck('product_id')->toArray();
        }

        return response()->json([
            'success' => true,
            'message' => 'تم جلب الفئة بنجاح',
            'data' => [
                'id' => $category->id,
                'name' => $category->name,
                'description' => $category->description,
                'image' => $category->image_url,
                'products' => $category->products->map(function ($product) use ($wishlistProductIds, $cartProductIds) {
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
                        'is_in_cart' => in_array($product->id, $cartProductIds),
                    ];
                }),
            ],
        ]);
    }
}
