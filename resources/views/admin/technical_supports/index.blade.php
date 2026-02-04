@extends('admin.layouts.app')

@section('title', 'إدارة الدعم الفني')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 animate-fade-in">
    <div>
        <h2 class="text-3xl font-bold text-slate-800">إدارة الدعم الفني</h2>
        <p class="text-slate-500 mt-1">عرض وتنظيم مسؤولي الدعم الفني.</p>
    </div>
    <a href="{{ route('admin.technical_supports.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-primary-start hover:bg-primary-end text-white font-bold rounded-2xl shadow-lg hover:shadow-primary-start/30 transition-all-300">
        <i class="fas fa-plus ml-2"></i> إضافة مسؤول جديد
    </a>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden animate-fade-in">
    <div class="overflow-x-auto">
        <table class="w-full text-right border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-sm uppercase tracking-wider border-b border-slate-100">
                    <th class="px-6 py-4 font-semibold">#</th>
                    <th class="px-6 py-4 font-semibold">الاسم</th>
                    <th class="px-6 py-4 font-semibold text-center">رقم الهاتف</th>
                    <th class="px-6 py-4 font-semibold text-left">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($technicalSupports as $support)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4 text-slate-400 text-sm">{{ $support->id }}</td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-700 group-hover:text-primary-start transition-colors">{{ $support->name }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="tel:{{ $support->phone }}" class="text-slate-500 hover:text-primary-start transition-colors">
                                {{ $support->phone }}
                                <i class="fas fa-phone mr-2 text-xs opacity-50"></i>
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.technical_supports.edit', $support) }}" class="p-2 text-amber-500 hover:bg-amber-50 rounded-xl transition-all-300" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.technical_supports.destroy', $support) }}" method="POST" novalidate class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-rose-500 hover:bg-rose-50 rounded-xl transition-all-300" 
                                            data-confirm data-confirm-title="حذف مسؤول الدعم" 
                                            data-confirm-message="هل أنت متأكد من رغبتك في حذف المسؤول '{{ $support->name }}'؟" 
                                            title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                            <i class="fas fa-headset text-4xl mb-4 opacity-20"></i>
                            <p>لا يوجد مسؤولو دعم حالياً</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($technicalSupports->hasPages())
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
            {{ $technicalSupports->links() }}
        </div>
    @endif
</div>
@endsection
