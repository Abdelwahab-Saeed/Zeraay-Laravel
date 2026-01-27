<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Get active payment methods.
     */
    public function index()
    {
        $methods = PaymentMethod::where('status', true)->get();

        return response()->json([
            'success' => true,
            'message' => 'تم جلب وسائل الدفع بنجاح',
            'data' => $methods
        ]);
    }
}
