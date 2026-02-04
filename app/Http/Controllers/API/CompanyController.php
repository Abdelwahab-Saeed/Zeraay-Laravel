<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of companies.
     */
    public function index()
    {
        $companies = Company::withCount('products')
            ->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'تم جلب الشركات بنجاح',
            'data' => $companies->map(function ($company) {
                return [
                    'id' => $company->id,
                    'name' => $company->name,
                    'description' => $company->description,
                    'logo' => $company->logo_url,
                    'products_count' => $company->products_count,
                ];
            }),
            'pagination' => [
                'current_page' => $companies->currentPage(),
                'last_page' => $companies->lastPage(),
                'per_page' => $companies->perPage(),
                'total' => $companies->total(),
            ],
        ]);
    }

    /**
     * Display the specified company with its products.
     */
    public function show($id)
    {
        $company = Company::with(['products' => function ($query) {
                $query->active()->inStock();
            }])
            ->find($id);

        if (! $company) {
            return response()->json([
                'success' => false,
                'message' => 'الشركة غير موجودة',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم جلب بيانات الشركة بنجاح',
            'data' => [
                'id' => $company->id,
                'name' => $company->name,
                'description' => $company->description,
                'logo' => $company->logo_url,
                'products' => $company->products->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'image' => $product->image_url,
                        'price' => $product->price,
                        'discount_price' => $product->discount_price,
                        'final_price' => $product->final_price,
                        'stock' => $product->stock,
                    ];
                }),
            ],
        ]);
    }
}
