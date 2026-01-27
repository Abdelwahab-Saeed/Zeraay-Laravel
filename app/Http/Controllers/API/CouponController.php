<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Apply a coupon code to the current cart.
     */
    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $user = auth()->user();
        $code = strtoupper(trim($request->code));
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'كود الخصم غير صحيح',
            ], 422);
        }

        if (!$coupon->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'هذا الكوبون منتهي الصلاحية أو غير نشط',
            ], 422);
        }

        if ($coupon->isUsedByUser($user->id)) {
            return response()->json([
                'success' => false,
                'message' => 'لقد قمت باستخدام هذا الكوبون من قبل',
            ], 422);
        }

        $cartItems = $user->cartItems()->withActiveProducts()->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'السلة فارغة',
            ], 422);
        }

        $total = $cartItems->sum('subtotal');

        if (!$coupon->isValidForTotal($total)) {
            return response()->json([
                'success' => false,
                'message' => 'يجب أن يكون إجمالي السلة على الأقل ' . $coupon->min_purchase . ' للاستفادة من هذا الخصم',
            ], 422);
        }

        $discount = $coupon->calculateDiscount($total);
        $newTotal = $total - $discount;

        return response()->json([
            'success' => true,
            'message' => 'تم تطبيق الكوبون بنجاح',
            'data' => [
                'coupon_code' => $coupon->code,
                'discount_type' => $coupon->type,
                'discount_value' => $coupon->value,
                'discount_amount' => $discount,
                'original_total' => $total,
                'new_total' => $newTotal,
            ],
        ]);
    }
}
