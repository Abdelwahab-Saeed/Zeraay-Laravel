<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the coupons.
     */
    public function index()
    {
        $coupons = Coupon::latest()->paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new coupon.
     */
    public function create()
    {
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created coupon in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date|after:today',
            'status' => 'boolean',
            'description' => 'nullable|string',
        ], [
            'code.required' => 'يرجى إدخال كود الخصم',
            'code.unique' => 'هذا الكود مستخدم بالفعل، يرجى اختيار كود آخر',
            'type.required' => 'يرجى تحديد نوع الخصم',
            'type.in' => 'نوع الخصم غير صالح',
            'value.required' => 'يرجى إدخال قيمة الخصم',
            'value.numeric' => 'قيمة الخصم يجب أن تكون رقماً',
            'value.min' => 'قيمة الخصم لا يمكن أن تكون أقل من 0',
            'min_purchase.numeric' => 'الحد الأدنى للشراء يجب أن يكون رقماً',
            'min_purchase.min' => 'الحد الأدنى للشراء لا يمكن أن يكون أقل من 0',
            'expires_at.date' => 'تاريخ الانتهاء غير صالح',
            'expires_at.after' => 'تاريخ الانتهاء يجب أن يكون في المستقبل',
        ]);

        Coupon::create($request->all());

        return redirect()->route('admin.coupons.index')
            ->with('success', 'تم إنشاء الكوبون بنجاح');
    }

    /**
     * Display the specified coupon.
     */
    public function show(Coupon $coupon)
    {
        return view('admin.coupons.show', compact('coupon'));
    }

    /**
     * Show the form for editing the specified coupon.
     */
    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified coupon in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'expires_at' => 'nullable|date',
            'status' => 'boolean',
            'description' => 'nullable|string',
        ], [
            'code.required' => 'يرجى إدخال كود الخصم',
            'code.unique' => 'هذا الكود مستخدم بالفعل، يرجى اختيار كود آخر',
            'type.required' => 'يرجى تحديد نوع الخصم',
            'type.in' => 'نوع الخصم غير صالح',
            'value.required' => 'يرجى إدخال قيمة الخصم',
            'value.numeric' => 'قيمة الخصم يجب أن تكون رقماً',
            'value.min' => 'قيمة الخصم لا يمكن أن تكون أقل من 0',
            'min_purchase.numeric' => 'الحد الأدنى للشراء يجب أن يكون رقماً',
            'min_purchase.min' => 'الحد الأدنى للشراء لا يمكن أن يكون أقل من 0',
            'expires_at.date' => 'تاريخ الانتهاء غير صالح',
        ]);

        $coupon->update($request->all());

        return redirect()->route('admin.coupons.index')
            ->with('success', 'تم تحديث الكوبون بنجاح');
    }

    /**
     * Remove the specified coupon from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('admin.coupons.index')
            ->with('success', 'تم حذف الكوبون بنجاح');
    }
}
