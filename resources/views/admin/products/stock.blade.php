@extends('admin.layouts.app')

@section('title', 'إدارة المخزون')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 animate-fade-in">
    <div>
        <h2 class="text-3xl font-bold text-slate-800">إدارة المخزون</h2>
        <p class="text-slate-500 mt-1">متابعة مستويات المخزون للمنتجات والتحكم في الكميات.</p>
    </div>
</div>

<!-- Stock Filters/Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 animate-fade-in">
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex items-center">
        <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500 ml-4">
            <i class="fas fa-check-circle text-xl"></i>
        </div>
        <div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">متوفر</p>
            <p class="text-2xl font-bold text-slate-800">{{ \App\Models\Product::where('stock', '>', 5)->count() }} <span class="text-sm font-medium text-slate-400">منتج</span></p>
        </div>
    </div>
    
    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex items-center">
        <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500 ml-4">
            <i class="fas fa-exclamation-triangle text-xl"></i>
        </div>
        <div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">مخزون منخفض</p>
            <p class="text-2xl font-bold text-slate-800">{{ \App\Models\Product::where('stock', '>', 0)->where('stock', '<=', 5)->count() }} <span class="text-sm font-medium text-slate-400">منتج</span></p>
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm flex items-center">
        <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-500 ml-4">
            <i class="fas fa-times-circle text-xl"></i>
        </div>
        <div>
            <p class="text-slate-400 text-xs font-bold uppercase tracking-wider">نفذ من المخزون</p>
            <p class="text-2xl font-bold text-slate-800">{{ \App\Models\Product::where('stock', '<=', 0)->count() }} <span class="text-sm font-medium text-slate-400">منتج</span></p>
        </div>
    </div>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 mb-8 animate-fade-in">
    <form method="GET" action="{{ route('admin.products.stock') }}">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <div class="md:col-span-6 relative group">
                <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary-start transition-colors"></i>
                <input type="text" name="search" 
                       class="w-full pr-11 pl-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none text-sm" 
                       placeholder="البحث بالاسم..." value="{{ request('search') }}">
            </div>
            <div class="md:col-span-4">
                <select name="level" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none text-sm bg-white cursor-pointer appearance-none">
                    <option value="">جميع المستويات</option>
                    <option value="low" {{ request('level') === 'low' ? 'selected' : '' }}>مخزون منخفض (أقل من 5)</option>
                    <option value="out" {{ request('level') === 'out' ? 'selected' : '' }}>نافذ من المخزون (0)</option>
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
                    <th class="px-6 py-4 font-semibold">المنتج</th>
                    <th class="px-6 py-4 font-semibold">الفئة</th>
                    <th class="px-6 py-4 font-semibold text-center">الكمية الحالية</th>
                    <th class="px-6 py-4 font-semibold text-center">الحالة</th>
                    <th class="px-6 py-4 font-semibold text-left">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($products as $product)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if($product->image)
                                    <div class="w-10 h-10 rounded-lg overflow-hidden ml-3 shadow-sm ring-2 ring-white group-hover:ring-slate-100 transition-all">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400 ml-3">
                                        <i class="fas fa-box text-sm"></i>
                                    </div>
                                @endif
                                <div class="font-bold text-slate-700 group-hover:text-primary-start transition-colors">{{ $product->name }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-slate-100 text-slate-600 text-xs px-2.5 py-1 rounded-lg font-bold">
                                {{ $product->category->name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-lg font-black text-slate-800">{{ $product->stock }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center">
                                @if($product->stock <= 0)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-rose-100 text-rose-600">
                                        <i class="fas fa-times-circle ml-1"></i> نافذ
                                    </span>
                                @elseif($product->stock <= 5)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-amber-100 text-amber-600 animate-pulse">
                                        <i class="fas fa-exclamation-triangle ml-1"></i> منخفض
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-600">
                                        <i class="fas fa-check-circle ml-1"></i> جيد
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-left">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-primary-start hover:text-white text-slate-600 rounded-xl text-xs font-bold transition-all-300">
                                    <i class="fas fa-plus-minus ml-1.5 text-[10px]"></i> تحديث المخزون
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            <i class="fas fa-box-open text-4xl mb-4 opacity-20"></i>
                            <p>لا توجد منتجات مطابقة للبحث</p>
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
