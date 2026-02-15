@extends('admin.layouts.app')

@section('title', 'عرض البانر')

@section('content')
<div class="max-w-4xl mx-auto animate-fade-in">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.banners.index') }}" class="text-slate-500 hover:text-primary-start transition-colors mb-4 inline-flex items-center text-sm font-medium">
                <i class="fas fa-arrow-right ml-2 text-xs"></i> العودة للبانرات
            </a>
            <h2 class="text-3xl font-bold text-slate-800">تفاصيل البانر</h2>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.banners.edit', $banner) }}" class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl shadow-lg shadow-amber-500/20 transition-all-300 flex items-center">
                <i class="fas fa-edit ml-2"></i> تعديل
            </a>
            <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-2.5 bg-rose-500 hover:bg-rose-600 text-white font-bold rounded-xl shadow-lg shadow-rose-500/20 transition-all-300 flex items-center" onclick="return confirm('هل أنت متأكد من رغبتك في حذف هذا البانر؟')">
                    <i class="fas fa-trash ml-2"></i> حذف
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Banner Image -->
        <div class="md:col-span-2 space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden p-4">
                <div class="aspect-[21/9] rounded-2xl overflow-hidden shadow-inner bg-slate-50">
                    @if($banner->image)
                        <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                            <i class="fas fa-image text-6xl"></i>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                <h3 class="text-xl font-bold text-slate-800 mb-4">وصف البانر</h3>
                <div class="text-slate-600 leading-relaxed">
                    {{ $banner->description ?: 'لا يوجد وصف لهذا البانر.' }}
                </div>
            </div>
        </div>

        <!-- Details Sidebar -->
        <div class="space-y-6">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                <h3 class="text-lg font-bold text-slate-800 mb-6 pb-4 border-b border-slate-50">معلومات البانر</h3>
                
                <div class="space-y-6">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">العنوان</p>
                        <p class="text-slate-700 font-bold text-lg">{{ $banner->title ?: 'بدون عنوان' }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">الحالة</p>
                        @if($banner->status)
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

                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">تاريخ الإنشاء</p>
                        <p class="text-slate-700 font-medium">{{ $banner->created_at->format('Y-m-d H:i') }}</p>
                    </div>

                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">آخر تحديث</p>
                        <p class="text-slate-700 font-medium">{{ $banner->updated_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
