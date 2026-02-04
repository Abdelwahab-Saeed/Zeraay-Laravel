@extends('admin.layouts.app')

@section('title', 'المنتجات')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 animate-fade-in">
    <div>
        <h2 class="text-3xl font-bold text-slate-800">إدارة المنتجات</h2>
        <p class="text-slate-500 mt-1">عرض وتنظيم المنتجات المتاحة في متجرك.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-primary-start hover:bg-primary-end text-white font-bold rounded-2xl shadow-lg hover:shadow-primary-start/30 transition-all-300">
        <i class="fas fa-plus ml-2"></i> إضافة منتج جديد
    </a>
</div>

<!-- Filters -->
<div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 mb-8 animate-fade-in">
    <form method="GET" action="{{ route('admin.products.index') }}">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <div class="md:col-span-4 relative group">
                <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary-start transition-colors"></i>
                <input type="text" name="search" 
                       class="w-full pr-11 pl-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none text-sm" 
                       placeholder="البحث بالاسم..." value="{{ request('search') }}">
            </div>
            <div class="md:col-span-3">
                <select name="category_id" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none text-sm bg-white cursor-pointer appearance-none">
                    <option value="">جميع الفئات</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-3">
                <select name="status" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none text-sm bg-white cursor-pointer appearance-none">
                    <option value="">جميع الحالات</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>نشط</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>غير نشط</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <button type="submit" class="w-full py-3 bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-xl transition-all-300 flex items-center justify-center shadow-lg hover:shadow-slate-800/20">
                    <i class="fas fa-filter ml-2 text-xs"></i> تصفية
                </button>
            </div>
        </div>
    </form>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden animate-fade-in">
    <div class="overflow-x-auto">
        <table class="w-full text-right border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-sm uppercase tracking-wider border-b border-slate-100">
                    <th class="px-6 py-4 font-semibold">#</th>
                    <th class="px-6 py-4 font-semibold text-center">الصورة</th>
                    <th class="px-6 py-4 font-semibold">الاسم</th>
                    <th class="px-6 py-4 font-semibold text-right">الفئة</th>
                    <th class="px-6 py-4 font-semibold text-right">الشركة</th>
                    <th class="px-6 py-4 font-semibold text-left">السعر</th>
                    <th class="px-6 py-4 font-semibold text-center">المخزون</th>
                    <th class="px-6 py-4 font-semibold text-center">الحالة</th>
                    <th class="px-6 py-4 font-semibold text-left">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($products as $product)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4 text-slate-400 text-sm">{{ $product->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center">
                                @if($product->image)
                                    <div class="w-12 h-12 rounded-xl overflow-hidden shadow-sm ring-2 ring-white group-hover:ring-slate-100 transition-all">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400">
                                        <i class="fas fa-box text-xl"></i>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-700 group-hover:text-primary-start transition-colors">{{ $product->name }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-slate-100 text-slate-600 text-xs px-2.5 py-1 rounded-lg font-bold">
                                {{ $product->category->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-sm">
                            {{ $product->company->name ?? '---' }}
                        </td>
                        <td class="px-6 py-4 text-left">
                            <div class="flex flex-col items-start gap-1">
                                <span class="font-bold text-slate-900">{{ number_format($product->price, 2) }} ج.م</span>
                                @if($product->discount_price)
                                    <span class="text-[10px] text-emerald-500 font-bold bg-emerald-50 px-1.5 py-0.5 rounded">
                                        {{ number_format($product->discount_price, 2) }} ج.م
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center">
                                @if($product->stock > 0)
                                    <span class="bg-emerald-100 text-emerald-600 text-xs px-3 py-1 rounded-full font-bold">
                                        {{ $product->stock }} متوفر
                                    </span>
                                @else
                                    <span class="bg-rose-100 text-rose-600 text-xs px-3 py-1 rounded-full font-bold">
                                        منتهي
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center">
                                @if($product->status)
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
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}" class="p-2 text-amber-500 hover:bg-amber-50 rounded-xl transition-all-300" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" novalidate class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-rose-500 hover:bg-rose-50 rounded-xl transition-all-300" 
                                            data-confirm data-confirm-title="حذف المنتج" 
                                            data-confirm-message="هل أنت متأكد من رغبتك في حذف المنتج '{{ $product->name }}'؟" 
                                            title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-slate-400">
                            <i class="fas fa-box-open text-4xl mb-4 opacity-20"></i>
                            <p>لا توجد منتجات حالياً</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
