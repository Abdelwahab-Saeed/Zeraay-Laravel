@extends('admin.layouts.app')

@section('title', 'محادثة: ' . $chat->user->name)

@section('content')
<div class="mb-8 animate-fade-in flex items-center justify-between">
    <div>
        <a href="{{ route('admin.chats.index') }}" class="text-slate-500 hover:text-primary-start transition-colors mb-2 inline-flex items-center text-sm font-medium">
            <i class="fas fa-arrow-right ml-2 text-xs"></i> العودة للمحادثات
        </a>
        <h2 class="text-3xl font-bold text-slate-800">{{ $chat->user->name }}</h2>
        <p class="text-slate-500 mt-1">تواصل مياشر مع العميل.</p>
    </div>
    <div class="flex items-center space-x-4 rtl:space-x-reverse">
        <div class="text-left rtl:text-right">
            <p class="text-sm font-bold text-slate-700">{{ $chat->user->phone }}</p>
            <p class="text-xs text-slate-400">{{ $chat->user->email }}</p>
        </div>
        <div class="w-12 h-12 rounded-full bg-primary-start/10 text-primary-start flex items-center justify-center font-bold text-xl uppercase">
            {{ mb_substr($chat->user->name, 0, 1) }}
        </div>
    </div>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 flex flex-col h-[calc(100vh-280px)] min-h-[500px] animate-fade-in">
    
    <!-- Messages Body -->
    <div class="flex-1 overflow-y-auto p-6 space-y-4" id="messageContainer">
        @forelse($messages as $message)
            <div class="{{ $message->sender_type === 'admin' ? 'flex justify-start' : 'flex justify-end' }}">
                <div class="{{ $message->sender_type === 'admin' 
                    ? 'bg-slate-100 text-slate-700 rounded-2xl rounded-tr-none px-4 py-3 max-w-[70%] shadow-sm' 
                    : 'bg-primary-start text-white rounded-2xl rounded-tl-none px-4 py-3 max-w-[70%] shadow-md' }}">
                    
                    @if($message->message_type === 'text')
                        <p class="text-sm leading-relaxed">{{ $message->content }}</p>
                    @elseif($message->message_type === 'image')
                        <div class="rounded-lg overflow-hidden border border-white/10">
                            <img src="{{ $message->content }}" class="max-w-full h-auto cursor-pointer" onclick="window.open(this.src, '_blank')">
                        </div>
                    @elseif($message->message_type === 'file')
                        <a href="{{ $message->content }}" target="_blank" class="flex items-center text-sm hover:underline">
                            <i class="fas fa-file-download ml-2 text-xs"></i>
                            <span>{{ basename($message->content) }}</span>
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
    <div class="p-6 bg-slate-50/50 border-t border-slate-100">
        <form action="{{ route('admin.chats.store', $chat->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Hidden Input for Message Type -->
            <input type="hidden" name="message_type" value="text" id="message_type">

            <div class="flex items-end gap-3 bg-white p-2 rounded-2xl border border-slate-200 shadow-sm focus-within:border-primary-start transition-all">
                
                <!-- Attachment Button -->
                <button type="button" onclick="document.getElementById('fileInput').click()" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-primary-start hover:bg-slate-50 rounded-xl transition-all">
                    <i class="fas fa-paperclip text-lg"></i>
                </button>
                <input type="file" name="file" id="fileInput" class="hidden" onchange="handleFileSelected(this)">

                <!-- Textarea -->
                <textarea name="message" 
                          class="flex-1 bg-transparent border-none focus:ring-0 text-slate-700 resize-none py-2 px-1 text-sm placeholder:text-slate-400" 
                          placeholder="اكتب رسالتك هنا..." 
                          rows="1"></textarea>

                <!-- Send Button -->
                <button type="submit" class="w-10 h-10 flex items-center justify-center text-white bg-primary-start hover:shadow-lg shadow-primary-start/20 rounded-xl transition-all-300">
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
        }
    }

    function clearFile() {
        document.getElementById('fileInput').value = '';
        document.getElementById('filePreview').classList.add('hidden');
        document.getElementById('message_type').value = 'text';
    }
</script>
@endsection
