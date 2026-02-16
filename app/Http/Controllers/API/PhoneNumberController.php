<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PhoneNumber;
use Illuminate\Http\Request;

class PhoneNumberController extends Controller
{
    /**
     * Display a listing of active phone numbers.
     */
    public function index()
    {
        $phoneNumbers = PhoneNumber::where('status', true)->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'تم جلب أرقام الهاتف بنجاح',
            'data' => $phoneNumbers->map(function ($phoneNumber) {
                return [
                    'id' => $phoneNumber->id,
                    'phone_number' => $phoneNumber->phone_number,
                ];
            }),
        ]);
    }
}
