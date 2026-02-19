<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use App\Models\Product;
use App\Notifications\NewOrderPlaced;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Get user's order history.
     */
    public function index()
    {
        $orders = auth()->user()->orders()
            ->withCount('items')
            ->latest()
            ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'تم جلب طلباتك بنجاح',
            'data' => $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'name' => $order->name,
                    'total_amount' => $order->total_amount,
                    'discount_amount' => $order->discount_amount,
                    'final_amount' => $order->final_amount,
                    'status' => $order->status,
                    'items_count' => $order->items_count,
                    'created_at' => $order->created_at->format('Y-m-d H:i'),
                ];
            }),
            'pagination' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'per_page' => $orders->perPage(),
                'total' => $orders->total(),
            ],
        ]);
    }

    /**
     * Get order details.
     */
    public function show(Order $order)
    {
        // Check authorization
        if ($order->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'غير مصرح لك بعرض هذا الطلب',
            ], 403);
        }

        $order->load(['items.product', 'coupon']);

        return response()->json([
            'success' => true,
            'message' => 'تم جلب تفاصيل الطلب بنجاح',
            'data' => $order
        ]);
    }

    /**
     * Create a new order (Checkout).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'address' => 'required|string',
            'state' => 'required|string',
            'payment_method_id' => 'required|exists:payment_methods,id,status,1',
            'notes' => 'nullable|string',
            'coupon_code' => 'nullable|string',
        ]);

        $user = auth()->user();
        $cartItems = $user->cartItems()->withActiveProducts()->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'السلة فارغة، لا يمكنك إتمام الطلب',
            ], 422);
        }

        $totalAmount = $cartItems->sum('subtotal');
        $discountAmount = 0;
        $couponId = null;

        // Apply coupon if provided
        if ($request->coupon_code) {
            $couponCode = strtoupper(trim($request->coupon_code));
            $coupon = Coupon::where('code', $couponCode)->first();

            if ($coupon && $coupon->isValid() && !$coupon->isUsedByUser($user->id) && $coupon->isValidForTotal($totalAmount)) {
                $discountAmount = $coupon->calculateDiscount($totalAmount);
                $couponId = $coupon->id;
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'كود الخصم غير صالح أو لا يستوفي الشروط',
                ], 422);
            }
        }

        $finalAmount = $totalAmount - $discountAmount;

        return DB::transaction(function () use ($user, $cartItems, $totalAmount, $discountAmount, $finalAmount, $couponId, $request) {
            // 1. Create order
            $order = Order::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'coupon_id' => $couponId,
                'payment_method_id' => $request->payment_method_id,
                'total_amount' => $totalAmount,
                'discount_amount' => $discountAmount,
                'final_amount' => $finalAmount,
                'phone' => $request->phone,
                'address' => $request->address,
                'state' => $request->state,
                'notes' => $request->notes,
                'status' => 'pending',
            ]);

            // 2. Create order items and decrease stock
            foreach ($cartItems as $cartItem) {
                // Double check stock
                $product = $cartItem->product;
                if ($product->stock < $cartItem->quantity) {
                    throw new \Exception("عذراً، المنتج {$product->name} لم يعد متوفراً بالكمية المطلوبة");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $cartItem->quantity,
                    'price' => $product->final_price,
                ]);

                $product->decrement('stock', $cartItem->quantity);
            }

            // 3. Mark coupon as used if applied
            if ($couponId) {
                $user->usedCoupons()->attach($couponId, ['used_at' => now()]);
            }

            // 4. Clear cart
            $user->cartItems()->delete();

            //5. Send notification
            if($user->fcm_token) {
                $user->notify(new NewOrderPlaced('تم تأكيد طلبك بنجاح', 'لقد استلمنا طلبك بنجاح وسيتم التواصل معك في اسرع وقت من قبل فريق الدعم.'));

                Notification::create([
                'title' => 'تم تأكيد طلبك بنجاح',
                'body' => 'لقد استلمنا طلبك بنجاح وسيتم التواصل معك في اسرع وقت من قبل فريق الدعم.',
                'is_custom' => false,
                'user_id' => $user->id,
            ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'تم تسجيل طلبك بنجاح',
                'data' => [
                    'order_id' => $order->id,
                    'final_amount' => $finalAmount
                ]
            ], 201);
        });
    }
}
