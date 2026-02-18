@extends('admin.layouts.app')

@section('title', 'إدارة الإشعارات')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 animate-fade-in">
    <div>
        <h2 class="text-3xl font-bold text-slate-800">إدارة الإشعارات</h2>
        <p class="text-slate-500 mt-1">عرض تاريخ الإشعارات المرسلة يدوياً للمستخدمين.</p>
    </div>
    <a href="{{ route('admin.notifications.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-primary-start hover:bg-primary-end text-white font-bold rounded-2xl shadow-lg hover:shadow-primary-start/30 transition-all-300">
        <i class="fas fa-paper-plane ml-2"></i> إرسال إشعار جديد
    </a>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden animate-fade-in">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[900px] text-right border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-sm uppercase tracking-wider border-b border-slate-100">
                    <th class="px-6 py-4 font-semibold">#</th>
                    <th class="px-6 py-4 font-semibold">العنوان</th>
                    <th class="px-6 py-4 font-semibold">المحتوى</th>
                    <th class="px-6 py-4 font-semibold">تاريخ الإرسال</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($notifications as $notification)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4 text-slate-400 text-sm">{{ $notification->id }}</td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-700 group-hover:text-primary-start transition-colors whitespace-nowrap">{{ $notification->title }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-sm">
                            <p class="max-w-md">{{ $notification->body }}</p>
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-sm whitespace-nowrap">
                            {{ $notification->created_at->format('Y-m-d H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                            <i class="fas fa-bell-slash text-4xl mb-4 opacity-20"></i>
                            <p>لا توجد إشعارات مرسلة حالياً</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($notifications->hasPages())
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection
