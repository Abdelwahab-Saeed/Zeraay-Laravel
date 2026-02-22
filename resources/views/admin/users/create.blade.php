@extends('admin.layouts.app')

@section('title', 'إضافة مستخدم جديد')

@section('content')
<div class="max-w-4xl mx-auto animate-fade-in">
    <div class="mb-8">
        <a href="{{ route('admin.users.index') }}" class="text-slate-500 hover:text-primary-start transition-colors mb-4 inline-flex items-center text-sm font-medium">
            <i class="fas fa-arrow-right ml-2 text-xs"></i> العودة للمستخدمين
        </a>
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-slate-800">إضافة مستخدم جديد</h2>
                <p class="text-slate-500 mt-1">إنشاء حساب جديد في النظام.</p>
            </div>
            <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 border-4 border-white shadow-sm">
                <i class="fas fa-user-plus text-2xl"></i>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST" novalidate>
        @csrf

        <div class="space-y-8">
            <!-- Profile Info Card -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-8 border-b border-slate-50 bg-slate-50/50">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center">
                        <i class="fas fa-user-edit ml-3 text-primary-start"></i> البيانات الحساب
                    </h3>
                </div>
                
                <div class="p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-bold text-slate-700 mb-2">الاسم <span class="text-rose-500">*</span></label>
                            <input type="text" 
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none @error('name') border-rose-500 ring-rose-500/10 @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" placeholder="أدخل اسم المستخدم بالكامل">
                            @error('name')
                                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-bold text-slate-700 mb-2">البريد الإلكتروني <span class="text-rose-500">*</span></label>
                            <input type="email" 
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none @error('email') border-rose-500 ring-rose-500/10 @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" placeholder="example@domain.com">
                            @error('email')
                                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="phone" class="block text-sm font-bold text-slate-700 mb-2">الهاتف</label>
                            <input type="text" 
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none @error('phone') border-rose-500 ring-rose-500/10 @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}" placeholder="01xxxxxxxxx">
                            @error('phone')
                                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="role" class="block text-sm font-bold text-slate-700 mb-2">الدور <span class="text-rose-500">*</span></label>
                            <select class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none bg-white appearance-none cursor-pointer" 
                                    id="role" name="role">
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>مستخدم (User)</option>
                                <option value="customer_service" {{ old('role') == 'customer_service' ? 'selected' : '' }}>خدمة عملاء (Customer Service)</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>مدير (Admin)</option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="city" class="block text-sm font-bold text-slate-700 mb-2">المدينة</label>
                            <input type="text" 
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none" 
                                   id="city" name="city" value="{{ old('city') }}" placeholder="المدينة">
                        </div>

                        <div>
                            <label for="state" class="block text-sm font-bold text-slate-700 mb-2">المحافظة</label>
                            <input type="text" 
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none" 
                                   id="state" name="state" value="{{ old('state') }}" placeholder="المحافظة">
                        </div>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-bold text-slate-700 mb-2">العنوان</label>
                        <textarea class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none" 
                                  id="address" name="address" rows="3" placeholder="العنوان بالتفصيل...">{{ old('address') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Password Card -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-8 border-b border-slate-50 bg-slate-50/50">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center">
                        <i class="fas fa-lock ml-3 text-amber-500"></i> الأمان (تعيين كلمة المرور)
                    </h3>
                </div>
                
                <div class="p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-bold text-slate-700 mb-2">كلمة المرور <span class="text-rose-500">*</span></label>
                            <input type="password" 
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none @error('password') border-rose-500 ring-rose-500/10 @enderror" 
                                   id="password" name="password" placeholder="أدخل كلمة مرور قوية">
                            @error('password')
                                <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-slate-700 mb-2">تأكيد كلمة المرور <span class="text-rose-500">*</span></label>
                            <input type="password" 
                                   class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none" 
                                   id="password_confirmation" name="password_confirmation" placeholder="أعد كتابة كلمة المرور">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="flex items-center gap-4 py-4">
                <button type="submit" class="px-12 py-4 bg-primary-start hover:bg-primary-end text-white font-bold rounded-2xl shadow-lg hover:shadow-primary-start/30 transition-all-300 flex items-center justify-center min-w-[200px]">
                    <i class="fas fa-user-plus ml-2"></i> إنشاء المستخدم
                </button>
                <a href="{{ route('admin.users.index') }}" class="px-8 py-4 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-2xl transition-all-300">
                    إلغاء
                </a>
            </div>
        </div>
    </form>
</div>
@endsection
