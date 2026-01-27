@extends('admin.layouts.app')

@section('title', 'تفاصيل المستخدم')

@section('content')
<div class="max-w-4xl mx-auto animate-fade-in">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <a href="{{ route('admin.users.index') }}" class="text-slate-500 hover:text-primary-start transition-colors mb-4 inline-flex items-center text-sm font-medium">
                <i class="fas fa-arrow-right ml-2 text-xs"></i> العودة للمستخدمين
            </a>
            <h2 class="text-3xl font-bold text-slate-800">تفاصيل المستخدم</h2>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl shadow-lg hover:shadow-amber-500/20 transition-all-300">
                <i class="fas fa-edit ml-2"></i> تعديل المستخدم
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Sidebar: User Snapshot -->
        <div class="md:col-span-1 space-y-8">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 text-center">
                <div class="w-24 h-24 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mx-auto mb-4 border-4 border-slate-50">
                    <i class="fas fa-user text-4xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800">{{ $user->name }}</h3>
                <p class="text-slate-500 text-sm mt-1">{{ $user->email }}</p>
                <div class="mt-6 pt-6 border-t border-slate-50 space-y-4">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-400 font-medium">تاريخ الانضمام</span>
                        <span class="text-slate-700 font-bold">{{ $user->created_at->format('Y-m-d') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-400 font-medium">رقم الهاتف</span>
                        <span class="text-slate-700 font-bold">{{ $user->phone ?: 'غير متاح' }}</span>
                    </div>
                </div>
            </div>

            <!-- Role Card (if applicable) -->
            <div class="bg-slate-900 rounded-3xl shadow-lg p-6 text-white text-center">
                <p class="text-xs text-slate-400 uppercase tracking-widest font-bold mb-2">نوع الحساب</p>
                <div class="text-xl font-bold">
                    @if($user->role === 'admin')
                        <span class="text-rose-400"><i class="fas fa-shield-alt ml-2"></i> مدير النظام</span>
                    @else
                        <span class="text-emerald-400"><i class="fas fa-user ml-2"></i> مستخدم عادي</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Info: Details -->
        <div class="md:col-span-2 space-y-8">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
                <h4 class="text-lg font-bold text-slate-800 mb-8 flex items-center">
                    <i class="fas fa-address-card ml-3 text-primary-start"></i> المعلومات التفصيلية
                </h4>
                
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-xs text-slate-400 font-bold uppercase tracking-wider mb-2">المحافظة</label>
                            <p class="text-slate-700 font-bold bg-slate-50 px-4 py-3 rounded-xl border border-slate-100">{{ $user->state ?: '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-400 font-bold uppercase tracking-wider mb-2">المدينة</label>
                            <p class="text-slate-700 font-bold bg-slate-50 px-4 py-3 rounded-xl border border-slate-100">{{ $user->city ?: '-' }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs text-slate-400 font-bold uppercase tracking-wider mb-2">العنوان الكامل</label>
                        <p class="text-slate-700 font-bold bg-slate-50 px-4 py-3 rounded-xl border border-slate-100">{{ $user->address ?: '-' }}</p>
                    </div>

                    @if($user->engineer_code)
                        <div>
                            <label class="block text-xs text-slate-400 font-bold uppercase tracking-wider mb-2">كود المهندس</label>
                            <div class="flex items-center gap-3">
                                <span class="bg-primary-start text-white text-sm font-bold px-4 py-2 rounded-xl shadow-lg shadow-primary-start/20">
                                    {{ $user->engineer_code }}
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Activity Info -->
            <div class="bg-slate-50 rounded-3xl border border-slate-100 p-8 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-white shadow-sm flex items-center justify-center text-slate-400 border border-slate-100">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">آخر تحديث للبيانات</p>
                        <p class="text-slate-700 font-bold">{{ $user->updated_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>
                <div class="hidden md:block">
                    <i class="fas fa-chevron-left text-slate-200 text-xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
