<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of active banners.
     */
    public function index(Request $request)
    {
        $banners = Banner::where('status', true)
            ->latest()
            ->paginate($request->input('per_page', 10));

        $banners->through(function ($banner) {
            return [
                'id' => $banner->id,
                'title' => $banner->title,
                'description' => $banner->description,
                'image' => $banner->image_url,
                'created_at' => $banner->created_at->format('Y-m-d H:i'),
            ];
        });

        return response()->json([
            'success' => true,
            'message' => 'تم جلب البانرات بنجاح',
            'data' => $banners->items(),
            'pagination' => [
                'current_page' => $banners->currentPage(),
                'last_page' => $banners->lastPage(),
                'per_page' => $banners->perPage(),
                'total' => $banners->total(),
            ],
        ]);
    }

    /**
     * Display the specified banner.
     */
    public function show($id)
    {
        $banner = Banner::where('status', true)->find($id);

        if (!$banner) {
            return response()->json([
                'success' => false,
                'message' => 'البانر غير موجود',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'تم جلب البانر بنجاح',
            'data' => [
                'id' => $banner->id,
                'title' => $banner->title,
                'description' => $banner->description,
                'image' => $banner->image_url,
                'created_at' => $banner->created_at->format('Y-m-d H:i'),
            ],
        ]);
    }
}
