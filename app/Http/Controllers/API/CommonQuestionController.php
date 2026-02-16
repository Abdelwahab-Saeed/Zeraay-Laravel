<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CommonQuestion;
use Illuminate\Http\Request;

class CommonQuestionController extends Controller
{
    /**
     * Display a listing of active common questions.
     */
    public function index()
    {
        $commonQuestions = CommonQuestion::where('status', true)->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'تم جلب الأسئلة الشائعة بنجاح',
            'data' => $commonQuestions->map(function ($question) {
                return [
                    'id' => $question->id,
                    'question' => $question->question,
                    'answer' => $question->answer,
                ];
            }),
        ]);
    }
}
