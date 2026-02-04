@extends('admin.layouts.app')

@section('title', 'إضافة شركة جديدة')

@section('content')
<div class="max-w-3xl mx-auto animate-fade-in">
    <div class="mb-8">
        <a href="{{ route('admin.companies.index') }}" class="text-slate-500 hover:text-primary-start transition-colors mb-4 inline-flex items-center text-sm font-medium">
            <i class="fas fa-arrow-right ml-2 text-xs"></i> العودة للشركات
        </a>
        <h2 class="text-3xl font-bold text-slate-800">إضافة شركة جديدة</h2>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <form action="{{ route('admin.companies.store') }}" method="POST" novalidate enctype="multipart/form-data" class="p-8">
            @csrf

            <div class="space-y-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-bold text-slate-700 mb-2">اسم الشركة <span class="text-rose-500">*</span></label>
                    <input type="text" 
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none @error('name') border-rose-500 ring-rose-500/10 @enderror" 
                           id="name" name="name" value="{{ old('name') }}" placeholder="أدخل اسم الشركة">
                    @error('name')
                        <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-bold text-slate-700 mb-2">الوصف</label>
                    <textarea class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none @error('description') border-rose-500 ring-rose-500/10 @enderror" 
                              id="description" name="description" rows="4" placeholder="اكتب وصفاً قصيراً للشركة...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Logo -->
                <div>
                    <label for="logo" class="block text-sm font-bold text-slate-700 mb-2">شعار الشركة</label>
                    <div class="relative group">
                        <input type="file" 
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                               id="logo" name="logo" accept="image/*"
                               onchange="document.getElementById('fileName').textContent = this.files[0].name">
                        <div class="w-full px-4 py-8 rounded-2xl border-2 border-dashed border-slate-200 group-hover:border-primary-start/30 transition-all-300 bg-slate-50/50 text-center">
                            <i class="fas fa-cloud-upload-alt text-4xl text-slate-300 group-hover:text-primary-start transition-all-300 mb-2"></i>
                            <p class="text-sm text-slate-500 font-medium" id="fileName">اضغط لرفع الشعار أو اسحبه هنا</p>
                            <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-widest">PNG, JPG up to 2MB</p>
                        </div>
                    </div>
                    @error('logo')
                        <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                    <button type="submit" class="px-8 py-3 bg-primary-start hover:bg-primary-end text-white font-bold rounded-2xl shadow-lg hover:shadow-primary-start/30 transition-all-300 flex-1 flex justify-center items-center">
                        <i class="fas fa-save ml-2"></i> حفظ الشركة
                    </button>
                    <a href="{{ route('admin.companies.index') }}" class="px-8 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-2xl transition-all-300 text-center">
                        إلغاء
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
