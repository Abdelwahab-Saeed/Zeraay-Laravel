<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('landing.app_name') }} - {{ __('landing.hero.title') }}</title>
    
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
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <a href="#home" class="logo">{{ __('landing.app_name') }}</a>
            <ul class="nav-links">
                <li><a href="#home">{{ __('landing.nav.home') }}</a></li>
                <li><a href="#about">{{ __('landing.nav.about') }}</a></li>
                <li><a href="#products">{{ __('landing.nav.products') }}</a></li>
                <li><a href="#why-us">{{ __('landing.nav.why_us') }}</a></li>
                <li><a href="#contact">{{ __('landing.nav.contact') }}</a></li>
                <li class="lang-switcher">
                    @if(app()->getLocale() == 'en')
                        <a href="{{ route('lang.switch', 'ar') }}">العربية</a>
                    @else
                        <a href="{{ route('lang.switch', 'en') }}">English</a>
                    @endif
                </li>
            </ul>
            <div class="menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero" style="background-image: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('{{ asset('assets/landing/hero_bg.png') }}');">
        <div class="container">
            <div class="hero-content">
                <h1>{{ __('landing.hero.title') }}</h1>
                <p>{{ __('landing.hero.subtitle') }}</p>
                <div class="hero-btns">
                    <a href="#home" class="btn btn-primary">{{ __('landing.hero.cta_app') }}</a>
                    <a href="#products" class="btn btn-secondary">{{ __('landing.hero.cta_order') }}</a>
                    <a href="#contact" class="btn btn-outline">{{ __('landing.hero.cta_contact') }}</a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about section">
        <div class="container">
            <div class="section-header">
                <h2>{{ __('landing.about.title') }}</h2>
            </div>
            <div class="about-grid">
                <div class="about-text">
                    <p>{{ __('landing.about.content') }}</p>
                    <div class="vision-mission">
                        <div class="card">
                            <h3><i class="fas fa-bullseye"></i> {{ __('landing.about.mission') }}</h3>
                            <p>{{ __('landing.about.content') }}</p>
                        </div>
                        <div class="card">
                            <h3><i class="fas fa-eye"></i> {{ __('landing.about.vision') }}</h3>
                            <p>{{ __('landing.about.content') }}</p>
                        </div>
                    </div>
                </div>
                <div class="about-img">
                    <img src="{{ asset('assets/landing/organic.png') }}" alt="About Zeraay">
                </div>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="products section bg-light">
        <div class="container">
            <div class="section-header">
                <h2>{{ __('landing.categories.title') }}</h2>
            </div>
            <div class="products-grid">
                <!-- Organic -->
                <div class="product-card">
                    <div class="prod-img">
                        <img src="{{ asset('assets/landing/organic.png') }}" alt="Organic">
                    </div>
                    <div class="prod-info">
                        <h3>{{ __('landing.categories.organic.title') }}</h3>
                        <p>{{ __('landing.categories.organic.desc') }}</p>
                        <a href="#" class="btn-text">{{ __('landing.categories.cta') }} <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <!-- Chemical -->
                <div class="product-card">
                    <div class="prod-img">
                        <img src="{{ asset('assets/landing/chemical.png') }}" alt="Chemical">
                    </div>
                    <div class="prod-info">
                        <h3>{{ __('landing.categories.chemical.title') }}</h3>
                        <p>{{ __('landing.categories.chemical.desc') }}</p>
                        <a href="#" class="btn-text">{{ __('landing.categories.cta') }} <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <!-- Insecticides -->
                <div class="product-card">
                    <div class="prod-img">
                        <img src="{{ asset('assets/landing/insecticides.png') }}" alt="Insecticides">
                    </div>
                    <div class="prod-info">
                        <h3>{{ __('landing.categories.insecticides.title') }}</h3>
                        <p>{{ __('landing.categories.insecticides.desc') }}</p>
                        <a href="#" class="btn-text">{{ __('landing.categories.cta') }} <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <!-- Fungicides -->
                <div class="product-card">
                    <div class="prod-img">
                        <img src="{{ asset('assets/landing/fungicides.png') }}" alt="Fungicides">
                    </div>
                    <div class="prod-info">
                        <h3>{{ __('landing.categories.fungicides.title') }}</h3>
                        <p>{{ __('landing.categories.fungicides.desc') }}</p>
                        <a href="#" class="btn-text">{{ __('landing.categories.cta') }} <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <!-- Nutrients -->
                <div class="product-card">
                    <div class="prod-img">
                        <img src="{{ asset('assets/landing/nutrients.png') }}" alt="Nutrients">
                    </div>
                    <div class="prod-info">
                        <h3>{{ __('landing.categories.nutrients.title') }}</h3>
                        <p>{{ __('landing.categories.nutrients.desc') }}</p>
                        <a href="#" class="btn-text">{{ __('landing.categories.cta') }} <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Us Section -->
    <section id="why-us" class="why-us section">
        <div class="container">
            <div class="section-header">
                <h2>{{ __('landing.why_us.title') }}</h2>
            </div>
            <div class="why-grid">
                <div class="why-item">
                    <i class="fas fa-certificate"></i>
                    <h4>{{ __('landing.why_us.quality') }}</h4>
                </div>
                <div class="why-item">
                    <i class="fas fa-truck"></i>
                    <h4>{{ __('landing.why_us.delivery') }}</h4>
                </div>
                <div class="why-item">
                    <i class="fas fa-tags"></i>
                    <h4>{{ __('landing.why_us.price') }}</h4>
                </div>
                <div class="why-item">
                    <i class="fas fa-headset"></i>
                    <h4>{{ __('landing.why_us.support') }}</h4>
                </div>
                <div class="why-item">
                    <i class="fas fa-warehouse"></i>
                    <h4>{{ __('landing.why_us.availability') }}</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- How it Works -->
    <section class="how-works section bg-light">
        <div class="container">
            <div class="section-header">
                <h2>{{ __('landing.how_it_works.title') }}</h2>
            </div>
            <div class="steps-grid">
                <div class="step">
                    <div class="step-num">1</div>
                    <p>{{ __('landing.how_it_works.step1') }}</p>
                </div>
                <div class="step">
                    <div class="step-num">2</div>
                    <p>{{ __('landing.how_it_works.step2') }}</p>
                </div>
                <div class="step">
                    <div class="step-num">3</div>
                    <p>{{ __('landing.how_it_works.step3') }}</p>
                </div>
                <div class="step">
                    <div class="step-num">4</div>
                    <p>{{ __('landing.how_it_works.step4') }}</p>
                </div>
            </div>
            <div class="app-badges">
                <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/3/3c/Download_on_the_App_Store_Badge.svg" alt="App Store"></a>
                <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play"></a>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq section">
        <div class="container">
            <div class="section-header">
                <h2>{{ __('landing.faq.title') }}</h2>
            </div>
            <div class="faq-accordion">
                <div class="faq-item">
                    <div class="faq-question">
                        {{ __('landing.faq.q1') }}
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>{{ __('landing.faq.a1') }}</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        {{ __('landing.faq.q2') }}
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>{{ __('landing.faq.a2') }}</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        {{ __('landing.faq.q3') }}
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>{{ __('landing.faq.a3') }}</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question">
                        {{ __('landing.faq.q4') }}
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <p>{{ __('landing.faq.a4') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact section bg-light">
        <div class="container">
            <div class="section-header">
                <h2>{{ __('landing.contact.title') }}</h2>
            </div>
            <div class="contact-grid">
                <div class="contact-info">
                    <div class="info-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <h4>{{ __('landing.contact.phone') }}</h4>
                            <p>+123 456 7890</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <div>
                            <h4>{{ __('landing.contact.email') }}</h4>
                            <p>info@zeraay.com</p>
                        </div>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <h4>{{ __('landing.contact.address') }}</h4>
                            <p>Main Farm Road, Agriculture District</p>
                        </div>
                    </div>
                </div>
                <div class="contact-form">
                    <form id="contactForm" action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <input type="text" name="name" placeholder="{{ __('landing.contact.form_name') }}" required>
                        <input type="email" name="email" placeholder="{{ __('landing.contact.form_email') }}" required>
                        <textarea name="message" placeholder="{{ __('landing.contact.form_message') }}" rows="5" required></textarea>
                        <button type="submit" class="btn btn-primary">{{ __('landing.contact.form_submit') }}</button>
                        <div id="formMessage" class="form-feedback"></div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <!-- <div class="footer-logo">{{ __('landing.app_name') }}</div> -->
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
