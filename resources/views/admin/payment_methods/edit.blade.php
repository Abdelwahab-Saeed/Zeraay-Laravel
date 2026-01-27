@extends('admin.layouts.app')

@section('title', 'تعديل وسيلة الدفع')

@section('content')
<div class="max-w-2xl mx-auto animate-fade-in">
    <div class="mb-8 font-bold">
        <a href="{{ route('admin.payment_methods.index') }}" class="text-slate-500 hover:text-primary-start transition-colors mb-4 inline-flex items-center text-sm">
            <i class="fas fa-arrow-right ml-2 text-xs"></i> العودة لوسائل الدفع
        </a>
        <h2 class="text-3xl font-bold text-slate-800">تعديل وسيلة الدفع: {{ $paymentMethod->name }}</h2>
    </div>

    <form action="{{ route('admin.payment_methods.update', $paymentMethod) }}" method="POST" novalidate>
        @csrf
        @method('PUT')
        <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 p-8 md:p-12 space-y-8">
            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 mb-3">اسم وسيلة الدفع <span class="text-rose-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $paymentMethod->name) }}" 
                       class="w-full px-4 py-4 rounded-2xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none text-sm" 
                      >
                @error('name') <p class="text-rose-500 text-xs mt-2 font-medium">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center">
                <label class="relative inline-flex items-center cursor-pointer group">
                    <input type="hidden" name="status" value="0">
                    <input type="checkbox" name="status" value="1" class="sr-only peer" {{ old('status', $paymentMethod->status) ? 'checked' : '' }}>
                    <div class="w-12 h-6 bg-slate-200 peer-focus:ring-4 peer-focus:ring-emerald-500/20 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:right-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                    <span class="mr-3 text-sm font-bold text-slate-700">وسيلة فعالة</span>
                </label>
            </div>

            <div class="pt-4 flex gap-4">
                <button type="submit" class="flex-1 px-12 py-4 bg-primary-start hover:bg-primary-end text-white font-bold rounded-2xl shadow-lg hover:shadow-primary-start/30 transition-all-300">
                    تحديث
                </button>
                <a href="{{ route('admin.payment_methods.index') }}" class="flex-1 px-8 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-2xl transition-all-300 text-center">
                    إلغاء
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
