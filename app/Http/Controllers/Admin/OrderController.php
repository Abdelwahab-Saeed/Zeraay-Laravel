<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use App\Notifications\OrderStatusChanged;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'coupon'])->withCount('items');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            })->orWhere('phone', 'like', '%' . $request->search . '%');
        }

        $orders = $query->latest()->paginate(15);
        
        // Statistics
        $statistics = [
            'all' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'total_revenue' => Order::where('status', 'delivered')->sum('final_amount'),
        ];
        
        return view('admin.orders.index', compact('orders', 'statistics'));
    }

    /**
     * Display order details.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'coupon']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status.
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        try {
            if($order->user->fcm_token) {

                switch ($request->status) {
                    case 'processing':
                        $order->user->notify(new OrderStatusChanged('جاري العمل على طلبك',  'جاري العمل على طلبك وسيتم التواصل معك في اسرع وقت من قبل فريق الدعم.'));
                        Notification::create([
                            'title' => 'جاري العمل على طلبك',
                        'body' => 'جاري العمل على طلبك وسيتم التواصل معك في اسرع وقت من قبل فريق الدعم.',
                            'user_id' => $order->user_id,
                        ]);
                        break;
                    case 'shipped':
                        $order->user->notify(new OrderStatusChanged('تم شحن طلبك بنجاح', 'لقد قمنا بشحن طلبك بنجاح سوف يصلك طلبك قريباً.'));
                        Notification::create([
                            'title' => 'تم شحن طلبك بنجاح',
                            'body' => 'لقد قمنا بشحن طلبك بنجاح سوف يصلك طلبك قريباً.',
                            'user_id' => $order->user_id,
                        ]);
                        break;
                    case 'delivered':
                        $order->user->notify(new OrderStatusChanged('تم تسليم طلبك بنجاح', 'لقد قمنا بتسليم طلبك بنجاح شكراً لك!'));
                        Notification::create([
                            'title' => 'تم تسليم طلبك بنجاح',
                            'body' => 'لقد قمنا بتسليم طلبك بنجاح شكراً لك!',
                            'user_id' => $order->user_id,
                        ]);
                        break;
                    case 'cancelled':
                        $order->user->notify(new OrderStatusChanged('تم إلغاء طلبك', 'لقد قمنا بإلغاء طلبك بنجاح شكراً لك!'));
                        Notification::create([
                            'title' => 'تم إلغاء طلبك',
                            'body' => 'لقد قمنا بإلغاء طلبك بنجاح شكراً لك!',
                            'user_id' => $order->user_id,
                        ]);
                        break;
                    }
                    
                }
            
        } catch (\Exception $e) {
            Log::error('Error updating order status: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'تم تحديث حالة الطلب بنجاح');
    }
}
