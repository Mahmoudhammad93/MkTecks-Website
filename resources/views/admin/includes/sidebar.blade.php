<!-- Page Body Start-->
<div class="page-body-wrapper">
    <!-- Page Sidebar Start-->
    <div class="sidebar-wrapper">
        <div>
            <div class="logo-wrapper">
                <a href="{{ aurl('/') }}">
                    <img class="img-fluid" style="max-width: 70% ; max-height: 50px" src="{{ settings()->logo }}"
                        alt="">
                    {{-- <h3>{{ trans('admin.app_name') }}</h3> --}}
                </a>
                <div class="back-btn"><i class="fa fa-angle-left"></i></div>
                <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i>
                </div>
            </div>
            <div class="logo-icon-wrapper">
                <a href="{{ aurl('/') }}">
                    {{-- <img class="img-fluid"src="{{ asset('dashboard') }}/assets/images/logo/logo-icon.png" alt=""> --}}
                    <h3>{{ settings()->name }}</h3>
                </a>
            </div>
            <nav class="sidebar-main">
                <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                <div id="sidebar-menu">
                    <ul class="sidebar-links" id="simple-bar">
                        <li class="back-btn"><a href="{{ aurl('/') }}"><img class="img-fluid"
                                    src="{{ asset('dashboard') }}/assets/images/favicon.png" alt=""></a>
                            <div class="mobile-back text-end"><span>{{ trans('admin.Back') }}</span><i class="fa fa-angle-right ps-2"
                                    aria-hidden="true"></i></div>
                        </li>
                        @if (is_permited('browse_dashboard') == 1)
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ aurl('/') }}">
                                <i data-feather="home"> </i><span>{{ trans('admin.Dashboard') }}</span>
                            </a>
                        </li>
                        @endif
                        @if (is_permited('browse_admins') == 1)
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title">
                                <i data-feather="user"></i><span>{{ trans('admin.Admins') }} <i
                                        class="fa fa-angle-right pull-right" style="margin-top: 5px"></i></span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ aurl('admins') }}">{{ trans('admin.All Admins') }}</a></li>
                                <li><a href="{{ aurl('admins/create') }}">{{ trans('admin.Add New Admin') }}</a>
                                </li>
                                <li><a href="{{ aurl('admins/deleted') }}">{{ trans('admin.All Deleted Admins') }}</a>
                                </li>
                                <li><a href="{{ aurl('admins/logs') }}">{{ trans('admin.Admin Log') }}</a></li>
                            </ul>
                        </li>
                        @endif
                        @if (is_permited('browse_roles') == 1)
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title">
                                <i data-feather="unlock"></i>
                                <span>{{ trans('admin.Roles') }} <i class="fa fa-angle-right pull-right"
                                        style="margin-top: 5px"></i></span>

                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ aurl('roles') }}">{{ trans('admin.All Roles') }}</a></li>
                                <li><a href="{{ aurl('roles/create') }}">{{ trans('admin.Add New Role') }}</a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        
                        @if (is_permited('browse_services') == 1)
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title">
                                <i data-feather="unlock"></i>
                                <span>{{ trans('admin.Services') }} <i class="fa fa-angle-right pull-right"
                                        style="margin-top: 5px"></i></span>

                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ aurl('services') }}">{{ trans('admin.All Services') }}</a></li>
                                <li><a href="{{ aurl('services/create') }}">{{ trans('admin.Add New Service') }}</a>
                                </li>
                            </ul>
                        </li>
                        @endif

                        @if (is_permited('browse_team') == 1)
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title">
                                <i data-feather="unlock"></i>
                                <span>{{ trans('admin.Team') }} <i class="fa fa-angle-right pull-right"
                                        style="margin-top: 5px"></i></span>

                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ aurl('team') }}">{{ trans('admin.All Team') }}</a></li>
                            </ul>
                        </li>
                        @endif

                        @if (is_permited('browse_projects') == 1)
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title">
                                <i data-feather="unlock"></i>
                                <span>{{ trans('admin.Projects') }} <i class="fa fa-angle-right pull-right"
                                        style="margin-top: 5px"></i></span>

                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ aurl('projects') }}">{{ trans('admin.All Projects') }}</a></li>
                            </ul>
                        </li>
                        @endif

                        @if (is_permited('browse_settings') == 1)
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title">
                                <i data-feather="settings"></i><span>{{ trans('admin.Settings') }} <i
                                        class="fa fa-angle-right pull-right" style="margin-top: 5px"></i></span>
                            </a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ aurl('settings') }}">{{ trans('admin.Site Data') }}</a></li>
                                {{-- <li><a href="{{ aurl('settings/terms') }}">{{ trans('admin.Terms') }}</a></li> --}}
                            </ul>
                        </li>
                        @endif
                        <li class="sidebar-list">
                            <a class="sidebar-link sidebar-title link-nav" href="{{ aurl('contact_us') }}">
                                <i data-feather="phone"> </i><span>{{ trans('admin.Contact Us') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
            </nav>
        </div>
    </div>
    <!-- Page Sidebar Ends-->
    <div class="page-body">
        <br>
        <!-- Container-fluid starts-->
