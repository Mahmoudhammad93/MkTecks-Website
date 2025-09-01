<body class="{{ theme() == 'dark' ? 'dark-only' : '' }} {{ lang() == 'ar' ? 'rtl' : 'ltr' }}">
    <!-- loader starts-->
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
        <svg>
            <defs></defs>
            <filter id="goo">
                <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
                <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo">
                </fecolormatrix>
            </filter>
        </svg>
    </div>
    <!-- loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->
        <div class="page-header">
            <div class="header-wrapper row m-0">
                <form class="form-inline search-full col" action="{{ aurl('search') }}" method="get">
                    <div class="form-group w-100">
                        <div class="Typeahead Typeahead--twitterUsers">
                            <div class="u-posRelative">
                                <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text"
                                    placeholder="{{ trans('admin.Search hear') }} .." name="search" title=""
                                    autofocus>
                                <div class="spinner-border Typeahead-spinner" role="status"></div><i
                                    class="close-search" data-feather="x"></i>
                            </div>
                            <div class="Typeahead-menu"></div>
                        </div>
                    </div>
                </form>
                <div class="header-logo-wrapper col-auto p-0">
                    <div class="logo-wrapper"><a href="{{ aurl('/') }}"><img class="img-fluid"
                                src="{{ asset('dashboard') }}/assets/images/logo.png" alt=""></a></div>
                    <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle"
                            data-feather="align-center"></i></div>
                </div>
                <div class="left-header col horizontal-wrapper ps-0">
                    <ul class="horizontal-menu">
                        <li>
                            <a href="{{ url()->previous() }}" style="padding: 5px 15px;font-size: 15px;;"
                                class="btn btn-pill btn-outline-dark btn-air-dark btn-sm">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="nav-right col-8 pull-right right-header p-0">
                    <ul class="nav-menus">
                        <li class="language-nav">
                            <div class="translate_wrapper">
                                <div class="current_lang">
                                    <div class="lang"><i
                                            class="flag-icon flag-icon-{{ lang() == 'ar' ? 'kw' : 'us' }}"></i><span
                                            class="lang-txt">{{ lang() }} </span></div>
                                </div>
                                <div class="more_lang">
                                    <a href="{{ aurl('settings/language/en') }}">
                                        <div class="lang">
                                            <i class="flag-icon flag-icon-us"></i><span class="lang-txt">English</span>
                                        </div>
                                    </a>
                                    <a href="{{ aurl('settings/language/ar') }}">
                                        <div class="lang">
                                            <i class="flag-icon flag-icon-kw"></i><span class="lang-txt">لعربية</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </li>
                        {{-- <li> <span class="header-search"><i data-feather="search"></i></span></li> --}}
                        <li>
                            <div class="mode">
                                @if (theme() == 'dark')
                                    <i class="fa fa-moon-o" onclick="changeTheme('light');"></i>
                                @else
                                    <i class="fa fa-lightbulb-o" onclick="changeTheme('dark');"></i>
                                @endif
                            </div>
                        </li>
                        {{-- <li class="onhover-dropdown" id="notificationButton">
                            <div class="notification-box"><i data-feather="bell"> </i>
                                @if (notificationsCount()->count() > 0)
                                    <span id="notificationCountButtonArea"
                                        class="badge rounded-pill badge-secondary">{{ notificationsCount()->count() > 20 ? '20+' : notificationsCount()->count() }}</span>
                                @endif
                            </div>
                            <div class="chat-dropdown onhover-show-div card-notification">
                                <h6 class="f-18 mb-0 dropdown-title">{{ trans('admin.Notifications') }} </h6>
                                <ul class="py-0">
                                    @foreach (notifications() as $notification)
                                        <li>
                                            <div class="media"><img class="img-fluid b-r-5 me-2"
                                                    src="{{ asset('dashboard/assets/images/avatar.png') }}"
                                                    alt="">
                                                <div class="media-body">
                                                    <h6>{{ $notification->user->display_name }}</h6>
                                                    <p>{{ $notification->content }}</p>
                                                    <p class="f-8 font-primary mb-0">{{ $notification->time_ago }}
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach

                                    <li class="text-center"> <a class="f-w-700"
                                            href="{{ aurl('notifications') }}">{{ trans('admin.View All') }} </a>
                                    </li>
                                </ul>
                            </div>
                        </li> --}}
                        {{-- <li class="onhover-dropdown" id="orderCountButton">
                            <div class="notification-box"><i data-feather="shopping-cart"></i>
                                @if (newOrdersCount()->count() > 0)
                                    <span id="orderCountButtonArea"
                                        class="badge rounded-pill badge-secondary">{{ newOrdersCount()->count() > 20 ? '20+' : newOrdersCount()->count() }}</span>
                                @endif
                            </div>
                            <div class="chat-dropdown onhover-show-div card-notification">
                                <h6 class="f-18 mb-0 dropdown-title">{{ trans('admin.Online Orders') }} </h6>
                                <ul class="py-0">
                                    @foreach (newOrders() as $order)
                                        <li>
                                            <a href="{{ aurl('orders/view/' . $order->model_id) }}"
                                                style="text-decoration-line: none">
                                                <div class="media"><img class="img-fluid b-r-5 me-2"
                                                        src="{{ asset('dashboard/assets/images/avatar.png') }}"
                                                        alt="">
                                                    <div class="media-body">
                                                        <h6>{{ trans('admin.New Orders') }}</h6>
                                                        <p>{{ $order->content }}</p>
                                                        <p class="f-8 font-primary mb-0">{{ $order->time_ago }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                    <li class="text-center"> <a class="f-w-700"
                                            href="{{ aurl('orders/new') }}">{{ trans('admin.View All') }}
                                        </a></li>
                                </ul>
                            </div>
                        </li> --}}

                        {{-- <li class="onhover-dropdown" id="orderCountButton">
                            <div class="notification-box"><i class="fas fa-pizza-slice"></i>
                                @if (newBoardOrdersCount()->count() > 0)
                                    <span id="boardOrderCountButtonArea"
                                        class="badge rounded-pill badge-secondary">{{ newBoardOrdersCount()->count() > 20 ? '20+' : newBoardOrdersCount()->count() }}</span>
                                @endif
                            </div>
                            <div class="chat-dropdown onhover-show-div card-notification">
                                <h6 class="f-18 mb-0 dropdown-title">{{ trans('admin.Board Orders') }} </h6>
                                <ul class="py-0">
                                    @foreach (newBoardOrders() as $order)
                                        <li>
                                            <a href="{{ aurl('boards/orders/view/' . $order->model_id) }}"
                                                style="text-decoration-line: none">
                                                <div class="media"><img class="img-fluid b-r-5 me-2"
                                                        src="{{ asset('dashboard/assets/images/avatar.png') }}"
                                                        alt="">
                                                    <div class="media-body">
                                                        <h6 class="text-warning">{{ $order->title }}</h6>
                                                        <p>{{ $order->content }}</p>
                                                        <p class="f-8 font-primary mb-0">{{ $order->time_ago }}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                    <li class="text-center"> <a class="f-w-700"
                                            href="{{ aurl('boards/orders/new') }}">{{ trans('admin.View All') }}
                                        </a></li>
                                </ul>
                            </div>
                        </li> --}}

                        <li class="maximize"><a class="text-dark" href="#!"
                                onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a></li>
                        <li class="profile-nav onhover-dropdown p-0 me-0">
                            <div class="media profile-media"><img class="b-r-10"
                                    src="{{ asset('dashboard') }}/assets/images/avatar.png" style="height: 35px"
                                    alt="">
                                <div class="media-body"><span>{{ adminLogin()->name }}</span>
                                    <p class="mb-0 font-roboto">
                                        <i class="middle fa fa-angle-down"></i>
                                    </p>
                                </div>
                            </div>
                            <ul class="profile-dropdown onhover-show-div">
                                <li><a href="#"><i data-feather="user"></i><span>{{ trans('admin.Account') }}
                                        </span></a></li>
                                <li><a href="#"><i
                                            data-feather="settings"></i><span>{{ trans('admin.Settings') }}</span></a>
                                </li>
                                <li><a href="{{ aurl('logout') }}"><i data-feather="log-in">
                                        </i><span>{{ trans('admin.Log Out') }}</a></span></a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Page Header Ends                              -->
