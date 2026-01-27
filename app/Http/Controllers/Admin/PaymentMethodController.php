<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paymentMethods = PaymentMethod::all();
        return view('admin.payment_methods.index', compact('paymentMethods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.payment_methods.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'boolean',
        ], [
            'name.required' => 'يرجى إدخال اسم وسيلة الدفع',
            'name.string' => 'اسم وسيلة الدفع يجب أن يكون نصاً',
            'name.max' => 'اسم وسيلة الدفع طويل جداً',
        ]);

        PaymentMethod::create($request->all());

        return redirect()->route('admin.payment_methods.index')
            ->with('success', 'تمت إضافة وسيلة الدفع بنجاح');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        return view('admin.payment_methods.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'boolean',
        ], [
            'name.required' => 'يرجى إدخال اسم وسيلة الدفع',
            'name.string' => 'اسم وسيلة الدفع يجب أن يكون نصاً',
            'name.max' => 'اسم وسيلة الدفع طويل جداً',
        ]);

        $paymentMethod->update($request->all());

        return redirect()->route('admin.payment_methods.index')
            ->with('success', 'تم تحديث وسيلة الدفع بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        if ($paymentMethod->orders()->exists()) {
            return redirect()->back()->with('error', 'لا يمكن حذف وسيلة الدفع لوجود طلبات مرتبطة بها، يمكنك تعطيلها بدلاً من ذلك');
        }

        $paymentMethod->delete();

        return redirect()->route('admin.payment_methods.index')
            ->with('success', 'تم حذف وسيلة الدفع بنجاح');
    }
}
