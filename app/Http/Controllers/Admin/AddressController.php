<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the addresses.
     */
    public function index()
    {
        $addresses = Address::latest()->paginate(10);
        return view('admin.addresses.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new address.
     */
    public function create()
    {
        return view('admin.addresses.create');
    }

    /**
     * Store a newly created address in storage.
     */
    public function store(StoreAddressRequest $request)
    {
        Address::create($request->validated());

        return redirect()->route('admin.addresses.index')
            ->with('success', 'تم إضافة العنوان بنجاح');
    }

    /**
     * Display the specified address.
     */
    public function show(Address $address)
    {
        return view('admin.addresses.show', compact('address'));
    }

    /**
     * Show the form for editing the specified address.
     */
    public function edit(Address $address)
    {
        return view('admin.addresses.edit', compact('address'));
    }

    /**
     * Update the specified address in storage.
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
        $address->update($request->validated());

        return redirect()->route('admin.addresses.index')
            ->with('success', 'تم تحديث العنوان بنجاح');
    }

    /**
     * Remove the specified address from storage.
     */
    public function destroy(Address $address)
    {
        $address->delete();

        return redirect()->route('admin.addresses.index')
            ->with('success', 'تم حذف العنوان بنجاح');
    }
}
