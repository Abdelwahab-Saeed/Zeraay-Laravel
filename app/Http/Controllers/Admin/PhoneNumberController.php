<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePhoneNumberRequest;
use App\Http\Requests\UpdatePhoneNumberRequest;
use App\Models\PhoneNumber;
use Illuminate\Http\Request;

class PhoneNumberController extends Controller
{
    /**
     * Display a listing of the phone numbers.
     */
    public function index()
    {
        $phoneNumbers = PhoneNumber::latest()->paginate(10);
        return view('admin.phone_numbers.index', compact('phoneNumbers'));
    }

    /**
     * Show the form for creating a new phone number.
     */
    public function create()
    {
        return view('admin.phone_numbers.create');
    }

    /**
     * Store a newly created phone number in storage.
     */
    public function store(StorePhoneNumberRequest $request)
    {
        PhoneNumber::create($request->validated());

        return redirect()->route('admin.phone_numbers.index')
            ->with('success', 'تم إضافة رقم الهاتف بنجاح');
    }

    /**
     * Display the specified phone number.
     */
    public function show(PhoneNumber $phoneNumber)
    {
        return view('admin.phone_numbers.show', compact('phoneNumber'));
    }

    /**
     * Show the form for editing the specified phone number.
     */
    public function edit(PhoneNumber $phoneNumber)
    {
        return view('admin.phone_numbers.edit', compact('phoneNumber'));
    }

    /**
     * Update the specified phone number in storage.
     */
    public function update(UpdatePhoneNumberRequest $request, PhoneNumber $phoneNumber)
    {
        $phoneNumber->update($request->validated());

        return redirect()->route('admin.phone_numbers.index')
            ->with('success', 'تم تحديث رقم الهاتف بنجاح');
    }

    /**
     * Remove the specified phone number from storage.
     */
    public function destroy(PhoneNumber $phoneNumber)
    {
        $phoneNumber->delete();

        return redirect()->route('admin.phone_numbers.index')
            ->with('success', 'تم حذف رقم الهاتف بنجاح');
    }
}
