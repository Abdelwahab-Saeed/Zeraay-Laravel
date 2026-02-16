<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommonQuestionRequest;
use App\Http\Requests\UpdateCommonQuestionRequest;
use App\Models\CommonQuestion;
use Illuminate\Http\Request;

class CommonQuestionController extends Controller
{
    /**
     * Display a listing of the common questions.
     */
    public function index()
    {
        $commonQuestions = CommonQuestion::latest()->paginate(10);
        return view('admin.common_questions.index', compact('commonQuestions'));
    }

    /**
     * Show the form for creating a new common question.
     */
    public function create()
    {
        return view('admin.common_questions.create');
    }

    /**
     * Store a newly created common question in storage.
     */
    public function store(StoreCommonQuestionRequest $request)
    {
        CommonQuestion::create($request->validated());

        return redirect()->route('admin.common_questions.index')
            ->with('success', 'تم إضافة السؤال الشائع بنجاح');
    }

    /**
     * Display the specified common question.
     */
    public function show(CommonQuestion $commonQuestion)
    {
        return view('admin.common_questions.show', compact('commonQuestion'));
    }

    /**
     * Show the form for editing the specified common question.
     */
    public function edit(CommonQuestion $commonQuestion)
    {
        return view('admin.common_questions.edit', compact('commonQuestion'));
    }

    /**
     * Update the specified common question in storage.
     */
    public function update(UpdateCommonQuestionRequest $request, CommonQuestion $commonQuestion)
    {
        $commonQuestion->update($request->validated());

        return redirect()->route('admin.common_questions.index')
            ->with('success', 'تم تحديث السؤال الشائع بنجاح');
    }

    /**
     * Remove the specified common question from storage.
     */
    public function destroy(CommonQuestion $commonQuestion)
    {
        $commonQuestion->delete();

        return redirect()->route('admin.common_questions.index')
            ->with('success', 'تم حذف السؤال الشائع بنجاح');
    }
}
