<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of active addresses.
     */
    public function index()
    {
        $addresses = Address::where('status', true)->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'تم جلب العناوين بنجاح',
            'data' => $addresses->map(function ($address) {
                return [
                    'id' => $address->id,
                    'title' => $address->title,
                    'address' => $address->address,
                    'city' => $address->city,
                ];
            }),
        ]);
    }
}
