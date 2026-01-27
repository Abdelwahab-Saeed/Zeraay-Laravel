<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>تسجيل الدخول - لوحة التحكم</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Kufi+Arabic:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', 'Noto Kufi Arabic', sans-serif;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6 overflow-hidden relative">
    <!-- Animated Background Blobs -->
    <div class="absolute top-0 -right-4 w-72 h-72 bg-primary-start rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
    <div class="absolute top-0 -left-4 w-72 h-72 bg-primary-end rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-8 left-20 w-72 h-72 bg-secondary-start rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>

    <div class="w-full max-w-md relative z-10 animate-fade-in">
        <div class="glass-card rounded-[40px] shadow-2xl overflow-hidden">
            <div class="card-gradient-primary p-10 text-white text-center relative overflow-hidden">
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4 backdrop-blur-md">
                        <i class="fas fa-shield-halved text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold tracking-tight">لوحة التحكم</h2>
                    <p class="text-white/70 mt-2 font-medium">مرحباً بك مجدداً في زراعي</p>
                </div>
                <!-- Abstract Pattern Over Header -->
                <div class="absolute top-0 left-0 w-full h-full opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
                    </svg>
                </div>
            </div>
            
            <div class="p-10">
                @if(session('success'))
                    <div class="flex items-center p-4 mb-6 text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-100">
                        <i class="fas fa-check-circle ml-3"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="flex items-center p-4 mb-6 text-rose-800 rounded-2xl bg-rose-50 border border-rose-100">
                        <i class="fas fa-exclamation-circle ml-3"></i>
                        <span class="text-sm font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                <form method="POST" novalidate action="{{ route('admin.login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-bold text-slate-700 mb-2">البريد الإلكتروني</label>
                        <div class="relative group">
                            <i class="fas fa-envelope absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary-start transition-colors"></i>
                            <input type="email" 
                                   class="w-full pr-11 pl-4 py-3.5 rounded-2xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none text-sm @error('email') border-rose-500 ring-rose-500/10 @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="admin@zeraay.com" autofocus>
                        </div>
                        @error('email')
                            <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-bold text-slate-700 mb-2">كلمة المرور</label>
                        <div class="relative group">
                            <i class="fas fa-lock absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary-start transition-colors"></i>
                            <input type="password" 
                                   class="w-full pr-11 pl-4 py-3.5 rounded-2xl border border-slate-200 focus:border-primary-start focus:ring-4 focus:ring-primary-start/10 transition-all-300 outline-none text-sm @error('password') border-rose-500 ring-rose-500/10 @enderror" 
                                   id="password" name="password" 
                                   placeholder="••••••••">
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-rose-500 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="relative inline-flex items-center cursor-pointer group">
                            <input type="checkbox" id="remember" name="remember" class="sr-only peer">
                            <div class="w-10 h-5 bg-slate-200 peer-focus:ring-4 peer-focus:ring-primary-start/10 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:right-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-start"></div>
                            <span class="mr-3 text-xs font-bold text-slate-600">تذكرني</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full py-4 bg-primary-start hover:bg-primary-end text-white font-bold rounded-2xl shadow-xl hover:shadow-primary-start/30 transition-all-300 transform hover:-translate-y-1 flex justify-center items-center">
                        <i class="fas fa-sign-in-alt ml-2"></i> تسجيل الدخول
                    </button>
                </form>
            </div>
        </div>
        
        <div class="text-center mt-8 text-slate-400">
            <p class="text-xs font-medium">© 2026 زراعي. جميع الحقوق محفوظة</p>
        </div>
    </div>
</body>
</html>
