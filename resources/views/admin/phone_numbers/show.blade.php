@extends('admin.layouts.app')

@section('title', 'عرض رقم الهاتف')

@section('content')
<div class="max-w-2xl mx-auto animate-fade-in">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.phone_numbers.index') }}" class="text-slate-500 hover:text-primary-start transition-colors mb-4 inline-flex items-center text-sm font-medium">
                <i class="fas fa-arrow-right ml-2 text-xs"></i> العودة للأرقام
            </a>
            <h2 class="text-3xl font-bold text-slate-800">تفاصيل الرقم</h2>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.phone_numbers.edit', $phoneNumber) }}" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl shadow-lg shadow-amber-500/20 transition-all-300 flex items-center">
                <i class="fas fa-edit ml-2"></i> تعديل
            </a>
            <form action="{{ route('admin.phone_numbers.destroy', $phoneNumber) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-2.5 bg-rose-500 hover:bg-rose-600 text-white font-bold rounded-xl shadow-lg shadow-rose-500/20 transition-all-300 flex items-center" 
                        data-confirm data-confirm-title="حذف رقم الهاتف" 
                        data-confirm-message="هل أنت متأكد من رغبتك في حذف هذا الرقم؟">
                    <i class="fas fa-trash ml-2"></i> حذف
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
        <h3 class="text-lg font-bold text-slate-800 mb-6 pb-4 border-b border-slate-50">معلومات رقم الهاتف</h3>
        
        <div class="space-y-6">
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">رقم الهاتف</p>
                <p class="text-primary-start font-bold text-2xl dir-ltr text-right">{{ $phoneNumber->phone_number }}</p>
            </div>

            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">الحالة</p>
                @if($phoneNumber->status)
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

            <div class="pt-4 border-t border-slate-50">
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">أضيف في</p>
                <p class="text-slate-500 text-xs font-medium">{{ $phoneNumber->created_at->format('Y-m-d H:i') }}</p>
            </div>
        </div>
        
        <div class="mt-8 flex justify-center">
            <a href="tel:{{ $phoneNumber->phone_number }}" class="inline-flex items-center px-8 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-2xl shadow-lg shadow-emerald-500/20 transition-all-300">
                <i class="fas fa-phone-alt ml-2"></i> اتصال الآن
            </a>
        </div>
    </div>
</div>
@endsection
