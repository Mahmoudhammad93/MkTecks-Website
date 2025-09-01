<!doctype html>
<html class="no-js" lang="{{app()->getLocale()}}" dir="{{(app()->getLocale() == 'en')?'ltr':'rtl'}}">
<!-- Mirrored from html.onertheme.com/MKTechs/index-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 29 Jan 2024 13:08:03 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{settings()->name}}</title>
    <meta name="author" content="MKTechs">
    <meta name="description" content="MKTechs - IT Service And Technology HTML Template">
    <meta name="keywords" content="MKTechs - IT Service And Technology HTML Template">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('website')}}/assets/img/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('website')}}/assets/img/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('website')}}/assets/img/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('website')}}/assets/img/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('website')}}/assets/img/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('website')}}/assets/img/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('website')}}/assets/img/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('website')}}/assets/img/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('website')}}/assets/img/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="{{asset('website')}}/assets/img/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('website')}}/assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('website')}}/assets/img/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('website')}}/assets/img/favicons/favicon-16x16.png">
    <link rel="manifest" href="{{asset('website')}}/assets/img/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{asset('website')}}/assets/img/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="preconnect" href="../../fonts.googleapis.com/index.html">
    <link rel="preconnect" href="../../fonts.gstatic.com/index.html" crossorigin>
    <link
        href="../../fonts.googleapis.com/css2dfba.css?family=Hanken+Grotesk:wght@100;200;300;400;500;600;700;800&amp;family=Outfit:wght@300;400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{asset('website')}}/assets/css/app.min.css">
    <link rel="stylesheet" href="{{asset('website')}}/assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="{{asset('website')}}/assets/css/style.css">
    @if(app()->getLocale() == 'ar')
    <link rel="stylesheet" href="{{asset('website/assets/css/style_ar.css')}}">
    @endif
</head>

<body>
    <div class="sidemenu-wrapper sidemenu-info d-none d-lg-block">
        <div class="sidemenu-content"><button class="closeButton sideMenuCls"><i class="far fa-times"></i></button>
            <div class="widget">
                <div class="ot-widget-about">
                    <div class="about-logo"><a href="index-2.html"><img src="{{asset('website')}}/assets/img/mk-logo.png" alt="MKTechs"></a>
                    </div>
                    <p class="about-text">{{ trans('web.An IT consultancy can help you assess your technology needs and develop a technology strategy that aligns with your business') }}</p>
                    <div class="ot-social"><a href="{{settings()->facebook}}"><i class="fab fa-facebook-f"></i></a> <a
                            href="{{settings()->snapchat}}"><i class="fab fa-tiktok"></i></a> <a
                            href="{{settings()->linkedin}}"><i class="fab fa-linkedin-in"></i></a> <a
                            href="{{settings()->whatsapp}}"><i class="fab fa-whatsapp"></i></a></div>
                </div>
            </div>
            <div class="widget">
                <h3 class="widget_title">{{ trans('web.Contact Us') }}</h3>
                <div class="ot-widget-contact">
                    <div class="info-box">
                        <div class="info-box_icon"><i class="fas fa-location-dot"></i></div>
                        <p class="info-box_text">{{settings()->address}}</p>
                    </div>
                    <div class="info-box">
                        <div class="info-box_icon"><i class="fas fa-phone"></i></div>
                        <p class="info-box_text"><a href="tel:+2352569321586" class="info-box_link">+{{settings()->phone}}</a></p>
                    </div>
                    <div class="info-box">
                        <div class="info-box_icon"><i class="fas fa-envelope"></i></div>
                        <p class="info-box_text"><a href="mailto:help24/7@MKTechs.com"
                                class="info-box_link">{{settings()->email}}</a></p>
                    </div>
                </div>
            </div>
            {{-- <div class="widget newsletter-widget">
                <h3 class="widget_title">Newsletter</h3>
                <p class="footer-text">Sign up to get update news about us</p>
                <form class="newsletter-form"><input class="form-control" type="email" placeholder="Enter Email"
                        required=""> <button type="submit" class="ot-btn">Subscribe</button></form>
            </div> --}}
        </div>
    </div>
    <div class="ot-menu-wrapper">
        <div class="ot-menu-area text-center"><button class="ot-menu-toggle"><i class="fal fa-times"></i></button>
            <div class="mobile-logo"><a href="index-2.html"><img src="{{asset('website')}}/assets/img/mk-logo.png" alt="MKTechs"></a></div>
            <div class="ot-mobile-menu">
                <ul>
                    <li><a href="{{asset('/')}}" data-target="home-sec"> <span>{{ trans('web.Home') }}</span></a></li>
                    <li><a href="about.html" class="scroll" data-target="about_us-sec"> <span>{{ trans('web.About Us') }}</span></a></li>
                    <li><a href="#" class="scroll" data-target="service-sec"> <span>{{ trans('web.Services') }}</span></a></li>
                    <li><a href="{{route('team')}}" class="scroll" data-target="team-sec"> <span>{{ trans('web.Team') }}</span></a></li>
                    <li><a href="{{route('projects')}}" data-target="projects-sec"> <span>{{ trans('web.Projects') }}</span></a></li>
                    <li><a href="contact.html" class="scroll" data-target="contact-sec"> <span>{{ trans('web.Contact') }}</span></a></li>
                    <li class="lang">
                        @if(app()->getLocale() == 'en')
                        <a href="{{asset('lang/ar')}}" class="btn lang-btn">Ar <i class="far fa-language"></i></a>
                        @else
                        <a href="{{asset('lang/en')}}" class="btn lang-btn">En <i class="far fa-language"></i></a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <header class="ot-header header-layout2">
        <div class="mobile-top-header">
            <ul class="list-unstyled">
                <li><i class="far fa-envelope"></i> <a href="mailto:info@MKTechs.com" style="color: #fff">{{settings()->email}}</a></li>
                <li><i class="far fa-clock" style="margin: 0 5px"></i>{{ trans('web.Sun') }} - {{ trans('web.Thur') }}: 9:00AM - 5:00PM</li>
            </ul>
        </div>
        <div class="header-top">
            <div class="container">
                <div class="row justify-content-center justify-content-lg-between align-items-center gy-2">
                    <div class="col-auto d-none d-lg-block">
                        <div class="header-links">
                            <ul>
                                <li class="d-none d-xl-inline-block"><i class="far fa-phone"></i><a
                                        href="tel:+{{settings()->phone}}">{{ trans('web.Have any Question?') }}</a></li>
                                <li><i class="far fa-envelope"></i> <a href="mailto:info@MKTechs.com">{{settings()->email}}</a></li>
                                <li><i class="far fa-clock"></i>{{ trans('web.Sun') }} - {{ trans('web.Thur') }}: 9:00AM - 5:00PM</li>
                                <li>
                                    @if(app()->getLocale() == 'en')
                                    <a href="{{asset('lang/ar')}}" class="btn lang-btn">Ar</a>
                                    @else
                                    <a href="{{asset('lang/en')}}" class="btn lang-btn">En</a>
                                    @endif
                                    <i class="far fa-language"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="social-links"><span class="social-title">{{ trans('web.Follow Us On') }} : </span><a
                                href="{{settings()->facebook}}"><i class="fab fa-facebook-f"></i></a> <a
                                href="{{settings()->snapchat}}"><i class="fab fa-tiktok"></i></a> <a
                                href="{{settings()->facebook}}"><i class="fab fa-linkedin-in"></i></a> <a
                                href="{{settings()->instagram}}"><i class="fab fa-instagram"></i></a></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="sticky-wrapper">
            <div class="menu-area">
                <div class="container">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                            <div class="header-logo"><a href="{{asset('/')}}"><img src="{{settings()->logo}}"
                                        alt="MKTechs"></a></div>
                        </div>
                        <div class="col-auto">
                            <nav class="main-menu d-none d-lg-inline-block">
                                <ul>
                                    <li><a href="{{asset('/')}}" data-target="home-sec">{{ trans('web.Home') }}</a></li>
                                    <li><a href="about.html" class="scroll" data-target="about_us-sec">{{ trans('web.About Us') }}</a></li>
                                    <li><a href="#" class="scroll" data-target="service-sec">{{ trans('web.Services') }}</a></li>
                                    <li><a href="{{route('team')}}" class="scroll" data-target="team-sec">{{ trans('web.Team') }}</a></li>
                                    <li><a href="{{route('projects')}}" data-target="projects-sec">{{ trans('web.Projects') }}</a></li>
                                    <li><a href="contact.html" class="scroll" data-target="contact-sec">{{ trans('web.Contact') }}</a></li>
                                </ul>
                            </nav><button type="button" class="ot-menu-toggle d-block d-lg-none"><i
                                    class="far fa-bars"></i></button>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                            <div class="header-button"><a href="contact.html" data-target="contact-sec" class="ot-btn btn-sm scroll">{{ trans('web.Get Started') }}</a>
                                <button type="button" class="icon-btn sideMenuInfo"><i class="far fa-bars"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="ot-hero-wrapper hero-2" id="hero" data-bg-src="{{asset('website')}}/assets/img/bg/header-top-bg.png">
        <div class="hero-inner">
            <div class="container">
                <div class="hero-style2"><span class="sub-title"><span class="text">{{settings()->header_message}}</span></span>
                    <h1 class="hero-title"><span class="title1">{{settings()->header_title}}</span></h1>
                    <p class="hero-text">{{settings()->header_description}}</p>
                </div>
            </div>
            <div class="hero-img">
                {{-- <img src="{{asset('website')}}/assets/img/hero/hero_2_1.png" alt="Image"> --}}
            </div>
        </div>
    </div>
    {{-- <section class="bg-top-center space" data-bg-src="{{asset('website')}}/assets/img/bg/why_bg_1.jpg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-7 col-md-8">
                    <div class="title-area text-center"><span class="sub-title"><span class="text">Case
                                Studies</span></span>
                        <h2 class="sec-title">Why People Choose Us?</h2>
                        <p class="sec-text">Website and mobile sit amet, consectetur adipiscing elit. Morbi obortis
                            ligula euismod sededesty am augue nisl.</p>
                    </div>
                </div>
            </div>
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-box" data-bg-src="{{asset('website')}}/assets/img/bg/vector_bg_1.png"><span
                            class="box-subtitle">Feature-01</span>
                        <h3 class="box-title">Highly Expert Team Members</h3><a href="about.html" class="link-btn">Learn
                            More<i class="fa-solid fa-arrow-up-right"></i></a>
                        <div class="box-img"><img src="{{asset('website')}}/assets/img/normal/feature_box_1.png" alt=""></div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-box" data-bg-src="{{asset('website')}}/assets/img/bg/vector_bg_1.png"><span
                            class="box-subtitle">Feature-01</span>
                        <h3 class="box-title">Fastest Customer Service</h3><a href="about.html" class="link-btn">Learn
                            More<i class="fa-solid fa-arrow-up-right"></i></a>
                        <div class="box-img"><img src="{{asset('website')}}/assets/img/normal/feature_box_2.png" alt=""></div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-box" data-bg-src="{{asset('website')}}/assets/img/bg/vector_bg_1.png"><span
                            class="box-subtitle">Feature-01</span>
                        <h3 class="box-title">Competitive Pricing For All Service</h3><a href="about.html"
                            class="link-btn">Learn More<i class="fa-solid fa-arrow-up-right"></i></a>
                        <div class="box-img"><img src="{{asset('website')}}/assets/img/normal/feature_box_3.png" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    {{-- <div class="space-bottom" id="about-sec">
        <div class="shape-mockup jump d-none d-sm-block" data-bottom="20%" data-right="8%"><img
                src="{{asset('website')}}/assets/img/shape/shape_2.png" alt="shape"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-7 col-lg-6 mb-35 mb-lg-0">
                    <div class="img-box3">
                        <div class="img1"><img src="{{asset('website')}}/assets/img/normal/about_2_1.png" alt="About"></div>
                        <div class="shape1"><img src="{{asset('website')}}/assets/img/normal/about_2_2.png" alt="Image"></div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6 text-center text-lg-start">
                    <div class="ps-xxl-5">
                        <div class="title-area mb-37"><span class="sub-title"><span class="text">More About Our
                                    Company</span></span>
                            <h2 class="sec-title">Our Application Features.</h2>
                            <p class="sec-text">IT service providers work closely with clients to understand their
                                unique needs and develop customized</p>
                        </div>
                        <div class="dot-list style-center">
                            <ul>
                                <li>Amazing communication.</li>
                                <li>Best trending designing experience.</li>
                                <li>Email & Live chat.</li>
                            </ul>
                        </div>
                        <div class="mt-45"><a href="" class="ot-btn style4 scroll" data-target="contact-sec">Contact Us</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <section class="bg-top-center" id="service-sec" data-bg-src="{{asset('website')}}/assets/img/bg/service_bg_2.jpg">
        <div class="container">
            {{-- <div class="swiper ot-slider brand-slider1" id="brandSlider1"
                data-slider-options='{"breakpoints":{"0":{"slidesPerView":2},"576":{"slidesPerView":"2"},"768":{"slidesPerView":"3"},"992":{"slidesPerView":"4"},"1200":{"slidesPerView":"5"},"1400":{"slidesPerView":"5"}}}'>
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="brand-card"><img src="{{asset('website')}}/assets/img/brand/brand_1_1.png" alt="Brand Logo"></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-card"><img src="{{asset('website')}}/assets/img/brand/brand_1_2.png" alt="Brand Logo"></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-card"><img src="{{asset('website')}}/assets/img/brand/brand_1_3.png" alt="Brand Logo"></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-card"><img src="{{asset('website')}}/assets/img/brand/brand_1_4.png" alt="Brand Logo"></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-card"><img src="{{asset('website')}}/assets/img/brand/brand_1_5.png" alt="Brand Logo"></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-card"><img src="{{asset('website')}}/assets/img/brand/brand_1_6.png" alt="Brand Logo"></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-card"><img src="{{asset('website')}}/assets/img/brand/brand_1_7.png" alt="Brand Logo"></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-card"><img src="{{asset('website')}}/assets/img/brand/brand_1_8.png" alt="Brand Logo"></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-card"><img src="{{asset('website')}}/assets/img/brand/brand_1_1.png" alt="Brand Logo"></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-card"><img src="{{asset('website')}}/assets/img/brand/brand_1_2.png" alt="Brand Logo"></div>
                    </div>
                </div>
            </div> --}}
            <div class="row justify-content-center pt-5">
                <div class="col-xl-6 col-lg-7 col-md-8">
                    <div class="title-area text-center"><span class="sub-title"><span class="text">{{ trans('web.Our services') }}</span></span>
                        {{-- <h2 class="sec-title">{{ trans('web.Awesome Services') }}</h2> --}}
                    </div>
                </div>
            </div>
            <div class="row gy-4 justify-content-center">
                @foreach ($services as $service)
                <div class="col-xl-3 col-md-6">
                    <div class="service-card">
                        <div class="box-icon"><img src="{{($service->image)?$service->image->url:''}}" alt="Icon"></div>
                        <h3 class="box-title"><a href="service-details.html">{{$service->title}}</a></h3>
                        <p class="box-text">{{$service->description}}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- <div class="space">
        <div class="shape-mockup spin" data-top="40%" data-left="4%"><img src="{{asset('website')}}/assets/img/shape/shape_1.png"
                alt="shape"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-5 col-lg-6 text-center text-lg-start">
                    <div class="pe-xxl-5">
                        <div class="title-area"><span class="sub-title"><span class="text">{{ trans('web.Work With Us') }}</span></span>
                            <h2 class="sec-title">{{ trans('web.We Make Awesome IT Services For Your Newly Business') }}</h2>
                        </div>
                        <div class="btn-group"><a href="contact.html" data-target="contact-sec" class="ot-btn scroll">Start A Projects</a>
                            <div class="call-text">
                                <h4 class="box-title">{{ trans('web.Call Us') }}: +{{settings()->phone}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 col-lg-6">
                    <div class="text-center mt-40 mt-lg-0"><img src="{{asset('website')}}/assets/img/normal/vector_1.png" alt="vector"></div>
                </div>
            </div>
        </div>
    </div> --}}
    <section class="space-bottom pt-5" id="team-sec">
        <div class="container">
            <div class="title-area text-center"><span class="sub-title"><span class="text">{{ trans('web.Team Members') }}</span></span>
                <h2 class="sec-title">{{ trans('web.Our Top Skilled Experts') }}</h2>
            </div>
            <div class="row gy-4">
                @foreach ($team as $employee)
                <div class="col-lg-3 col-md-6">
                    <div class="ot-team team-box">
                        <div class="box-img"><img src="{{$employee->avatar->url}}" alt="Team"></div>
                        <div class="box-content"><span class="box-desig">{{$employee->position}}</span>
                            <h3 class="box-title"><a href="team-details.html">{{$employee->name}}</a></h3>
                            {{-- <div class="team-social"><a target="_blank" href="https://facebook.com/">FB</a> <a
                                    target="_blank" href="https://twitter.com/">TW</a> <a target="_blank"
                                    href="https://instagram.com/">IG</a></div> --}}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    {{-- <div class="newsticker-area">
        <div class="swiper swiper-newsticker">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><a href="contact.html" class="newsticker-title">Get Our Service</a></div>
                <div class="swiper-slide"><a href="contact.html" class="newsticker-title">24/7 Customer Service</a>
                </div>
                <div class="swiper-slide"><a href="contact.html" class="newsticker-title">Happy Customer Feedback</a>
                </div>
                <div class="swiper-slide"><a href="contact.html" class="newsticker-title">Get A Quote</a></div>
                <div class="swiper-slide"><a href="contact.html" class="newsticker-title">Get Our Service</a></div>
                <div class="swiper-slide"><a href="contact.html" class="newsticker-title">24/7 Customer Service</a>
                </div>
                <div class="swiper-slide"><a href="contact.html" class="newsticker-title">Happy Customer Feedback</a>
                </div>
                <div class="swiper-slide"><a href="contact.html" class="newsticker-title">Get A Quote</a></div>
                <div class="swiper-slide"><a href="contact.html" class="newsticker-title">Get Our Service</a></div>
                <div class="swiper-slide"><a href="contact.html" class="newsticker-title">24/7 Customer Service</a>
                </div>
                <div class="swiper-slide"><a href="contact.html" class="newsticker-title">Happy Customer Feedback</a>
                </div>
                <div class="swiper-slide"><a href="contact.html" class="newsticker-title">Get A Quote</a></div>
            </div>
        </div>
    </div> --}}
    {{-- <div class="bg-lines space">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-6">
                    <div class="pe-xxl-5">
                        <div class="title-area mb-50 text-center text-xl-start"><span class="sub-title"><span
                                    class="text">More About Our Company</span></span>
                            <h2 class="sec-title">We're A Software And IT Company That Provides Solutions</h2>
                        </div>
                        <div class="">
                            <div class="skill-feature">
                                <h3 class="box-title">Business Security</h3>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 85%">
                                        <div class="progress-value"><span class="counter-number2">85</span>%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="skill-feature">
                                <h3 class="box-title">Career Development</h3>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 95%">
                                        <div class="progress-value"><span class="counter-number2">95</span>%</div>
                                    </div>
                                </div>
                            </div>
                            <div class="skill-feature">
                                <h3 class="box-title">Business Inovation</h3>
                                <div class="progress">
                                    <div class="progress-bar" style="width: 90%">
                                        <div class="progress-value"><span class="counter-number2">90</span>%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 mt-40 mt-xl-0">
                    <div class="skill-img"><img class="w-100" src="{{asset('website')}}/assets/img/normal/skill.jpg" alt="Image">
                        <div class="ot-video"><img src="{{asset('website')}}/assets/img/normal/skill_2.jpg" alt="Image"> <a
                                href="https://www.youtube.com/watch?v=_sI_Ps7JSEk" class="video-btn popup-video"><i
                                    class="fas fa-play"></i></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="overflow-hidden space" id="about_us-sec" data-bg-src="{{asset('website')}}/assets/img/bg/testi_bg_2.jpg">
        <div class="shape-mockup pulse" data-top="15%" data-left="2%">
            <div class="shape-circle circle1"></div>
        </div>
        <div class="shape-mockup pulse" data-bottom="12%" data-right="2%">
            <div class="shape-circle circle2"></div>
        </div>
        <div class="shape-mockup pulse d-none d-xl-block" data-top="45%" data-right="17%"><img
                src="{{asset('website')}}/assets/img/testimonial/testi_2_4.png" alt="image"></div>
        <div class="shape-mockup pulse d-none d-md-block" data-top="15%" data-right="6%"><img
                src="{{asset('website')}}/assets/img/testimonial/testi_2_5.png" alt="image"></div>
        <div class="container">
            <div class="title-area text-center"><span class="sub-title"><span class="text">Customer
                        Feedback</span></span>
                <h2 class="sec-title">People Talk About Us</h2>
            </div>
            <div class="testi-box-slide">
                <div class="swiper ot-slider" id="testiSlide2" data-slider-options='{"effect":"slide"}'>
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="testi-box">
                                <div class="box-img"><img src="{{asset('website')}}/assets/img/testimonial/testi_2_1.jpg" alt="Avater"></div>
                                <h3 class="box-heading">“Elit penatibus curae aucto”</h3>
                                <p class="box-text">Sem a penatibus varius dui nostra vehicula gravida congue, potenti
                                    etiam erat justo faucibus fusce quis nulla eu, dignissim eget posuere blandit
                                    curabitur porta inceptos. Inceptos faucibus fringilla pharetra mi suscipit curabitu
                                </p>
                                <h4 class="box-title">Andrew Smith</h4>
                                <p class="box-desig">Designer at <a href="https://www.google.com/">(Montan_Agency)</a>
                                </p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-box">
                                <div class="box-img"><img src="{{asset('website')}}/assets/img/testimonial/testi_2_2.jpg" alt="Avater"></div>
                                <h3 class="box-heading">“Elit penatibus curae aucto”</h3>
                                <p class="box-text">Sem a penatibus varius dui nostra vehicula gravida congue, potenti
                                    etiam erat justo faucibus fusce quis nulla eu, dignissim eget posuere blandit
                                    curabitur porta inceptos. Inceptos faucibus fringilla pharetra mi suscipit curabitu
                                </p>
                                <h4 class="box-title">Alexan Miceli</h4>
                                <p class="box-desig">Developer at <a href="https://www.google.com/">(Atanu_Agency)</a>
                                </p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="testi-box">
                                <div class="box-img"><img src="{{asset('website')}}/assets/img/testimonial/testi_2_3.jpg" alt="Avater"></div>
                                <h3 class="box-heading">“Elit penatibus curae aucto”</h3>
                                <p class="box-text">Sem a penatibus varius dui nostra vehicula gravida congue, potenti
                                    etiam erat justo faucibus fusce quis nulla eu, dignissim eget posuere blandit
                                    curabitur porta inceptos. Inceptos faucibus fringilla pharetra mi suscipit curabitu
                                </p>
                                <h4 class="box-title">Michael John</h4>
                                <p class="box-desig">Mnager at <a href="https://www.google.com/">(Shila_Tech)</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-7 col-md-8">
                    <div class="title-area text-center"><span class="sub-title"><span class="text">Pricing
                                Plans</span></span>
                        <h2 class="sec-title">Pricing Packages</h2>
                        <p class="sec-text">Website and mobile sit amet, consectetur adipiscing elit. Morbi obortis
                            ligula euismod sededesty am augue nisl.</p>
                    </div>
                </div>
            </div>
            <div class="row gy-4 justify-content-center">
                <div class="col-lg-6">
                    <div class="price-card">
                        <div class="box-header">
                            <div class="box-img"><img src="{{asset('website')}}/assets/img/normal/price_card_1.png" alt="image"></div>
                            <div class="box-price">$39</div>
                            <h3 class="box-title">Great for small business</h3>
                        </div>
                        <div class="box-content">
                            <div class="check-list">
                                <ul>
                                    <li><i class="far fa-circle-check"></i> Design & Marketing</li>
                                    <li><i class="far fa-circle-check"></i> Project Management</li>
                                    <li><i class="far fa-circle-check"></i> Business Solution</li>
                                    <li><i class="far fa-circle-check"></i> Digital Product Design</li>
                                </ul>
                            </div><a href="pricing.html" class="ot-btn">Choose Plan</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="price-card">
                        <div class="box-header">
                            <div class="box-img"><img src="{{asset('website')}}/assets/img/normal/price_card_1.png" alt="image"></div>
                            <div class="box-price">$99</div>
                            <h3 class="box-title">Great for large business</h3>
                        </div>
                        <div class="box-content">
                            <div class="check-list">
                                <ul>
                                    <li><i class="far fa-circle-check"></i> Design & Marketing</li>
                                    <li><i class="far fa-circle-check"></i> Project Management</li>
                                    <li><i class="far fa-circle-check"></i> Business Solution</li>
                                    <li><i class="far fa-circle-check"></i> Digital Product Design</li>
                                </ul>
                            </div><a href="pricing.html" class="ot-btn">Choose Plan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <div class="pb-3" id="contact-sec">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-5 text-center text-lg-start">
                    <div class="pe-xxl-5 me-xl-4">
                        <div class="title-area mb-50"><span class="sub-title"><span class="text">{{ trans('web.How can we help?') }}</span></span>
                            <h2 class="sec-title">{{ trans('web.Let\'s Help You') }}</h2>
                            <p class="sec-text">{{ trans('web.At Mk-Techs, we are committed to providing exceptional customer service and support.') }}</p>
                        </div>
                        <div class="social-card">
                            <h3 class="box-title">{{ trans('web.Follow Us') }}:</h3>
                            <div class="ot-social"><a
                                href="{{settings()->facebook}}"><i class="fab fa-facebook-f"></i></a> <a
                                href="{{settings()->snapchat}}"><i class="fab fa-tiktok"></i></a> <a
                                href="{{settings()->facebook}}"><i class="fab fa-linkedin-in"></i></a> <a
                                href="{{settings()->instagram}}"><i class="fab fa-instagram"></i></a>
                            </div>
                            {{-- <a target="_blank" href="https://www.google.com/maps" class="box-link">Get Google Map
                                Directions</a> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 mt-40 mt-xl-0">
                    <div class="contact-form1" data-bg-src="{{asset('website')}}/assets/img/bg/contact_bg_2.png">
                        <h3 class="box-title">{{ trans('web.Fill The Contact Form') }}</h3>
                        <p class="box-text">{{ trans('web.Feel free to contact with us, we don’t spam your email') }}</p>
                        <form action="{{route('contact_us')}}" id="contact" method="POST"
                            class="input-label ajax-contact">
                            @csrf
                            <div class="row">
                                <div class="form-group line-input col-sm-6"><input type="text" class="form-control"
                                        name="name" id="name" required=""> <label for="name">{{ trans('web.Full Name') }}*</label></div>
                                <div class="form-group line-input col-sm-6"><input type="email" class="form-control"
                                        name="email" id="email" required=""> <label for="email">{{ trans('web.Email') }}*</label>
                                </div>
                                <div class="form-group line-input col-sm-6"><input type="tel" class="form-control"
                                        name="phone" id="number" required=""> <label for="number">{{ trans('web.Mobile') }}*</label>
                                </div>
                                <div class="form-group line-input col-sm-6"><input type="text" class="form-control"
                                        name="subject" id="subject" required=""> <label for="subject">{{ trans('web.Subject') }}...</label>
                                </div>
                                <div class="form-group line-input col-12"><textarea name="message" id="message"
                                        cols="30" rows="3" class="form-control" required=""></textarea> <label
                                        for="message">{{ trans('web.Message') }}*</label></div>
                                <div class="form-btn col-12 mt-10"><button class="ot-btn style3" id="contact_submit">{{ trans('web.Send') }}</button>
                                </div>
                            </div>
                            <p class="form-messages mb-0 mt-3"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <section class="space" id="blog-sec">
        <div class="container">
            <div class="title-area text-center"><span class="sub-title"><span class="text">Blog Updates</span></span>
                <h2 class="sec-title">Latest News Posts</h2>
            </div>
            <div class="row gy-4 justify-content-center">
                <div class="col-xl-4 col-md-6">
                    <div class="blog-card">
                        <div class="blog-img"><img src="{{asset('website')}}/assets/img/blog/blog_1_1.jpg" alt="blog image"></div>
                        <div class="blog-meta"><a href="blog.html"><i class="far fa-calendar"></i>15 Mar, 2023</a> <a
                                href="blog.html"><i class="far fa-user"></i>By MKTechs</a></div>
                        <h3 class="box-title"><a href="blog-details.html">Top 5 IT Solutions for Small Businesses
                                Startup</a></h3>
                        <p class="box-text">Technology solutions that small businesses can implement to streamline their
                            operations and improve productivity.</p><a href="blog-details.html" class="link-btn">Read
                            Details<i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="blog-card">
                        <div class="blog-img"><img src="{{asset('website')}}/assets/img/blog/blog_1_2.jpg" alt="blog image"></div>
                        <div class="blog-meta"><a href="blog.html"><i class="far fa-calendar"></i>16 Mar, 2023</a> <a
                                href="blog.html"><i class="far fa-user"></i>By MKTechs</a></div>
                        <h3 class="box-title"><a href="blog-details.html">This post could discuss the top technology
                                solutions</a></h3>
                        <p class="box-text">Technology solutions that small businesses can implement to streamline their
                            operations and improve productivity.</p><a href="blog-details.html" class="link-btn">Read
                            Details<i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="blog-card">
                        <div class="blog-img"><img src="{{asset('website')}}/assets/img/blog/blog_1_3.jpg" alt="blog image"></div>
                        <div class="blog-meta"><a href="blog.html"><i class="far fa-calendar"></i>17 Mar, 2023</a> <a
                                href="blog.html"><i class="far fa-user"></i>By MKTechs</a></div>
                        <h3 class="box-title"><a href="blog-details.html">How to Choose the Right IT Solution
                                Provider</a></h3>
                        <p class="box-text">Technology solutions that small businesses can implement to streamline their
                            operations and improve productivity.</p><a href="blog-details.html" class="link-btn">Read
                            Details<i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <footer class="footer-wrapper footer-layout2" data-bg-src="{{asset('website')}}/assets/img/bg/footer_bg_2.jpg">
        {{-- <div class="widget-wrapper">
            <div class="container">
                <div class="row gx-0 justify-content-between">
                    <div class="col-md-6 col-lg-auto">
                        <div class="widget footer-widget">
                            <h3 class="widget_title">About Us</h3>
                            <div class="ot-widget-about">
                                <p class="footer-text">An IT consultancy can help you assess your technology needs and
                                    develop a technology strategy that aligns with your business</p>
                                <div class="ot-social"><a
                                    href="{{settings()->facebook}}"><i class="fab fa-facebook-f"></i></a> <a
                                    href="{{settings()->twitter}}"><i class="fab fa-twitter"></i></a> <a
                                    href="{{settings()->facebook}}"><i class="fab fa-linkedin-in"></i></a> <a
                                    href="{{settings()->instagram}}"><i class="fab fa-instagram"></i></a>
                                        </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto widget-border"></div>
                    <div class="col-md-6 col-lg-auto">
                        <div class="widget widget_nav_menu footer-widget">
                            <h3 class="widget_title">Links</h3>
                            <div class="menu-all-pages-container">
                                <ul class="menu">
                                    <li><a href="about.html">About Us</a></li>
                                    <li><a href="about.html">Our Mission</a></li>
                                    <li><a href="team.html">Meet The Teams</a></li>
                                    <li><a href="project.html">Our Projects</a></li>
                                    <li><a href="contact.html">Contact Us</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto widget-border"></div>
                    <div class="col-md-6 col-lg-auto">
                        <div class="widget widget_nav_menu footer-widget">
                            <h3 class="widget_title">Explore</h3>
                            <div class="menu-all-pages-container">
                                <ul class="menu">
                                    <li><a href="service.html">What We Offer</a></li>
                                    <li><a href="about.html">Our Story</a></li>
                                    <li><a href="blog.html">Latest Posts</a></li>
                                    <li><a href="about.html">Help Center</a></li>
                                    <li><a href="contact.html">Get Support</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto widget-border"></div>
                    <div class="col-md-6 col-lg-auto">
                        <div class="widget footer-widget">
                            <h3 class="widget_title">Recent Posts</h3>
                            <div class="recent-post-wrap">
                                <div class="recent-post">
                                    <div class="media-img"><a href="blog-details.html"><img
                                                src="{{asset('website')}}/assets/img/blog/recent-post-1-1.jpg" alt="Blog Image"></a></div>
                                    <div class="media-body">
                                        <h4 class="post-title"><a class="text-inherit" href="blog-details.html">Building
                                                Renovation Tasks</a></h4>
                                        <div class="recent-post-meta"><a href="blog.html"><i
                                                    class="far fa-calendar"></i>21 Jun, 2023</a></div>
                                    </div>
                                </div>
                                <div class="recent-post">
                                    <div class="media-img"><a href="blog-details.html"><img
                                                src="{{asset('website')}}/assets/img/blog/recent-post-1-2.jpg" alt="Blog Image"></a></div>
                                    <div class="media-body">
                                        <h4 class="post-title"><a class="text-inherit" href="blog-details.html">Get
                                                Started With Our Team</a></h4>
                                        <div class="recent-post-meta"><a href="blog.html"><i
                                                    class="far fa-calendar"></i>22 Jun, 2023</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="copyright-wrap">
            <div class="container text-center">
                <p class="copyright-text">Copyright <i class="fal fa-copyright"></i> {{ now()->year }} <a
                        href="{{asset('/')}}">MKTechs</a>. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
    <div class="scroll-top"><svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;">
            </path>
        </svg></div>
    <script src="{{asset('website')}}/assets/js/vendor/jquery-3.7.1.min.js"></script>
    <script src="{{asset('website')}}/assets/js/app.min.js"></script>
    <script src="{{asset('website')}}/assets/js/main.js"></script>
    <script>
        $('.scroll').click(function(event) {
            event.preventDefault();
            var id = $(this).data('target');
            $('html, body').animate({
                scrollTop: $("#"+id).offset().top
            });

            $('.ot-menu-wrapper').removeClass('ot-body-visible')
            // $(this).addClass('active').siblings().removeClass('active');
            // scrollTo($('#'+id), 1000);
        });
    </script>
    <script>
        $(document).on('submit', '#contact', function(e){
            e.preventDefault();
            var name = $('#name').val();
            var email = $('#email').val();
            var number = $('#number').val();
            var subject = $('#subject').val();
            var message = $('#message').val();
            $.ajax({
                url: "{{route('contact_us')}}",
                dataType: "json",
                type: "post",
                async: true,
                data: {
                    name: name,
                    email: email,
                    phone: number,
                    subject: subject,
                    message: message,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                success: function (data) {
                    console.log(data)
                }
            });
            return false;
        })
    </script>
</body>
<!-- Mirrored from html.onertheme.com/MKTechs/index-2.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 29 Jan 2024 13:08:31 GMT -->

</html>