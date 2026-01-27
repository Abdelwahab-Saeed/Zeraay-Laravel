@extends('admin.layouts.app')

@section('title', 'إدارة الكوبونات')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 animate-fade-in">
    <div>
        <h2 class="text-3xl font-bold text-slate-800">إدارة الكوبونات</h2>
        <p class="text-slate-500 mt-1">عرض وتنظيم أكواد الخصم المتاحة للمستخدمين.</p>
    </div>
    <a href="{{ route('admin.coupons.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-primary-start hover:bg-primary-end text-white font-bold rounded-2xl shadow-lg hover:shadow-primary-start/30 transition-all-300">
        <i class="fas fa-plus ml-2"></i> إضافة كوبون جديد
    </a>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden animate-fade-in">
    <div class="overflow-x-auto">
        <table class="w-full text-right border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-sm uppercase tracking-wider border-b border-slate-100">
                    <th class="px-6 py-4 font-semibold">الكود</th>
                    <th class="px-6 py-4 font-semibold">النوع</th>
                    <th class="px-6 py-4 font-semibold text-center">القيمة</th>
                    <th class="px-6 py-4 font-semibold text-center">الحد الأدنى</th>
                    <th class="px-6 py-4 font-semibold text-center">ينتهي في</th>
                    <th class="px-6 py-4 font-semibold text-center">الحالة</th>
                    <th class="px-6 py-4 font-semibold text-left">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($coupons as $coupon)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-700 group-hover:text-primary-start transition-colors uppercase">{{ $coupon->code }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-sm">
                            {{ $coupon->type === 'percent' ? 'نسبة مئوية' : 'مبلغ ثابت' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-emerald-50 text-emerald-600 text-xs px-2.5 py-1 rounded-lg font-bold">
                                {{ $coupon->value }} {{ $coupon->type === 'percent' ? '%' : 'ج.م' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center text-slate-600 font-medium">
                            {{ $coupon->min_purchase ?: '0' }} ج.م
                        </td>
                        <td class="px-6 py-4 text-center text-slate-500 text-xs">
                            {{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : 'دائم' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center">
                                @if($coupon->status)
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
                                <a href="{{ route('admin.coupons.edit', $coupon) }}" class="p-2 text-amber-500 hover:bg-amber-50 rounded-xl transition-all-300" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" novalidate class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-rose-500 hover:bg-rose-50 rounded-xl transition-all-300" 
                                            data-confirm data-confirm-title="حذف الكوبون" 
                                            data-confirm-message="هل أنت متأكد من رغبتك في حذف الكوبون '{{ $coupon->code }}'؟" 
                                            title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                            <i class="fas fa-ticket-alt text-4xl mb-4 opacity-20"></i>
                            <p>لا توجد كوبونات حالياً</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($coupons->hasPages())
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
            {{ $coupons->links() }}
        </div>
    @endif
</div>
@endsection
