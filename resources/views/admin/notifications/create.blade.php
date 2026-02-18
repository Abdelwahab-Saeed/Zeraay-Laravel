@extends('admin.layouts.app')

@section('title', 'إرسال إشعار جديد')

@section('content')
<div class="max-w-3xl mx-auto animate-fade-in">
    <div class="mb-8">
        <a href="{{ route('admin.notifications.index') }}" class="text-slate-500 hover:text-primary-start transition-colors mb-4 inline-flex items-center text-sm font-medium">
            <i class="fas fa-arrow-right ml-2 text-xs"></i> العودة لقائمة الإشعارات
        </a>
        <h2 class="text-3xl font-bold text-slate-800">إرسال إشعار جديد</h2>
        <p class="text-slate-500 mt-1">سيتم إرسال هذا الإشعار إلى جميع مستخدمي التطبيق عبر FCM.</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <form action="{{ route('admin.notifications.store') }}" method="POST" novalidate class="p-8">
            @csrf

            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-bold text-slate-700 mb-2">عنوان الإشعار <span class="text-rose-500">*</span></label>
                    <input type="text" 
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none @error('title') border-rose-500 ring-rose-500/10 @enderror" 
                           id="title" name="title" value="{{ old('title') }}" placeholder="أدخل عنواناً جذاباً للتنبيه">
                    @error('title')
                        <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Body -->
                <div>
                    <label for="body" class="block text-sm font-bold text-slate-700 mb-2">محتوى الإشعار <span class="text-rose-500">*</span></label>
                    <textarea class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none @error('body') border-rose-500 ring-rose-500/10 @enderror" 
                              id="body" name="body" rows="4" placeholder="اكتب تفاصيل الإشعار هنا...">{{ old('body') }}</textarea>
                    @error('body')
                        <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                    <button type="submit" class="px-8 py-3 bg-primary-start hover:bg-primary-end text-white font-bold rounded-2xl shadow-lg hover:shadow-primary-start/30 transition-all-300 flex-1 flex justify-center items-center"
                            data-confirm data-confirm-title="إرسال الإشعار" 
                            data-confirm-message="هل أنت متأكد من رغبتك في إرسال هذا الإشعار لجميع المستخدمين؟"
                            data-confirm-btn="إرسال الآن" data-confirm-type="info">
                        <i class="fas fa-paper-plane ml-2"></i> إرسال الإشعار للجميع
                    </button>
                    <a href="{{ route('admin.notifications.index') }}" class="px-8 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-2xl transition-all-300 text-center">
                        إلغاء
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
