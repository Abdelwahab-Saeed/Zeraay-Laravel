@extends('admin.layouts.app')

@section('title', 'لوحة التحكم | الرئيسية')

@section('content')
@php
    $statusClasses = [
        'pending' => 'bg-amber-100 text-amber-600',
        'processing' => 'bg-blue-100 text-blue-600',
        'shipped' => 'bg-purple-100 text-purple-600',
        'delivered' => 'bg-emerald-100 text-emerald-600',
        'cancelled' => 'bg-rose-100 text-rose-600',
    ];
    $statusLabels = [
        'pending' => 'قيد الانتظار',
        'processing' => 'قيد التنفيذ',
        'shipped' => 'تم الشحن',
        'delivered' => 'تم التوصيل',
        'cancelled' => 'ملغي',
    ];
@endphp
<div class="mb-8 animate-fade-in">
    <h2 class="text-3xl font-bold text-slate-800">مرحباً بك، {{ Auth::user()->name }}</h2>
    <p class="text-slate-500 mt-2">إليك ملخص سريع لأداء متجرك اليوم.</p>
</div>

<!-- Stat Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Orders Card -->
    <div class="bg-slate-900 rounded-3xl p-6 text-white shadow-xl hover:scale-[1.02] transition-all-300 group overflow-hidden relative">
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-white/10 rounded-2xl group-hover:rotate-12 transition-all-300">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                </div>
                <div class="text-xs font-bold bg-amber-500 text-white px-2 py-1 rounded-lg">جديد</div>
            </div>
            <h3 class="text-white/60 text-sm font-medium">إجمالي الطلبات</h3>
            <div class="text-4xl font-bold mt-1">{{ \App\Models\Order::count() }}</div>
            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center mt-6 text-sm font-bold bg-white/10 hover:bg-white text-white hover:text-slate-900 px-4 py-2 rounded-xl transition-all-300">
                متابعة الطلبات <i class="fas fa-arrow-left mr-2"></i>
            </a>
        </div>
        <i class="fas fa-shopping-cart absolute -bottom-6 -left-6 text-9xl opacity-5 group-hover:scale-110 transition-all-300"></i>
    </div>

    <!-- Categories Card -->
    <div class="card-gradient-primary rounded-3xl p-6 text-white shadow-xl hover:scale-[1.02] transition-all-300 group overflow-hidden relative">
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-white/20 rounded-2xl group-hover:rotate-12 transition-all-300">
                    <i class="fas fa-folder text-2xl"></i>
                </div>
            </div>
            <h3 class="text-white/80 text-sm font-medium">الفئات</h3>
            <div class="text-4xl font-bold mt-1">{{ \App\Models\Category::count() }}</div>
            <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center mt-6 text-sm font-bold bg-white/20 hover:bg-white text-white hover:text-primary-start px-4 py-2 rounded-xl transition-all-300">
                إدارة <i class="fas fa-arrow-left mr-2"></i>
            </a>
        </div>
        <i class="fas fa-folder absolute -bottom-6 -left-6 text-9xl opacity-10 group-hover:scale-110 transition-all-300"></i>
    </div>

    <!-- Products Card -->
    <div class="card-gradient-success rounded-3xl p-6 text-white shadow-xl hover:scale-[1.02] transition-all-300 group overflow-hidden relative">
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-white/20 rounded-2xl group-hover:rotate-12 transition-all-300">
                    <i class="fas fa-box text-2xl"></i>
                </div>
            </div>
            <h3 class="text-white/80 text-sm font-medium">المنتجات</h3>
            <div class="text-4xl font-bold mt-1">{{ \App\Models\Product::count() }}</div>
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center mt-6 text-sm font-bold bg-white/20 hover:bg-white text-white hover:text-success-start px-4 py-2 rounded-xl transition-all-300">
                إدارة <i class="fas fa-arrow-left mr-2"></i>
            </a>
        </div>
        <i class="fas fa-box absolute -bottom-6 -left-6 text-9xl opacity-10 group-hover:scale-110 transition-all-300"></i>
    </div>

    <!-- Users Card -->
    <div class="card-gradient-info rounded-3xl p-6 text-white shadow-xl hover:scale-[1.02] transition-all-300 group overflow-hidden relative">
        <div class="relative z-10">
            <div class="flex justify-between items-start mb-4">
                <div class="p-3 bg-white/20 rounded-2xl group-hover:rotate-12 transition-all-300">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
            <h3 class="text-white/80 text-sm font-medium">المستخدمين</h3>
            <div class="text-4xl font-bold mt-1">{{ \App\Models\User::count() }}</div>
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center mt-6 text-sm font-bold bg-white/20 hover:bg-white text-white hover:text-secondary-start px-4 py-2 rounded-xl transition-all-300">
                إدارة <i class="fas fa-arrow-left mr-2"></i>
            </a>
        </div>
        <i class="fas fa-users absolute -bottom-6 -left-6 text-9xl opacity-10 group-hover:scale-110 transition-all-300"></i>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Orders -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
            <h5 class="text-lg font-bold text-slate-800">أحدث الطلبات</h5>
            <a href="{{ route('admin.orders.index') }}" class="text-primary-start hover:text-primary-end text-sm font-bold">عرض الكل</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="text-slate-400 text-sm uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">رقم الطلب</th>
                        <th class="px-6 py-4 font-semibold text-center">المبلغ</th>
                        <th class="px-6 py-4 font-semibold text-left">الحالة</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse(\App\Models\Order::latest()->take(5)->get() as $order)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-700 group-hover:text-primary-start transition-colors">#{{ $order->id }}</div>
                                <div class="text-[10px] text-slate-400 font-medium">{{ $order->created_at->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-bold text-slate-900">{{ number_format($order->final_amount, 2) }} ج.م</span>
                            </td>
                            <td class="px-6 py-4 text-left">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold {{ $statusClasses[$order->status] }}">
                                    {{ $statusLabels[$order->status] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-slate-400">لا توجد طلبات حالياً</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Products -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
            <h5 class="text-lg font-bold text-slate-800">أحدث المنتجات</h5>
            <a href="{{ route('admin.products.index') }}" class="text-primary-start hover:text-primary-end text-sm font-bold">عرض الكل</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-right border-collapse">
                <thead>
                    <tr class="text-slate-400 text-sm uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">المنتج</th>
                        <th class="px-6 py-4 font-semibold">الفئة</th>
                        <th class="px-6 py-4 font-semibold text-left">السعر</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse(\App\Models\Product::with('category')->latest()->take(5)->get() as $product)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-700 group-hover:text-primary-start transition-colors">{{ $product->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-slate-100 text-slate-600 text-xs px-2 py-1 rounded-lg">{{ $product->category->name }}</span>
                            </td>
                            <td class="px-6 py-4 text-left font-bold text-slate-900">
                                {{ number_format((float)$product->price, 2) }} ج.م
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-slate-400">لا توجد منتجات حالياً</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
