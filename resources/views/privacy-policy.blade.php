<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('landing.app_name') }} - {{ __('landing.nav.privacy_policy') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @if(app()->getLocale() == 'ar')
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    @else
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    @endif

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .privacy-content {
            padding: 120px 0 80px;
        }
        .policy-section {
            margin-bottom: 40px;
        }
        .policy-section h2 {
            color: var(--primary-color);
            margin-bottom: 20px;
            font-size: 1.8rem;
        }
        .policy-section p {
            line-height: 1.8;
            color: #555;
            white-space: pre-wrap;
        }
        .back-home {
            display: inline-flex;
            items-center;
            margin-bottom: 30px;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }
        .back-home i {
            margin: 0 5px;
        }
    </style>
</head>
<body>
    <!-- Navbar (Simplified) -->
    <nav class="navbar forced-scrolled">
        <div class="container">
            <a href="{{ route('landing') }}" class="logo">{{ __('landing.app_name') }}</a>
            <ul class="nav-links">
                <li><a href="{{ route('landing') }}#home">{{ __('landing.nav.home') }}</a></li>
                <li class="lang-switcher">
                    @if(app()->getLocale() == 'en')
                        <a href="{{ route('lang.switch', 'ar') }}">العربية</a>
                    @else
                        <a href="{{ route('lang.switch', 'en') }}">English</a>
                    @endif
                </li>
            </ul>
        </div>
    </nav>

    <div class="container privacy-content">
        <a href="{{ route('landing') }}" class="back-home">
            @if(app()->getLocale() == 'ar')
                <i class="fas fa-arrow-right"></i> العودة للرئيسية
            @else
                <i class="fas fa-arrow-left"></i> Back to Home
            @endif
        </a>

        <h1 class="section-header" style="text-align: {{ app()->getLocale() == 'ar' ? 'right' : 'left' }}; margin-bottom: 50px;">
            {{ __('landing.nav.privacy_policy') }}
        </h1>

        <div class="privacy-sections">
            @forelse($privacyPolicies as $policy)
                <div class="policy-section">
                    <h2>{{ $policy->title }}</h2>
                    <p>{{ $policy->content }}</p>
                </div>
            @empty
                <p class="text-center">{{ app()->getLocale() == 'ar' ? 'سيتم إضافة المحتوى قريباً.' : 'Content will be added soon.' }}</p>
            @endforelse
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <p> {{ __('landing.footer.rights') }} </p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/landing.js') }}"></script>
</body>
</html>
