<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TechnicalSupport;
use Illuminate\Http\Request;

class TechnicalSupportController extends Controller
{
    /**
     * Display a listing of technical support staff.
     */
    public function index()
    {
        $technicalSupports = TechnicalSupport::all();

        return response()->json([
            'success' => true,
            'message' => 'تم جلب بيانات الدعم الفني بنجاح',
            'data' => $technicalSupports->map(function ($support) {
                return [
                    'id' => $support->id,
                    'name' => $support->name,
                    'phone' => $support->phone,
                ];
            }),
        ]);
    }
}
