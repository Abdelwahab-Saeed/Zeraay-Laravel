@extends('admin.layouts.app')

@section('title', 'عرض سياسة الخصوصية')

@section('content')
<div class="max-w-3xl mx-auto animate-fade-in">
    <div class="mb-8">
        <a href="{{ route('admin.privacy_policies.index') }}" class="text-slate-500 hover:text-primary-start transition-colors mb-4 inline-flex items-center text-sm font-medium">
            <i class="fas fa-arrow-right ml-2 text-xs"></i> العودة للسياسات
        </a>
        <h2 class="text-3xl font-bold text-slate-800">تفاصيل قسم سياسة الخصوصية</h2>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="text-xl font-bold text-slate-800">{{ $privacyPolicy->title }}</h3>
                    <div class="mt-2">
                        @if($privacyPolicy->status)
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
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.privacy_policies.edit', $privacyPolicy) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-bold rounded-xl transition-all-300">
                        <i class="fas fa-edit ml-1"></i> تعديل
                    </a>
                </div>
            </div>

            <div class="prose prose-slate max-w-none">
                <div class="bg-slate-50 rounded-2xl p-6 text-slate-700 whitespace-pre-wrap leading-relaxed">
                    {{ $privacyPolicy->content }}
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-slate-100 text-slate-400 text-sm flex justify-between">
                <span>تاريخ الإضافة: {{ $privacyPolicy->created_at->format('Y-m-d H:i') }}</span>
                <span>آخر تحديث: {{ $privacyPolicy->updated_at->format('Y-m-d H:i') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
