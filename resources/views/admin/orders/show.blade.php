@extends('admin.layouts.app')

@section('title', 'تفاصيل الطلب #' . $order->id)

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
<div class="max-w-5xl mx-auto animate-fade-in">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.orders.index') }}" class="text-slate-500 hover:text-primary-start transition-colors mb-4 inline-flex items-center text-sm font-medium">
                <i class="fas fa-arrow-right ml-2 text-xs"></i> العودة للطلبات
            </a>
            <h2 class="text-3xl font-bold text-slate-800">تفاصيل الطلب #{{ $order->id }}</h2>
        </div>
        
        <!-- Status Update Form -->
        <div class="bg-white p-2 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-2">
            <form action="{{ route('admin.orders.update', $order) }}" method="POST" novalidate class="flex items-center gap-2">
                @csrf
                @method('PATCH')
                <select name="status" class="px-4 py-2 rounded-xl border border-slate-200 focus:border-primary-start outline-none text-sm bg-slate-50 cursor-pointer">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>قيد التنفيذ</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>تم الشحن</option>
                    <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>تم التوصيل</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                </select>
                <button type="submit" class="bg-primary-start hover:bg-primary-end text-white px-6 py-2 rounded-xl font-bold text-sm transition-all shadow-lg shadow-primary-start/20">
                    تحديث الحالة
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content: Order Items -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-50 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 flex items-center">
                        <i class="fas fa-shopping-basket ml-3 text-primary-start"></i> أصناف الطلب
                    </h3>
                </div>
                <div class="divide-y divide-slate-50">
                    @foreach($order->items as $item)
                        <div class="p-6 flex items-center gap-4 group">
                            <div class="w-16 h-16 rounded-2xl bg-slate-50 overflow-hidden border border-slate-100 flex-shrink-0">
                                @if($item->product->image)
                                    <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                        <i class="fas fa-image text-xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-slate-700 group-hover:text-primary-start transition-colors">{{ $item->product->name }}</h4>
                                <p class="text-xs text-slate-400">سعر الوحدة: {{ number_format($item->price, 2) }} ج.م</p>
                            </div>
                            <div class="text-left">
                                <div class="font-bold text-slate-700">x{{ $item->quantity }}</div>
                                <div class="text-sm font-bold text-primary-start">{{ number_format($item->subtotal, 2) }} ج.م</div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Summary in Footer of items card -->
                <div class="p-8 bg-slate-50/50 border-t border-slate-100 space-y-3">
                    <div class="flex justify-between items-center text-slate-500">
                        <span class="font-medium">المجموع الفرعي</span>
                        <span class="font-bold">{{ number_format($order->total_amount, 2) }} ج.م</span>
                    </div>
                    @if($order->discount_amount > 0)
                        <div class="flex justify-between items-center text-rose-500">
                            <span class="font-medium flex items-center">
                                <i class="fas fa-tag ml-2 text-xs"></i> خصم ({{ $order->coupon?->code }})
                            </span>
                            <span class="font-bold">-{{ number_format($order->discount_amount, 2) }} ج.م</span>
                        </div>
                    @endif
                    <div class="flex justify-between items-center pt-3 border-t border-slate-200">
                        <span class="text-lg font-bold text-slate-800">الإجمالي النهائي</span>
                        <span class="text-2xl font-black text-primary-start font-sans">{{ number_format($order->final_amount, 2) }} ج.م</span>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 space-y-6">
                <h3 class="font-bold text-slate-800 flex items-center mb-2">
                    <i class="fas fa-truck ml-3 text-primary-start"></i> معلومات الشحن والدفع
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1 block">رقم الهاتف</label>
                        <p class="text-slate-700 font-bold bg-slate-50 px-4 py-3 rounded-2xl border border-slate-100">{{ $order->phone }}</p>
                    </div>
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1 block">وسيلة الدفع</label>
                        <p class="text-slate-700 font-bold bg-slate-50 px-4 py-3 rounded-2xl border border-slate-100">
                             <i class="fas fa-credit-card ml-2 text-slate-400"></i> {{ $order->paymentMethod?->name ?: 'غير محددة' }}
                        </p>
                    </div>
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1 block">المحافظة / المدينة</label>
                        <p class="text-slate-700 font-bold bg-slate-50 px-4 py-3 rounded-2xl border border-slate-100">{{ $order->state }}</p>
                    </div>
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1 block">تاريخ الطلب</label>
                        <p class="text-slate-700 font-bold bg-slate-50 px-4 py-3 rounded-2xl border border-slate-100">{{ $order->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>
                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1 block">عنوان التوصيل بالتفصيل</label>
                    <div class="text-slate-700 font-bold bg-slate-50 px-6 py-4 rounded-3xl border border-slate-100 leading-relaxed">
                        {{ $order->address }}
                    </div>
                </div>
                @if($order->notes)
                    <div>
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1 block">ملاحظات العميل</label>
                        <p class="text-slate-500 italic bg-amber-50/50 p-4 rounded-2xl border border-amber-100">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar: Customer Info -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 text-center overflow-hidden relative">
                <div class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mx-auto mb-4 border-4 border-slate-50 relative z-10">
                    <i class="fas fa-user text-4xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800 relative z-10">{{ $order->name }}</h3>
                <p class="text-slate-500 text-sm mt-1 mb-6 relative z-10">{{ $order->user->email }}</p>
                
                <div class="grid grid-cols-2 gap-4 pt-6 border-t border-slate-50">
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase">صاحب الحساب</p>
                        <p class="text-sm font-black text-slate-700 truncate px-2">{{ $order->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-bold uppercase">إجمالي الطلبات</p>
                        <p class="text-sm font-bold text-slate-700">{{ $order->user->orders()->count() }}</p>
                    </div>
                </div>

                <div class="mt-8">
                    <a href="{{ route('admin.users.show', $order->user) }}" class="inline-flex items-center justify-center w-full py-3 bg-slate-50 hover:bg-slate-100 text-primary-start font-bold rounded-2xl border border-slate-100 transition-all">
                        عرض ملف العميل <i class="fas fa-arrow-left mr-2 text-xs"></i>
                    </a>
                </div>
            </div>

            <!-- Status Indicator Card -->
            <div class="bg-slate-900 rounded-3xl shadow-xl p-8 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <p class="text-xs text-white/50 uppercase tracking-widest font-bold mb-2">حالة الطلب الحالية</p>
                    <div class="text-2xl font-black mb-4">
                         {{ $statusLabels[$order->status] }}
                    </div>
                    <div class="w-full bg-white/10 rounded-full h-2 mb-2">
                        @php
                            $progress = [
                                'pending' => 'w-1/5 bg-amber-400',
                                'processing' => 'w-2/5 bg-blue-400',
                                'shipped' => 'w-3/5 bg-purple-400',
                                'delivered' => 'w-full bg-emerald-400',
                                'cancelled' => 'w-0',
                            ];
                        @endphp
                        <div class="h-full rounded-full {{ $progress[$order->status] }}"></div>
                    </div>
                    <p class="text-[10px] text-white/30 font-bold leading-tight">يمكنك تحديث الحالة من القائمة العلوية لتتبع مسار الطلب.</p>
                </div>
                <i class="fas fa-box absolute -bottom-4 -left-4 text-8xl text-white/5 opacity-20"></i>
            </div>
        </div>
    </div>
</div>
@endsection
