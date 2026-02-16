@extends('admin.layouts.app')

@section('title', 'عرض السؤال الشائع')

@section('content')
<div class="max-w-4xl mx-auto animate-fade-in">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.common_questions.index') }}" class="text-slate-500 hover:text-primary-start transition-colors mb-4 inline-flex items-center text-sm font-medium">
                <i class="fas fa-arrow-right ml-2 text-xs"></i> العودة للأسئلة
            </a>
            <h2 class="text-3xl font-bold text-slate-800">تفاصيل السؤال الشائع</h2>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.common_questions.edit', $commonQuestion) }}" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl shadow-lg shadow-amber-500/20 transition-all-300 flex items-center">
                <i class="fas fa-edit ml-2"></i> تعديل
            </a>
            <form action="{{ route('admin.common_questions.destroy', $commonQuestion) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-2.5 bg-rose-500 hover:bg-rose-600 text-white font-bold rounded-xl shadow-lg shadow-rose-500/20 transition-all-300 flex items-center" 
                        data-confirm data-confirm-title="حذف السؤال الشائع" 
                        data-confirm-message="هل أنت متأكد من رغبتك في حذف هذا السؤال؟">
                    <i class="fas fa-trash ml-2"></i> حذف
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
        <div class="space-y-8">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">السؤال</p>
                <h3 class="text-2xl font-bold text-slate-800 leading-tight">{{ $commonQuestion->question }}</h3>
            </div>

            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">الإجابة</p>
                <div class="text-slate-600 text-lg leading-relaxed whitespace-pre-line bg-slate-50 rounded-2xl p-6 border border-slate-100">
                    {{ $commonQuestion->answer }}
                </div>
            </div>

            <div class="flex flex-wrap gap-8 pt-6 border-t border-slate-50">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">الحالة</p>
                    @if($commonQuestion->status)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 ml-1.5"></span>
                            نشط
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-600">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500 ml-1.5"></span>
                            غير نشط
                        </span>
                    @endif
                </div>

                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">تاريخ الإضافة</p>
                    <p class="text-slate-700 font-medium">{{ $commonQuestion->created_at->format('Y-m-d H:i') }}</p>
                </div>

                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">آخر تحديث</p>
                    <p class="text-slate-700 font-medium">{{ $commonQuestion->updated_at->format('Y-m-d H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
