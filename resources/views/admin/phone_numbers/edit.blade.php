@extends('admin.layouts.app')

@section('title', 'تعديل رقم الهاتف')

@section('content')
<div class="max-w-2xl mx-auto animate-fade-in">
    <div class="mb-8">
        <a href="{{ route('admin.phone_numbers.index') }}" class="text-slate-500 hover:text-primary-start transition-colors mb-4 inline-flex items-center text-sm font-medium">
            <i class="fas fa-arrow-right ml-2 text-xs"></i> العودة للأرقام
        </a>
        <h2 class="text-3xl font-bold text-slate-800">تعديل رقم الهاتف: {{ $phoneNumber->phone_number }}</h2>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <form action="{{ route('admin.phone_numbers.update', $phoneNumber) }}" method="POST" class="p-8">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Phone Number -->
                <div>
                    <label for="phone_number" class="block text-sm font-bold text-slate-700 mb-2">رقم الهاتف <span class="text-rose-500">*</span></label>
                    <input type="text" 
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none @error('phone_number') border-rose-500 ring-rose-500/10 @enderror dir-ltr text-right" 
                           id="phone_number" name="phone_number" value="{{ old('phone_number', $phoneNumber->phone_number) }}" placeholder="أدخل رقم الهاتف">
                    @error('phone_number')
                        <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="flex items-center">
                    <label class="relative inline-flex items-center cursor-pointer group">
                        <input type="checkbox" id="status" name="status" value="1" class="sr-only peer" {{ old('status', $phoneNumber->status) ? 'checked' : '' }}>
                        <div class="w-12 h-6 bg-slate-200 peer-focus:ring-4 peer-focus:ring-emerald-500/20 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:right-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                        <span class="mr-3 text-sm font-bold text-slate-700">تفعيل الرقم</span>
                    </label>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                    <button type="submit" class="px-8 py-3 bg-primary-start hover:bg-primary-end text-white font-bold rounded-2xl shadow-lg hover:shadow-primary-start/30 transition-all-300 flex-1 flex justify-center items-center">
                        <i class="fas fa-save ml-2"></i> حفظ التغييرات
                    </button>
                    <a href="{{ route('admin.phone_numbers.index') }}" class="px-8 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-2xl transition-all-300 text-center">
                        إلغاء
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
