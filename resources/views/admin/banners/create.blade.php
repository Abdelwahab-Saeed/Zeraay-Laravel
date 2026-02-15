@extends('admin.layouts.app')

@section('title', 'إضافة بانر جديد')

@section('content')
<div class="max-w-3xl mx-auto animate-fade-in">
    <div class="mb-8">
        <a href="{{ route('admin.banners.index') }}" class="text-slate-500 hover:text-primary-start transition-colors mb-4 inline-flex items-center text-sm font-medium">
            <i class="fas fa-arrow-right ml-2 text-xs"></i> العودة للبانرات
        </a>
        <h2 class="text-3xl font-bold text-slate-800">إضافة بانر جديد</h2>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf

            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-bold text-slate-700 mb-2">عنوان البانر</label>
                    <input type="text" 
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none @error('title') border-rose-500 ring-rose-500/10 @enderror" 
                           id="title" name="title" value="{{ old('title') }}" placeholder="أدخل عنوان البانر">
                    @error('title')
                        <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-bold text-slate-700 mb-2">الوصف</label>
                    <textarea class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none @error('description') border-rose-500 ring-rose-500/10 @enderror" 
                              id="description" name="description" rows="4" placeholder="اكتب وصفاً للبانر...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div>
                    <label for="image" class="block text-sm font-bold text-slate-700 mb-2">صورة البانر <span class="text-rose-500">*</span></label>
                    <div class="relative group">
                        <input type="file" 
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                               id="image" name="image" accept="image/*"
                               onchange="document.getElementById('fileName').textContent = this.files[0].name">
                        <div class="w-full px-4 py-8 rounded-2xl border-2 border-dashed border-slate-200 group-hover:border-primary-start/30 transition-all-300 bg-slate-50/50 text-center">
                            <i class="fas fa-cloud-upload-alt text-4xl text-slate-300 group-hover:text-primary-start transition-all-300 mb-2"></i>
                            <p class="text-sm text-slate-500 font-medium" id="fileName">اضغط لرفع صورة أو اسحبها هنا</p>
                            <p class="text-[10px] text-slate-400 mt-1 uppercase tracking-widest">PNG, JPG up to 2MB</p>
                        </div>
                    </div>
                    @error('image')
                        <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="flex items-center">
                    <label class="relative inline-flex items-center cursor-pointer group">
                        <input type="checkbox" id="status" name="status" value="1" class="sr-only peer" {{ old('status', true) ? 'checked' : '' }}>
                        <div class="w-12 h-6 bg-slate-200 peer-focus:ring-4 peer-focus:ring-emerald-500/20 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:right-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                        <span class="mr-3 text-sm font-bold text-slate-700">تفعيل البانر</span>
                    </label>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                    <button type="submit" class="px-8 py-3 bg-primary-start hover:bg-primary-end text-white font-bold rounded-2xl shadow-lg hover:shadow-primary-start/30 transition-all-300 flex-1 flex justify-center items-center">
                        <i class="fas fa-save ml-2"></i> حفظ البانر
                    </button>
                    <a href="{{ route('admin.banners.index') }}" class="px-8 py-3 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-2xl transition-all-300 text-center">
                        إلغاء
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
