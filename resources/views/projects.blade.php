<!doctype html>
<html class="no-js" lang="{{app()->getLocale()}}" dir="{{(app()->getLocale() == 'en')?'ltr':'rtl'}}">
<!-- Mirrored from html.onertheme.com/Mktechs/project.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 29 Jan 2024 13:09:10 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{settings()->name}} - {{$title}}</title>
    <meta name="author" content="Mktechs">
    <meta name="description" content="Mktechs - IT Service And Technology">
    <meta name="keywords" content="Mktechs - IT Service And Technology">
    <meta name="robots" content="INDEX,FOLLOW">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
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
    {{-- <div class="preloader"><button class="ot-btn preloaderCls style3">Cancel Preloader</button>
        <div class="preloader-inner"><span class="loader"></span></div>
    </div> --}}
    <div class="ot-menu-wrapper">
        <div class="ot-menu-area text-center"><button class="ot-menu-toggle"><i class="fal fa-times"></i></button>
            <div class="mobile-logo"><a href="{{asset('/')}}"><img src="{{settings()->logo}}" alt="{{settings()->name}}"></a></div>
            <div class="ot-mobile-menu">
                <ul>
                    <li><a href="{{asset('/')}}" data-target="home-sec"> <span>{{ trans('web.Home') }}</span></a></li>
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
                <li><i class="fab fa-whatsapp"></i> <a href="https://wa.me/{{settings()->phone}}"  style="color: #fff">{{settings()->phone}}</a></li>
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
                                <li><i class="fab fa-whatsapp"></i> <a href="https://wa.me/{{settings()->phone}}">{{settings()->phone}}</a></li>
                                <li>
                                    @if(app()->getLocale() == 'en')
                                    <a href="{{asset('lang/ar')}}" class="btn lang-btn">Ar</a>
                                    @else
                                    <a href="{{asset('lang/en')}}" class="btn lang-btn">En</a>
                                    @endif
                                    <!--<i class="far fa-language"></i></li>-->
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
                                    {{-- <!--<li><a href="about.html" class="scroll" data-target="about_us-sec">{{ trans('web.About Us') }}</a></li>-->
                                    <li><a href="#" class="scroll" data-target="service-sec">{{ trans('web.Services') }}</a></li>
                                    <li><a href="{{route('team')}}" class="scroll" data-target="team-sec">{{ trans('web.Team') }}</a></li>
                                    <li><a href="{{route('projects')}}" data-target="projects-sec">{{ trans('web.Projects') }}</a></li>
                                    <li><a href="contact.html" class="scroll" data-target="contact-sec">{{ trans('web.Contact') }}</a></li> --}}
                                </ul>
                            </nav><button type="button" class="ot-menu-toggle d-block d-lg-none"><i
                                    class="far fa-bars"></i></button>
                        </div>
                        <div class="col-auto d-none d-lg-block" style="width: 210px;">
                            <!--<div class="header-button"><a href="contact.html" data-target="contact-sec" class="ot-btn btn-sm scroll">{{ trans('web.Get Started') }}</a>-->
                                <!--<button type="button" class="icon-btn sideMenuInfo"><i class="far fa-bars"></i></button>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="breadcumb-wrapper" data-bg-src="{{asset('website')}}/assets/img/bg/breadcumb-bg.png">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title">{{ trans('web.Our Projects') }}</h1>
                <ul class="breadcumb-menu">
                    <li><a href="{{asset('/')}}">{{ trans('web.Home') }}</a></li>
                    <li>{{ trans('web.Our Projects') }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="overflow-hidden space">
        <div class="container">
            <div class="row gy-30 gallery-row filter-active">
                @foreach ($projects as $project)
                <div class="col-lg-3 col-md-3 col-sm-12 filter-item">
                    <div class="gallery-card style2">
                        <div class="box-img">
                            @if (count($project->image) > 0)
                            <img src="{{$project->image[0]->url}}" alt="gallery image">
                                @foreach ($project->image as $img)
                                <a
                                    href="{{$img->url}}" class="icon-btn popup-image"><i
                                        class="far fa-magnifying-glass-plus"></i></a>
                                @endforeach
                            @endif 
                                </div>
                        <div class="box-content">
                            <p class="box-subtitle">{{$project->title}}</p>
                            <h3 class="box-title"><a href="project-details.html">{{$project->description}}</a></h3>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-5"><a href="project.html" class="ot-btn">View More</a></div>
        </div>
    </div>
    <footer class="footer-wrapper footer-layout1" data-bg-src="{{asset('website')}}/assets/img/bg/footer_bg_1.jpg">
        <div class="copyright-wrap">
            <div class="container text-center">
                <p class="copyright-text">Copyright <i class="fal fa-copyright"></i> 2023 <a
                        href="{{asset('/')}}">Mktechs</a>. All Rights Reserved.</p>
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
</body>
<!-- Mirrored from html.onertheme.com/Mktechs/project.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 29 Jan 2024 13:09:16 GMT -->

</html>