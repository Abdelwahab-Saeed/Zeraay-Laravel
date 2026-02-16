@extends('admin.layouts.app')

@section('title', 'إدارة الطلبات')

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
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 animate-fade-in">
    <div>
        <h2 class="text-3xl font-bold text-slate-800">إدارة الطلبات</h2>
        <p class="text-slate-500 mt-1">عرض ومتابعة كافة الطلبات المقدمة من العملاء.</p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8 animate-fade-in">
    <!-- Total Revenue -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-between">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 rounded-xl bg-primary-start/10 flex items-center justify-center text-primary-start">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">الإيرادات</span>
        </div>
        <div>
            <h4 class="text-xl font-black text-slate-800">{{ number_format($statistics['total_revenue'], 2) }}</h4>
            <p class="text-xs text-slate-400 mt-1">إجمالي المبيعات (المستلمة)</p>
        </div>
    </div>

    <!-- Pending Orders -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-between">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600">
                <i class="fas fa-clock"></i>
            </div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">قيد الانتظار</span>
        </div>
        <div>
            <h4 class="text-2xl font-black text-slate-800">{{ $statistics['pending'] }}</h4>
            <p class="text-xs text-slate-400 mt-1">طلبات بانتظار المراجعة</p>
        </div>
    </div>

    <!-- Processing Orders -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-between">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600">
                <i class="fas fa-cog fa-spin"></i>
            </div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">قيد التنفيذ</span>
        </div>
        <div>
            <h4 class="text-2xl font-black text-slate-800">{{ $statistics['processing'] }}</h4>
            <p class="text-xs text-slate-400 mt-2">طلبات يتم تجهيزها</p>
        </div>
    </div>

    <!-- Shipped Orders -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-between">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center text-purple-600">
                <i class="fas fa-truck-fast"></i>
            </div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">تم الشحن</span>
        </div>
        <div>
            <h4 class="text-2xl font-black text-slate-800">{{ $statistics['shipped'] }}</h4>
            <p class="text-xs text-slate-400 mt-2">طلبات في الطريق للعميل</p>
        </div>
    </div>

    <!-- Delivered Orders -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-between">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600">
                <i class="fas fa-check-double"></i>
            </div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">تم التوصيل</span>
        </div>
        <div>
            <h4 class="text-2xl font-black text-slate-800">{{ $statistics['delivered'] }}</h4>
            <p class="text-xs text-slate-400 mt-2">طلبات تمت بنجاح</p>
        </div>
    </div>

    <!-- Cancelled Orders -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-between">
        <div class="flex items-center justify-between mb-4">
            <div class="w-10 h-10 rounded-xl bg-rose-100 flex items-center justify-center text-rose-600">
                <i class="fas fa-times-circle"></i>
            </div>
            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">ملغي</span>
        </div>
        <div>
            <h4 class="text-2xl font-black text-slate-800">{{ $statistics['cancelled'] }}</h4>
            <p class="text-xs text-slate-400 mt-2">طلبات تم إلغاؤها</p>
        </div>
    </div>
</div>

<!-- Filters & Search -->
<div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 mb-8 animate-fade-in">
    <form method="GET" action="{{ route('admin.orders.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="md:col-span-2 relative group">
            <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary-start transition-colors"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   class="w-full pr-11 pl-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none text-sm" 
                   placeholder="البحث باسم العميل، البريد، أو الهاتف...">
        </div>
        <div>
            <select name="status" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none text-sm bg-white cursor-pointer appearance-none">
                <option value="">كل الحالات</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>قيد التنفيذ</option>
                <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>تم الشحن</option>
                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>تم التوصيل</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
            </select>
        </div>
        <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-xl transition-all-300 flex items-center justify-center">
            <i class="fas fa-filter ml-2 text-xs"></i> تصفية
        </button>
    </form>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden animate-fade-in">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[1000px] text-right border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-sm uppercase tracking-wider border-b border-slate-100">
                    <th class="px-6 py-4 font-semibold">رقم الطلب</th>
                    <th class="px-6 py-4 font-semibold">العميل</th>
                    <th class="px-6 py-4 font-semibold text-center">المبلغ النهائي</th>
                    <th class="px-6 py-4 font-semibold text-center">عدد الأصناف</th>
                    <th class="px-6 py-4 font-semibold text-center">تاريخ الطلب</th>
                    <th class="px-6 py-4 font-semibold text-center">الحالة</th>
                    <th class="px-6 py-4 font-semibold text-left">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($orders as $order)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-700">#{{ $order->id }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-slate-700 font-bold">{{ $order->name }}</div>
                            <div class="text-[10px] text-slate-400">وسيلة الدفع: {{ $order->paymentMethod?->name ?: 'غير محددة' }}</div>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <span class="text-primary-start font-bold">
                                {{ number_format($order->final_amount, 2) }} ج.م
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <span class="bg-slate-100 text-slate-600 text-[10px] px-2 py-1 rounded-lg font-bold">
                                {{ $order->items_count }} أصناف
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center text-slate-500 text-sm whitespace-nowrap">
                            {{ $order->created_at->format('Y-m-d H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold {{ $statusClasses[$order->status] }}">
                                    {{ $statusLabels[$order->status] }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.orders.show', $order) }}" class="p-2 text-primary-start hover:bg-primary-start/10 rounded-xl transition-all-300" title="عرض التفاصيل">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                            <i class="fas fa-box-open text-4xl mb-4 opacity-20"></i>
                            <p>لا توجد طلبات حالياً</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
