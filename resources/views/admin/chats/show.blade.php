@extends('admin.layouts.app')

@section('title', 'محادثة: ' . $chat->user->name)

@section('content')
<div class="mb-6 animate-fade-in flex flex-col lg:flex-row lg:items-center justify-between gap-6 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
    <div class="flex flex-col items-center lg:items-start text-center lg:text-right">
        <a href="{{ route('admin.chats.index') }}" class="text-slate-500 hover:text-primary-start transition-colors mb-3 inline-flex items-center text-xs font-semibold bg-slate-50 px-3 py-1.5 rounded-lg group">
            <i class="fas fa-arrow-right ml-2 text-[10px] group-hover:-translate-x-1 transition-transform"></i> العودة للمحادثات
        </a>
        <h2 class="text-2xl lg:text-3xl font-black text-slate-800 tracking-tight">{{ $chat->user->name }}</h2>
        <p class="text-slate-500 mt-1 text-sm font-medium">تواصل مباشر مع العميل والدعم الفني</p>
    </div>
    <div class="flex items-center justify-center lg:justify-end gap-4 rtl:flex-row-reverse sm:rtl:flex-row border-t lg:border-t-0 pt-4 lg:pt-0 border-slate-50">
        <div class="text-center lg:text-left rtl:text-right">
            <p class="text-sm lg:text-base font-bold text-slate-700 tracking-wide">{{ $chat->user->phone }}</p>
            <p class="text-xs text-slate-400 font-medium">{{ $chat->user->email }}</p>
        </div>
        <div class="w-12 h-12 lg:w-16 lg:h-16 rounded-2xl bg-gradient-to-br from-primary-start/20 to-primary-end/5 text-primary-start flex items-center justify-center font-black text-xl lg:text-2xl uppercase shadow-inner border border-primary-start/10">
            {{ mb_substr($chat->user->name, 0, 1) }}
        </div>
    </div>
</div>

<div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 flex flex-col h-[calc(100vh-220px)] sm:h-[calc(100vh-320px)] min-h-[450px] lg:min-h-[600px] animate-fade-in overflow-hidden">
    
    <!-- Messages Body -->
    <div class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-4" id="messageContainer">
        @forelse($messages as $message)
            <div class="{{ $message->sender_type === 'admin' ? 'flex justify-start' : 'flex justify-end' }}">
                <div class="{{ $message->sender_type === 'admin' 
                    ? 'bg-slate-100 text-slate-700 rounded-3xl rounded-tr-none px-5 py-3.5 max-w-[85%] lg:max-w-[65%] shadow-sm' 
                    : 'bg-primary-start text-white rounded-3xl rounded-tl-none px-5 py-3.5 max-w-[85%] lg:max-w-[65%] shadow-lg shadow-primary-start/10' }}">
                    
                    @if($message->message_type === 'text')
                        <p class="text-sm leading-relaxed">{{ $message->content }}</p>
                    @elseif($message->message_type === 'image')
                        <div class="rounded-2xl overflow-hidden border border-white/10 shadow-sm max-w-[280px] sm:max-w-[400px]">
                            <img src="{{ $message->content }}" class="w-full h-auto cursor-pointer hover:scale-105 transition-transform duration-500" onclick="window.open(this.src, '_blank')">
                        </div>
                    @elseif($message->message_type === 'file')
                        <a href="{{ $message->content }}" target="_blank" class="flex items-center text-sm hover:underline py-1 group">
                            <i class="fas fa-file-download ml-2 text-xs opacity-70 group-hover:opacity-100"></i>
                            <span class="break-all">{{ basename($message->content) }}</span>
                        </a>
                    @endif

                    <div class="{{ $message->sender_type === 'admin' ? 'text-slate-400' : 'text-white/60' }} text-[10px] mt-2 font-medium">
                        {{ $message->created_at->format('H:i - Y/m/d') }}
                    </div>
                </div>
            </div>
        @empty
            <div class="h-full flex flex-col items-center justify-center text-slate-400 opacity-50">
                <i class="fas fa-comments text-6xl mb-4"></i>
                <p>لا يوجد رسائل في هذه المحادثة بعد.</p>
            </div>
        @endforelse
    </div>

    <!-- Toolbar/Input Area -->
    <div class="p-4 lg:p-8 bg-slate-50/80 border-t border-slate-100 backdrop-blur-sm">
        <form action="{{ route('admin.chats.store', $chat->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Hidden Input for Message Type -->
            <input type="hidden" name="message_type" value="text" id="message_type">

            <div class="flex items-end gap-3 bg-white p-2 lg:p-3 rounded-[2rem] border border-slate-200 shadow-sm focus-within:border-primary-start focus-within:ring-4 focus-within:ring-primary-start/5 transition-all duration-300">
                
                <!-- Attachment Button -->
                <button type="button" onclick="document.getElementById('fileInput').click()" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-primary-start hover:bg-slate-50 rounded-xl transition-all">
                    <i class="fas fa-paperclip text-lg"></i>
                </button>
                <input type="file" name="file" id="fileInput" class="hidden" onchange="handleFileSelected(this)">

                <!-- Textarea -->
                <textarea name="message" id="messageTextarea"
                          class="flex-1 bg-transparent border-none focus:ring-0 text-slate-700 resize-none py-2 px-1 text-sm placeholder:text-slate-400" 
                          placeholder="اكتب رسالتك هنا..." 
                          rows="1" oninput="toggleSendButton()"></textarea>

                <!-- Send Button -->
                <button type="submit" id="sendButton" disabled
                        class="w-10 h-10 flex items-center justify-center text-white bg-primary-start hover:shadow-lg shadow-primary-start/20 rounded-xl transition-all-300 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-paper-plane text-sm transform rtl:rotate-180"></i>
                </button>
            </div>

            <!-- File Preview Info -->
            <div id="filePreview" class="hidden mt-3 flex items-center bg-slate-100 p-2 rounded-xl text-xs text-slate-600">
                <i class="fas fa-file-alt mr-2 text-primary-start"></i>
                <span id="fileName" class="flex-1 truncate"></span>
                <button type="button" onclick="clearFile()" class="text-rose-500 hover:bg-rose-50 p-1 rounded-lg">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Scroll to bottom immediately
    window.onload = function() {
        const container = document.getElementById('messageContainer');
        container.scrollTop = container.scrollHeight;
    };

    function handleFileSelected(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            document.getElementById('fileName').textContent = file.name;
            document.getElementById('filePreview').classList.remove('hidden');
            
            // Set message type based on extension
            const isImage = file.type.startsWith('image/');
            document.getElementById('message_type').value = isImage ? 'image' : 'file';
            toggleSendButton();
        }
    }

    function clearFile() {
        document.getElementById('fileInput').value = '';
        document.getElementById('filePreview').classList.add('hidden');
        document.getElementById('message_type').value = 'text';
        toggleSendButton();
    }

    function toggleSendButton() {
        const textarea = document.getElementById('messageTextarea');
        const fileInput = document.getElementById('fileInput');
        const sendButton = document.getElementById('sendButton');
        
        const hasText = textarea.value.trim().length > 0;
        const hasFile = fileInput.files && fileInput.files.length > 0;
        
        sendButton.disabled = !(hasText || hasFile);
    }
</script>
@endsection
