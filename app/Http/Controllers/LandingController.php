<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsMail;

class LandingController extends Controller
{
    public function index()
    {
        $locale = session('locale', config('app.locale'));
        app()->setLocale($locale);
        return view('landing');
    }

    public function sendContactEmail(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        try {
            // Send email to the application contact address
            Mail::to(config('mail.contact_address'))
                ->send(new ContactUsMail($validated));

            return response()->json([
                'success' => true,
                'message' => app()->getLocale() == 'ar' ? 'تم إرسال رسالتك بنجاح!' : 'Your message has been sent successfully!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => app()->getLocale() == 'ar' ? 'حدث خطأ ما. يرجى المحاولة مرة أخرى.' : 'Something went wrong. Please try again.',
            ], 500);
        }
    }
}
