@extends('admin.layouts.app')

@section('title', 'إدارة الشركات')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap:4 mb-8 animate-fade-in">
    <div>
        <h2 class="text-3xl font-bold text-slate-800">إدارة الشركات</h2>
        <p class="text-slate-500 mt-1">عرض وتنظيم الشركات المصنعة للمنتجات.</p>
    </div>
    <a href="{{ route('admin.companies.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-primary-start hover:bg-primary-end text-white font-bold rounded-2xl shadow-lg hover:shadow-primary-start/30 transition-all-300">
        <i class="fas fa-plus ml-2"></i> إضافة شركة جديدة
    </a>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden animate-fade-in">
    <div class="overflow-x-auto">
        <table class="w-full text-right border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-sm uppercase tracking-wider border-b border-slate-100">
                    <th class="px-6 py-4 font-semibold">#</th>
                    <th class="px-6 py-4 font-semibold text-center">الشعار</th>
                    <th class="px-6 py-4 font-semibold">الاسم</th>
                    <th class="px-6 py-4 font-semibold">الوصف</th>
                    <th class="px-6 py-4 font-semibold text-left">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($companies as $company)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4 text-slate-400 text-sm">{{ $company->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center">
                                @if($company->logo)
                                    <div class="w-12 h-12 rounded-xl overflow-hidden shadow-sm ring-2 ring-white group-hover:ring-slate-100 transition-all">
                                        <img src="{{ asset('storage/' . $company->logo) }}" alt="{{ $company->name }}" class="w-full h-full object-cover">
                                    </div>
                                @else
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400">
                                        <i class="fas fa-building text-xl"></i>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-700 group-hover:text-primary-start transition-colors">{{ $company->name }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-sm max-w-xs">
                            <p class="truncate">{{ $company->description ?: 'لا يوجد وصف' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.companies.edit', $company) }}" class="p-2 text-amber-500 hover:bg-amber-50 rounded-xl transition-all-300" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.companies.destroy', $company) }}" method="POST" novalidate class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-rose-500 hover:bg-rose-50 rounded-xl transition-all-300" 
                                            data-confirm data-confirm-title="حذف الشركة" 
                                            data-confirm-message="هل أنت متأكد من رغبتك في حذف شركة '{{ $company->name }}'؟" 
                                            title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                            <i class="fas fa-building text-4xl mb-4 opacity-20"></i>
                            <p>لا توجد شركات حالياً</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($companies->hasPages())
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
            {{ $companies->links() }}
        </div>
    @endif
</div>
@endsection
