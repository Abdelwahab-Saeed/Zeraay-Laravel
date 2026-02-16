@extends('admin.layouts.app')

@section('title', 'المحادثات')

@section('content')
<div class="mb-8 animate-fade-in">
    <h2 class="text-3xl font-bold text-slate-800">المحادثات</h2>
    <p class="text-slate-500 mt-1">تواصل مع المستخدمين وقدم الدعم الفني.</p>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden animate-fade-in">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[700px] text-right border-collapse">
            <thead>
                <tr class="bg-slate-50/50 text-slate-400 text-sm uppercase tracking-wider border-b border-slate-100">
                    <th class="px-6 py-4 font-semibold">المستخدم</th>
                    <th class="px-6 py-4 font-semibold text-center">آخر رسالة</th>
                    <th class="px-6 py-4 font-semibold text-center">الرسائل غير المقروءة</th>
                    <th class="px-6 py-4 font-semibold text-left">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($chats as $chat)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-primary-start/10 text-primary-start flex items-center justify-center font-bold text-lg">
                                    {{ mb_substr($chat->user->name, 0, 1) }}
                                </div>
                                <div class="mr-3">
                                    <div class="font-bold text-slate-700 group-hover:text-primary-start transition-colors">{{ $chat->user->name }}</div>
                                    <div class="text-xs text-slate-400">{{ $chat->user->phone }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-slate-500 text-sm">
                                {{ $chat->last_message_at ? $chat->last_message_at->diffForHumans() : '---' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($chat->unread_count_admin > 0)
                                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-rose-500 rounded-full">
                                    {{ $chat->unread_count_admin }}
                                </span>
                            @else
                                <span class="text-slate-300 text-sm">لا يوجد</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end">
                                <a href="{{ route('admin.chats.show', $chat->id) }}" class="inline-flex items-center px-4 py-2 bg-slate-50 text-slate-600 hover:bg-primary-start hover:text-white rounded-xl transition-all-300 font-bold text-sm">
                                    <i class="fas fa-comment-alt ml-2"></i> عرض المحادثة
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                            <i class="fas fa-comments text-4xl mb-4 opacity-20"></i>
                            <p>لا توجد محادثات نشطة حالياً</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
