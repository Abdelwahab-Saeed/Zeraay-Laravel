<?php

namespace App\Http\Controllers;

use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    /**
     * Display the privacy policy page.
     */
    public function index()
    {
        $privacyPolicies = PrivacyPolicy::where('status', true)->orderBy('created_at', 'asc')->get();
        return view('privacy-policy', compact('privacyPolicies'));
    }
}
