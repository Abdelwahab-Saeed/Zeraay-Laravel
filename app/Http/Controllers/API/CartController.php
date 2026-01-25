<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Get user's cart with all items.
     */
    public function index()
    {
        $cartItems = auth()->user()->cartItems()
            ->with(['product' => function ($query) {
                $query->active();
            }])
            ->withActiveProducts()
            ->get();

        $total = $cartItems->sum('subtotal');

        return response()->json([
            'success' => true,
            'message' => 'تم جلب السلة بنجاح',
            'data' => [
                'cart_items' => $cartItems->map(function ($item) {
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
                        ],
                        'quantity' => $item->quantity,
                        'subtotal' => $item->subtotal,
                    ];
                }),
                'total' => $total,
            ],
        ]);
    }

    /**
     * Add product to cart.
     */
    public function store(AddToCartRequest $request)
    {
        $userId = auth()->id();
        $productId = $request->product_id;
        $quantity = $request->quantity;

        // Check if item already exists in cart
        $existingItem = CartItem::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existingItem) {
            // Update quantity
            $newQuantity = $existingItem->quantity + $quantity;
            $product = Product::find($productId);

            if ($newQuantity > $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'الكمية الإجمالية تتجاوز المتوفر في المخزون',
                    'data' => null,
                ], 400);
            }

            $existingItem->update(['quantity' => $newQuantity]);
            $cartItem = $existingItem;
        } else {
            // Create new cart item
            $cartItem = CartItem::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        $cartItem->load('product');

        return response()->json([
            'success' => true,
            'message' => 'تمت الإضافة إلى السلة بنجاح',
            'data' => [
                'cart_item' => [
                    'id' => $cartItem->id,
                    'product' => [
                        'id' => $cartItem->product->id,
                        'name' => $cartItem->product->name,
                        'image' => $cartItem->product->image_url,
                        'price' => $cartItem->product->price,
                        'final_price' => $cartItem->product->final_price,
                    ],
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $cartItem->subtotal,
                ],
            ],
        ], 201);
    }

    /**
     * Update cart item quantity.
     */
    public function update(UpdateCartItemRequest $request, CartItem $cartItem)
    {
        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        $cartItem->load('product');

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الكمية بنجاح',
            'data' => [
                'cart_item' => [
                    'id' => $cartItem->id,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $cartItem->subtotal,
                ],
            ],
        ]);
    }

    /**
     * Remove item from cart.
     */
    public function destroy(CartItem $cartItem)
    {
        // Check authorization
        if ($cartItem->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح لك بحذف هذا العنصر',
                'data' => null,
            ], 403);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف العنصر من السلة بنجاح',
            'data' => null,
        ]);
    }

    /**
     * Clear entire cart.
     */
    public function clear()
    {
        auth()->user()->cartItems()->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم تفريغ السلة بنجاح',
            'data' => null,
        ]);
    }
}
