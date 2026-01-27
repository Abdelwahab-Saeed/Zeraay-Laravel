<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToWishlistRequest;
use App\Models\WishlistItem;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Get user's wishlist.
     */
    public function index()
    {
        $wishlistItems = auth()->user()->wishlistItems()
            ->with(['product' => function ($query) {
                $query->active();
            }])
            ->withActiveProducts()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'تم جلب قائمة الأمنيات بنجاح',
            'data' => $wishlistItems->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product' => [
                        'id' => $item->product->id,
                        'name' => $item->product->name,
                        'description' => $item->product->description,
                        'image' => $item->product->image_url,
                        'price' => $item->product->price,
                        'discount_price' => $item->product->discount_price,
                        'final_price' => $item->product->final_price,
                        'stock' => $item->product->stock,
                        'in_stock' => $item->product->stock > 0,
                    ],
                    'added_at' => $item->created_at->format('Y-m-d H:i:s'),
                ];
            }),
            'pagination' => [
                'current_page' => $wishlistItems->currentPage(),
                'last_page' => $wishlistItems->lastPage(),
                'per_page' => $wishlistItems->perPage(),
                'total' => $wishlistItems->total(),
            ],
        ]);
    }

    /**
     * Add product to wishlist.
     */
    public function store(AddToWishlistRequest $request)
    {
        $userId = auth()->id();
        $productId = $request->product_id;

        // Check if item already exists in wishlist
        $existingItem = WishlistItem::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existingItem) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج موجود بالفعل في قائمة الأمنيات',
                'data' => null,
            ], 400);
        }

        // Create new wishlist item
        $wishlistItem = WishlistItem::create([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);

        $wishlistItem->load('product');

        return response()->json([
            'success' => true,
            'message' => 'تمت الإضافة إلى قائمة الأمنيات بنجاح',
            'data' => [
                'wishlist_item' => [
                    'id' => $wishlistItem->id,
                    'product' => [
                        'id' => $wishlistItem->product->id,
                        'name' => $wishlistItem->product->name,
                        'image' => $wishlistItem->product->image_url,
                        'price' => $wishlistItem->product->price,
                        'final_price' => $wishlistItem->product->final_price,
                    ],
                ],
            ],
        ], 201);
    }

    /**
     * Remove item from wishlist.
     */
    public function destroy(WishlistItem $wishlistItem)
    {
        // Check authorization
        if ($wishlistItem->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح لك بحذف هذا العنصر',
                'data' => null,
            ], 403);
        }

        $wishlistItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف العنصر من قائمة الأمنيات بنجاح',
            'data' => null,
        ]);
    }

    /**
     * Move item from wishlist to cart.
     */
    public function moveToCart(WishlistItem $wishlistItem)
    {
        // Check authorization
        if ($wishlistItem->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح لك بنقل هذا العنصر',
                'data' => null,
            ], 403);
        }

        $product = Product::find($wishlistItem->product_id);

        // Check product availability
        if (!$product || !$product->status) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير متوفر',
                'data' => null,
            ], 400);
        }

        // Check stock
        if ($product->stock <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'المنتج غير متوفر في المخزون',
                'data' => null,
            ], 400);
        }

        // Check if already in cart
        $existingCartItem = CartItem::where('user_id', auth()->id())
            ->where('product_id', $wishlistItem->product_id)
            ->first();

        if ($existingCartItem) {
            // Update quantity
            $newQuantity = $existingCartItem->quantity + 1;
            
            if ($newQuantity > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'لا يمكن إضافة المزيد، الكمية في السلة تساوي المتوفر في المخزون',
                    'data' => null,
                ], 400);
            }

            $existingCartItem->update(['quantity' => $newQuantity]);
        } else {
            // Add to cart
            CartItem::create([
                'user_id' => auth()->id(),
                'product_id' => $wishlistItem->product_id,
                'quantity' => 1,
            ]);
        }

        // Remove from wishlist
        $wishlistItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم نقل المنتج إلى السلة بنجاح',
            'data' => null,
        ]);
    }
}
