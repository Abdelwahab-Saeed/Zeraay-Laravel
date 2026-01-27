@extends('admin.layouts.app')

@section('title', 'المستخدمين')

@section('content')
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 animate-fade-in">
    <div>
        <h2 class="text-3xl font-bold text-slate-800">إدارة المستخدمين</h2>
        <p class="text-slate-500 mt-1">عرض وإدارة كافة المستخدمين المسجلين في النظام.</p>
    </div>
</div>

<!-- Search Section -->
<div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 mb-8 animate-fade-in">
    <form method="GET" action="{{ route('admin.users.index') }}">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative group">
                <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary-start transition-colors"></i>
                <input type="text" name="search" 
                       class="w-full pr-11 pl-4 py-3 rounded-xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none text-sm" 
                       placeholder="البحث بالاسم، البريد الإلكتروني، أو رقم الهاتف..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="md:w-32 py-3 bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-xl transition-all-300 flex items-center justify-center shadow-lg hover:shadow-slate-800/20">
                <i class="fas fa-search ml-2 text-xs"></i> بحث
            </button>
        </div>
    </form>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden animate-fade-in">
    <div class="overflow-x-auto">
        <table class="w-full text-right border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-sm uppercase tracking-wider border-b border-slate-100">
                    <th class="px-6 py-4 font-semibold">#</th>
                    <th class="px-6 py-4 font-semibold">المستخدم</th>
                    <th class="px-6 py-4 font-semibold">الهاتف</th>
                    <th class="px-6 py-4 font-semibold">المدينة</th>
                    <th class="px-6 py-4 font-semibold text-center">تاريخ التسجيل</th>
                    <th class="px-6 py-4 font-semibold text-left">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($users as $user)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4 text-slate-400 text-sm font-medium">{{ $user->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 ml-3 group-hover:bg-primary-start/10 group-hover:text-primary-start transition-all">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-slate-700 group-hover:text-primary-start transition-colors">{{ $user->name }}</div>
                                    <div class="text-xs text-slate-400">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 text-sm">{{ $user->phone ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="bg-slate-100 text-slate-600 text-[10px] px-2 py-1 rounded-lg font-bold uppercase tracking-wider">
                                {{ $user->city ?? 'غير محدد' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center text-slate-500 text-sm">
                            {{ $user->created_at->format('Y-m-d') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.users.show', $user) }}" class="p-2 text-primary-start hover:bg-primary-start/10 rounded-xl transition-all-300" title="عرض">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-amber-500 hover:bg-amber-50 rounded-xl transition-all-300" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" novalidate class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-rose-500 hover:bg-rose-50 rounded-xl transition-all-300" 
                                            data-confirm data-confirm-title="حذف المستخدم" 
                                            data-confirm-message="هل أنت متأكد من رغبتك في حذف المستخدم '{{ $user->name }}'؟" 
                                            title="حذف">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                            <i class="fas fa-users-slash text-4xl mb-4 opacity-20"></i>
                            <p>لا يوجد مستخدمين حالياً</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
