@extends('admin.layouts.app')

@section('title', 'تعديل البانر')

@section('content')
<div class="max-w-3xl mx-auto animate-fade-in">
    <div class="mb-8">
        <a href="{{ route('admin.banners.index') }}" class="text-slate-500 hover:text-primary-start transition-colors mb-4 inline-flex items-center text-sm font-medium">
            <i class="fas fa-arrow-right ml-2 text-xs"></i> العودة للبانرات
        </a>
        <h2 class="text-3xl font-bold text-slate-800">تعديل البانر: {{ $banner->title ?: 'بدون عنوان' }}</h2>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-bold text-slate-700 mb-2">العنوان</label>
                    <input type="text" 
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none @error('title') border-rose-500 ring-rose-500/10 @enderror" 
                           id="title" name="title" value="{{ old('title', $banner->title) }}">
                    @error('title')
                        <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-bold text-slate-700 mb-2">الوصف</label>
                    <textarea class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none @error('description') border-rose-500 ring-rose-500/10 @enderror" 
                              id="description" name="description" rows="4">{{ old('description', $banner->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image -->
                <div>
                    <label for="image" class="block text-sm font-bold text-slate-700 mb-2">الصورة</label>
                    <div class="flex flex-col md:flex-row gap-6">
                        @if($banner->image)
                            <div class="relative group">
                                <div class="w-48 h-24 rounded-2xl overflow-hidden shadow-lg ring-4 ring-slate-50 group-hover:ring-primary-start transition-all">
                                    <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                                </div>
                                <div class="absolute -top-2 -right-2 bg-emerald-500 text-white p-1 rounded-full shadow-lg border-2 border-white">
                                    <i class="fas fa-check text-[10px]"></i>
                                </div>
                                <p class="text-[10px] text-center text-slate-400 mt-2 font-bold uppercase tracking-wider">الصورة الحالية</p>
                            </div>
                        @endif
                        
                        <div class="flex-1">
                            <div class="relative group h-full">
                                <input type="file" 
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                                       id="image" name="image" accept="image/*"
                                       onchange="document.getElementById('fileName').textContent = this.files[0].name">
                                <div class="w-full h-full min-h-[96px] px-4 py-6 rounded-2xl border-2 border-dashed border-slate-200 group-hover:border-primary-start/30 transition-all-300 bg-slate-50/50 text-center flex flex-col justify-center items-center">
                                    <i class="fas fa-cloud-upload-alt text-2xl text-slate-300 group-hover:text-primary-start transition-all-300 mb-1"></i>
                                    <p class="text-xs text-slate-500 font-medium" id="fileName">اضغط لتغيير الصورة</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @error('image')
                        <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="flex items-center">
                    <label class="relative inline-flex items-center cursor-pointer group">
                        <input type="checkbox" id="status" name="status" value="1" class="sr-only peer" {{ old('status', $banner->status) ? 'checked' : '' }}>
                        <div class="w-12 h-6 bg-slate-200 peer-focus:ring-4 peer-focus:ring-emerald-500/20 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:right-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                        <span class="mr-3 text-sm font-bold text-slate-700">تفعيل البانر</span>
                    </label>
                </div>

                <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                    <button type="submit" class="px-8 py-3 bg-primary-start hover:bg-primary-end text-white font-bold rounded-2xl shadow-lg hover:shadow-primary-start/30 transition-all-300 flex-1 flex justify-center items-center">
                        <i class="fas fa-save ml-2"></i> حفظ التغييرات
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
