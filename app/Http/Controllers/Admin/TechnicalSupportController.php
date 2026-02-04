<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTechnicalSupportRequest;
use App\Http\Requests\UpdateTechnicalSupportRequest;
use App\Models\TechnicalSupport;
use Illuminate\Http\Request;

class TechnicalSupportController extends Controller
{
    /**
     * Display a listing of the technical support staff.
     */
    public function index()
    {
        $technicalSupports = TechnicalSupport::latest()->paginate(10);
        return view('admin.technical_supports.index', compact('technicalSupports'));
    }

    /**
     * Show the form for creating a new technical support entry.
     */
    public function create()
    {
        return view('admin.technical_supports.create');
    }

    /**
     * Store a newly created technical support entry in storage.
     */
    public function store(StoreTechnicalSupportRequest $request)
    {
        TechnicalSupport::create($request->validated());

        return redirect()->route('admin.technical_supports.index')
            ->with('success', 'تم إضافة مسؤول الدعم الفني بنجاح');
    }

    /**
     * Show the form for editing the specified technical support entry.
     */
    public function edit(TechnicalSupport $technicalSupport)
    {
        return view('admin.technical_supports.edit', compact('technicalSupport'));
    }

    /**
     * Update the specified technical support entry in storage.
     */
    public function update(UpdateTechnicalSupportRequest $request, TechnicalSupport $technicalSupport)
    {
        $technicalSupport->update($request->validated());

        return redirect()->route('admin.technical_supports.index')
            ->with('success', 'تم تحديث بيانات مسؤول الدعم الفني بنجاح');
    }

    /**
     * Remove the specified technical support entry from storage.
     */
    public function destroy(TechnicalSupport $technicalSupport)
    {
        $technicalSupport->delete();

        return redirect()->route('admin.technical_supports.index')
            ->with('success', 'تم حذف مسؤول الدعم الفني بنجاح');
    }
}
