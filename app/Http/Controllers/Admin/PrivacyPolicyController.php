<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePrivacyPolicyRequest;
use App\Http\Requests\UpdatePrivacyPolicyRequest;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    /**
     * Display a listing of the privacy policy sections.
     */
    public function index()
    {
        $privacyPolicies = PrivacyPolicy::latest()->paginate(10);
        return view('admin.privacy_policies.index', compact('privacyPolicies'));
    }

    /**
     * Show the form for creating a new privacy policy section.
     */
    public function create()
    {
        return view('admin.privacy_policies.create');
    }

    /**
     * Store a newly created privacy policy section in storage.
     */
    public function store(StorePrivacyPolicyRequest $request)
    {
        PrivacyPolicy::create($request->validated());

        return redirect()->route('admin.privacy_policies.index')
            ->with('success', 'تم إضافة سياسة الخصوصية بنجاح');
    }

    /**
     * Display the specified privacy policy section.
     */
    public function show(PrivacyPolicy $privacyPolicy)
    {
        return view('admin.privacy_policies.show', compact('privacyPolicy'));
    }

    /**
     * Show the form for editing the specified privacy policy section.
     */
    public function edit(PrivacyPolicy $privacyPolicy)
    {
        return view('admin.privacy_policies.edit', compact('privacyPolicy'));
    }

    /**
     * Update the specified privacy policy section in storage.
     */
    public function update(UpdatePrivacyPolicyRequest $request, PrivacyPolicy $privacyPolicy)
    {
        $privacyPolicy->update($request->validated());

        return redirect()->route('admin.privacy_policies.index')
            ->with('success', 'تم تحديث سياسة الخصوصية بنجاح');
    }

    /**
     * Remove the specified privacy policy section from storage.
     */
    public function destroy(PrivacyPolicy $privacyPolicy)
    {
        $privacyPolicy->delete();

        return redirect()->route('admin.privacy_policies.index')
            ->with('success', 'تم حذف سياسة الخصوصية بنجاح');
    }
}
