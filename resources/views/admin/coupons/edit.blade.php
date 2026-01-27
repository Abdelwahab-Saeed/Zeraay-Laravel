@extends('admin.layouts.app')

@section('title', 'تعديل الكوبون')

@section('content')
<div class="max-w-4xl mx-auto animate-fade-in">
    <div class="mb-8">
        <a href="{{ route('admin.coupons.index') }}" class="text-slate-500 hover:text-primary-start transition-colors mb-4 inline-flex items-center text-sm font-medium">
            <i class="fas fa-arrow-right ml-2 text-xs"></i> العودة للكوبونات
        </a>
        <h2 class="text-3xl font-bold text-slate-800">تعديل الكوبون: {{ $coupon->code }}</h2>
        <p class="text-slate-500 mt-1">تعديل خصائص وشروط كود الخصم الحالي.</p>
    </div>

    <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST" novalidate>
        @csrf
        @method('PUT')
        <div class="bg-white rounded-[40px] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 md:p-12 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Code -->
                    <div>
                        <label for="code" class="block text-sm font-bold text-slate-700 mb-3">كود الخصم <span class="text-rose-500">*</span></label>
                        <div class="relative group">
                            <i class="fas fa-tag absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary-start transition-colors"></i>
                            <input type="text" name="code" id="code" value="{{ old('code', $coupon->code) }}" 
                                   class="w-full pr-11 pl-4 py-4 rounded-2xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none text-sm uppercase" 
                                  >
                        </div>
                        @error('code') <p class="text-rose-500 text-xs mt-2 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-bold text-slate-700 mb-3">نوع الخصم <span class="text-rose-500">*</span></label>
                        <select name="type" id="type" class="w-full px-4 py-4 rounded-2xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none text-sm bg-white cursor-pointer appearance-none">
                            <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>مبلغ ثابت (ج.م)</option>
                            <option value="percent" {{ old('type', $coupon->type) == 'percent' ? 'selected' : '' }}>نسبة مئوية (%)</option>
                        </select>
                        @error('type') <p class="text-rose-500 text-xs mt-2 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Value -->
                    <div>
                        <label for="value" class="block text-sm font-bold text-slate-700 mb-3">قيمة الخصم <span class="text-rose-500">*</span></label>
                        <input type="number" step="0.01" name="value" id="value" value="{{ old('value', $coupon->value) }}" 
                               class="w-full px-4 py-4 rounded-2xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none text-sm" 
                              >
                        @error('value') <p class="text-rose-500 text-xs mt-2 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Min Purchase -->
                    <div>
                        <label for="min_purchase" class="block text-sm font-bold text-slate-700 mb-3">الحد الأدنى للشراء</label>
                        <input type="number" step="0.01" name="min_purchase" id="min_purchase" value="{{ old('min_purchase', $coupon->min_purchase) }}" 
                               class="w-full px-4 py-4 rounded-2xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none text-sm">
                        @error('min_purchase') <p class="text-rose-500 text-xs mt-2 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Expiration -->
                    <div>
                        <label for="expires_at" class="block text-sm font-bold text-slate-700 mb-3">تاريخ الانتهاء</label>
                        <input type="date" name="expires_at" id="expires_at" value="{{ old('expires_at', $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : '') }}" 
                               class="w-full px-4 py-4 rounded-2xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none text-sm bg-white">
                        @error('expires_at') <p class="text-rose-500 text-xs mt-2 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-bold text-slate-700 mb-3">وصف الكوبون (اختياري)</label>
                    <textarea name="description" id="description" rows="3" 
                              class="w-full px-4 py-4 rounded-2xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none text-sm">{{ old('description', $coupon->description) }}</textarea>
                    @error('description') <p class="text-rose-500 text-xs mt-2 font-medium">{{ $message }}</p> @enderror
                </div>

                <!-- Status -->
                <div class="flex items-center">
                    <label class="relative inline-flex items-center cursor-pointer group">
                        <input type="hidden" name="status" value="0">
                        <input type="checkbox" name="status" value="1" class="sr-only peer" {{ old('status', $coupon->status) ? 'checked' : '' }}>
                        <div class="w-12 h-6 bg-slate-200 peer-focus:ring-4 peer-focus:ring-emerald-500/20 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:right-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                        <span class="mr-3 text-sm font-bold text-slate-700">تفعيل الكوبون</span>
                    </label>
                </div>

                <div class="pt-4 flex gap-4">
                    <button type="submit" class="w-full md:w-auto px-12 py-4 bg-primary-start hover:bg-primary-end text-white font-bold rounded-2xl shadow-lg hover:shadow-primary-start/30 transition-all-300 flex items-center justify-center">
                        <i class="fas fa-save ml-2"></i> تحديث الكوبون
                    </button>
                    <a href="{{ route('admin.coupons.index') }}" class="w-full md:w-auto px-8 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-2xl transition-all-300 text-center">
                        إلغاء
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
