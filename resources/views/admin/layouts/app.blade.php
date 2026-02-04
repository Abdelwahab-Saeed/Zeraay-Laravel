<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'لوحة التحكم')</title>
    
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
    </style>
    
    @yield('styles')
</head>
<body class="bg-slate-50 text-slate-900 overflow-x-hidden">
    <!-- Mobile Header -->
    <header class="block lg:hidden bg-white border-b border-slate-200 px-4 py-3 sticky top-0 z-50">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold bg-gradient-to-r from-primary-start to-primary-end bg-clip-text text-transparent">زراعي</h1>
            <button id="mobile-menu-toggle" class="p-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-colors">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>
    </header>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 right-0 z-40 w-64 bg-sidebar-gradient text-white transform translate-x-full lg:translate-x-0 lg:static transition-transform duration-300 ease-in-out shadow-2xl lg:shadow-none">
            <div class="p-6">
                <div class="text-center mb-8">
                    <h1 class="text-2xl font-bold tracking-tight">لوحة التحكم</h1>
                    <div class="h-1 w-12 bg-white/30 rounded-full mx-auto mt-2"></div>
                </div>
                
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-4 py-3 rounded-xl transition-all-300 {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white shadow-lg' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-home w-6 text-lg {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-white/50' }}"></i>
                        <span class="mr-3 font-medium">الرئيسية</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}" 
                       class="flex items-center px-4 py-3 rounded-xl transition-all-300 {{ request()->routeIs('admin.categories.*') ? 'bg-white/20 text-white shadow-lg' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-folder w-6 text-lg {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-white/50' }}"></i>
                        <span class="mr-3 font-medium">الفئات</span>
                    </a>

                    <a href="{{ route('admin.companies.index') }}" 
                       class="flex items-center px-4 py-3 rounded-xl transition-all-300 {{ request()->routeIs('admin.companies.*') ? 'bg-white/20 text-white shadow-lg' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-building w-6 text-lg {{ request()->routeIs('admin.companies.*') ? 'text-white' : 'text-white/50' }}"></i>
                        <span class="mr-3 font-medium">الشركات</span>
                    </a>

                    <a href="{{ route('admin.products.index') }}" 
                       class="flex items-center px-4 py-3 rounded-xl transition-all-300 {{ request()->routeIs('admin.products.*') && !request()->routeIs('admin.products.stock') ? 'bg-white/20 text-white shadow-lg' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-box w-6 text-lg {{ request()->routeIs('admin.products.*') && !request()->routeIs('admin.products.stock') ? 'text-white' : 'text-white/50' }}"></i>
                        <span class="mr-3 font-medium">المنتجات</span>
                    </a>

                    <a href="{{ route('admin.products.stock') }}" 
                       class="flex items-center px-4 py-3 rounded-xl transition-all-300 {{ request()->routeIs('admin.products.stock') ? 'bg-white/20 text-white shadow-lg' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-warehouse w-6 text-lg {{ request()->routeIs('admin.products.stock') ? 'text-white' : 'text-white/50' }}"></i>
                        <span class="mr-3 font-medium">إدارة المخزون</span>
                    </a>

                    <a href="{{ route('admin.users.index') }}" 
                       class="flex items-center px-4 py-3 rounded-xl transition-all-300 {{ request()->routeIs('admin.users.*') ? 'bg-white/20 text-white shadow-lg' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-users w-6 text-lg {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-white/50' }}"></i>
                        <span class="mr-3 font-medium">المستخدمون</span>
                    </a>

                    <a href="{{ route('admin.orders.index') }}" 
                       class="flex items-center px-4 py-3 rounded-xl transition-all-300 {{ request()->routeIs('admin.orders.*') ? 'bg-white/20 text-white shadow-lg' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-shopping-cart w-6 text-lg {{ request()->routeIs('admin.orders.*') ? 'text-white' : 'text-white/50' }}"></i>
                        <span class="mr-3 font-medium">الطلبات</span>
                    </a>

                    <a href="{{ route('admin.coupons.index') }}" 
                       class="flex items-center px-4 py-3 rounded-xl transition-all-300 {{ request()->routeIs('admin.coupons.*') ? 'bg-white/20 text-white shadow-lg' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-tag w-6 text-lg {{ request()->routeIs('admin.coupons.*') ? 'text-white' : 'text-white/50' }}"></i>
                        <span class="mr-3 font-medium">الكوبونات</span>
                    </a>

                    <a href="{{ route('admin.payment_methods.index') }}" 
                       class="flex items-center px-4 py-3 rounded-xl transition-all-300 {{ request()->routeIs('admin.payment_methods.*') ? 'bg-white/20 text-white shadow-lg' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-credit-card w-6 text-lg {{ request()->routeIs('admin.payment_methods.*') ? 'text-white' : 'text-white/50' }}"></i>
                        <span class="mr-3 font-medium">وسائل الدفع</span>
                    </a>

                    <a href="{{ route('admin.technical_supports.index') }}" 
                       class="flex items-center px-4 py-3 rounded-xl transition-all-300 {{ request()->routeIs('admin.technical_supports.*') ? 'bg-white/20 text-white shadow-lg' : 'text-white/70 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas fa-headset w-6 text-lg {{ request()->routeIs('admin.technical_supports.*') ? 'text-white' : 'text-white/50' }}"></i>
                        <span class="mr-3 font-medium">الدعم الفني</span>
                    </a>

                    <div class="pt-6 mt-6 border-t border-white/10">
                        <form action="{{ route('admin.logout') }}" method="POST" novalidate>
                            @csrf
                            <button type="submit" class="flex items-center w-full px-4 py-3 rounded-xl text-rose-300 hover:bg-rose-500/20 transition-all-300"
                                    data-confirm data-confirm-title="تسجيل الخروج" 
                                    data-confirm-message="هل أنت متأكد من رغبتك في تسجيل الخروج؟" 
                                    data-confirm-btn="خروج" data-confirm-type="info">
                                <i class="fas fa-sign-out-alt w-6 text-lg opacity-70"></i>
                                <span class="mr-3 font-medium">تسجيل الخروج</span>
                            </button>
                        </form>
                    </div>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 w-full bg-slate-50 lg:px-8 px-4 py-8">
            <div class="max-w-7xl mx-auto">
                {{-- Flash Messages --}}
                @if(session('success'))
                    <div id="alert-success" class="flex items-center p-4 mb-6 text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-100 animate-fade-in">
                        <i class="fas fa-check-circle text-lg ml-3"></i>
                        <div class="text-sm font-medium">
                            {{ session('success') }}
                        </div>
                        <button type="button" onclick="document.getElementById('alert-success').remove()" class="mr-auto text-emerald-500 hover:text-emerald-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div id="alert-error" class="flex items-center p-4 mb-6 text-rose-800 rounded-2xl bg-rose-50 border border-rose-100 animate-fade-in">
                        <i class="fas fa-exclamation-circle text-lg ml-3"></i>
                        <div class="text-sm font-medium">
                            {{ session('error') }}
                        </div>
                        <button type="button" onclick="document.getElementById('alert-error').remove()" class="mr-auto text-rose-500 hover:text-rose-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Mobile Menu Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-30 hidden lg:hidden"></div>

    <!-- Global Confirmation Modal -->
    <div id="confirm-modal" class="fixed inset-0 z-[100] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background Overlay -->
            <div id="modal-overlay" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity opacity-0" aria-hidden="true text-center"></div>

            <!-- Modal Panel -->
            <div id="modal-panel" class="inline-block align-bottom bg-white rounded-[40px] text-right overflow-hidden shadow-2xl transform transition-all-300 opacity-0 scale-95 sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-8 pt-10 pb-8">
                    <div class="sm:flex sm:items-start">
                        <div id="modal-icon-container" class="mx-auto flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-3xl bg-rose-50 sm:mx-0 sm:h-14 sm:w-14">
                            <i id="modal-icon" class="fas fa-exclamation-triangle text-2xl text-rose-500"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:mr-6 sm:text-right">
                            <h3 class="text-2xl font-black text-slate-800" id="modal-title">تأكيد الإجراء</h3>
                            <div class="mt-4">
                                <p class="text-slate-500 font-medium leading-relaxed" id="modal-message">هل أنت متأكد من رغبتك في تنفيذ هذا الإجراء؟ لا يمكن التراجع عنه.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50/50 px-8 py-6 sm:flex sm:flex-row-reverse gap-3">
                    <button id="modal-confirm-btn" type="button" class="w-full inline-flex justify-center rounded-2xl border border-transparent shadow-lg px-8 py-3 bg-rose-600 text-base font-bold text-white hover:bg-rose-700 transition-all-300 sm:w-auto sm:text-sm">
                        تأكيد الحذف
                    </button>
                    <button id="modal-cancel-btn" type="button" class="mt-3 w-full inline-flex justify-center rounded-2xl border border-slate-200 shadow-sm px-8 py-3 bg-white text-base font-bold text-slate-600 hover:bg-slate-50 transition-all-300 sm:mt-0 sm:w-auto sm:text-sm">
                        إلغاء
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const toggle = document.getElementById('mobile-menu-toggle');

        function toggleMenu() {
            sidebar.classList.toggle('translate-x-full');
            overlay.classList.toggle('hidden');
            document.body.classList.toggle('overflow-hidden');
        }

        if (toggle && sidebar && overlay) {
            toggle.addEventListener('click', toggleMenu);
            overlay.addEventListener('click', toggleMenu);
        }

        // --- Custom Modal Logic ---
        const confirmModal = document.getElementById('confirm-modal');
        const modalOverlay = document.getElementById('modal-overlay');
        const modalPanel = document.getElementById('modal-panel');
        const modalConfirmBtn = document.getElementById('modal-confirm-btn');
        const modalCancelBtn = document.getElementById('modal-cancel-btn');
        const modalTitle = document.getElementById('modal-title');
        const modalMessage = document.getElementById('modal-message');
        const modalIcon = document.getElementById('modal-icon');
        const modalIconContainer = document.getElementById('modal-icon-container');

        let pendingForm = null;

        function showConfirmModal(options) {
            modalTitle.innerText = options.title || 'تأكيد الإجراء';
            modalMessage.innerText = options.message || 'هل أنت متأكد؟';
            modalConfirmBtn.innerText = options.confirmText || 'تأكيد';
            
            // Adjust colors based on type
            if (options.type === 'danger') {
                modalConfirmBtn.className = modalConfirmBtn.className.replace(/bg-\w+-600/g, 'bg-rose-600').replace(/hover:bg-\w+-700/g, 'hover:bg-rose-700');
                modalIcon.className = 'fas fa-trash-alt text-2xl text-rose-500';
                modalIconContainer.className = modalIconContainer.className.replace(/bg-\w+-50/g, 'bg-rose-50');
            } else {
                modalConfirmBtn.className = modalConfirmBtn.className.replace(/bg-\w+-600/g, 'bg-primary-start').replace(/hover:bg-\w+-700/g, 'hover:bg-primary-end');
                modalIcon.className = 'fas fa-info-circle text-2xl text-primary-start';
                modalIconContainer.className = modalIconContainer.className.replace(/bg-\w+-50/g, 'bg-primary-start/10');
            }

            confirmModal.classList.remove('hidden');
            setTimeout(() => {
                modalOverlay.classList.replace('opacity-0', 'opacity-100');
                modalPanel.classList.replace('opacity-0', 'opacity-100');
                modalPanel.classList.replace('scale-95', 'scale-100');
            }, 10);

            pendingForm = options.form || null;
        }

        function closeConfirmModal() {
            modalOverlay.classList.replace('opacity-100', 'opacity-0');
            modalPanel.classList.replace('opacity-100', 'opacity-0');
            modalPanel.classList.replace('scale-100', 'scale-95');
            setTimeout(() => {
                confirmModal.classList.add('hidden');
            }, 300);
        }

        modalCancelBtn.addEventListener('click', closeConfirmModal);
        modalConfirmBtn.addEventListener('click', () => {
            if (pendingForm) pendingForm.submit();
            closeConfirmModal();
        });

        // Global listener for data-confirm buttons
        document.addEventListener('click', function(e) {
            const confirmBtn = e.target.closest('[data-confirm]');
            if (confirmBtn) {
                e.preventDefault();
                const form = confirmBtn.closest('form');
                showConfirmModal({
                    title: confirmBtn.getAttribute('data-confirm-title') || 'تأكيد الحذف',
                    message: confirmBtn.getAttribute('data-confirm-message') || 'هل أنت متأكد من رغبتك في حذف هذا العنصر؟',
                    confirmText: confirmBtn.getAttribute('data-confirm-btn') || 'حذف الآن',
                    type: confirmBtn.getAttribute('data-confirm-type') || 'danger',
                    form: form
                });
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html>
