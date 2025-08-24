<div id="kt_header" style="" class="header align-items-stretch">
    <!--begin::Container-->
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <!--begin::Aside mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show aside menu">
            <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px"
                id="kt_aside_mobile_toggle">
                <!--begin::Svg Icon | path: icons/duotune/abstract/abs015.svg-->
                <span class="mt-1 svg-icon svg-icon-2x">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none">
                        <path d="M21 7H3C2.4 7 2 6.6 2 6V4C2 3.4 2.4 3 3 3H21C21.6 3 22 3.4 22 4V6C22 6.6 21.6 7 21 7Z"
                            fill="black" />
                        <path opacity="0.3"
                            d="M21 14H3C2.4 14 2 13.6 2 13V11C2 10.4 2.4 10 3 10H21C21.6 10 22 10.4 22 11V13C22 13.6 21.6 14 21 14ZM22 20V18C22 17.4 21.6 17 21 17H3C2.4 17 2 17.4 2 18V20C2 20.6 2.4 21 3 21H21C21.6 21 22 20.6 22 20Z"
                            fill="black" />
                    </svg>
                </span>
                <!--end::Svg Icon-->
            </div>
        </div>
        <!--end::Aside mobile toggle-->
        <!--begin::Mobile logo-->
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="../../demo1/dist/index.html" class="d-lg-none">
                <img alt="Logo" class="h-30px" />
            </a>
        </div>
        <!--end::Mobile logo-->
        <!--begin::Wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
            <!--begin::Navbar-->
            <div class="d-flex align-items-stretch" id="kt_header_nav">
                <!--begin::Menu wrapper-->
                <div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu"
                    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true"
                    data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="end"
                    data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true"
                    data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
                    <!--begin::Menu-->


                    <div class="my-5 menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-lg-0 align-items-stretch"
                        id="#kt_header_menu" data-kt-menu="true">
                        <div class="menu-item me-lg-1">
                            <a class="menu-link {{ request()->routeIs('home') ? 'active' : '' }} py-3"
                                href="{{ route('home') }}">
                                <span class="menu-title fs-6">@lang('message.home')</span>
                            </a>
                        </div>

                    </div>

                    {{--
                    <div class="menu-item me-lg-1">
                        <a class="menu-link {{ Request::routeIs('course.index') || Request::routeIs('course.create') || Request::routeIs('course.edit') ? 'active' : '' }}  py-3"
                            href="{{ route('course.create') }}">
                            <span class="menu-title fs-6">Add Course</span>
                        </a>
                    </div>
                    <!-- Add this inside the header menu -->
                    <div class="menu-item me-lg-1">
                        <a class="menu-link {{ Request::routeIs('coupons.index') || Request::routeIs('coupons.create') || Request::routeIs('coupons.edit') ? 'active' : '' }} py-3"
                            href="{{ route('coupons.create') }}">
                            <span class="menu-title fs-6">Add Coupon</span>
                        </a>
                    </div>

                    <div class="menu-item me-lg-1">

                        <a class="py-3 menu-link" href="{{ route('youtube') }}">
                            <span class="menu-title fs-6">Fetch New PLaylist</span>
                        </a>
                    </div>
                    <div class="menu-item me-lg-1">

                        <a class="py-3 menu-link" href="{{ route('fetchShorts') }}">
                            <span class="menu-title fs-6">Fetch New Short Video</span>
                        </a>
                    </div>

--}}

                    <!--end::Menu-->
                </div>
                <!--end::Menu wrapper-->
            </div>
            <!--end::Navbar-->
            <!--begin::Topbar-->
                <!--begin::Toolbar wrapper-->
                <div class="flex-shrink-0 d-flex align-items-stretch">

{{--
                    <div class="d-flex align-items-center ms-1 ms-lg-3">
                        <!--begin::Menu wrapper-->
                        <div class="cursor-pointer symbol symbol-30px" data-kt-menu-trigger="click"
                             data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                            @if(app()->getLocale() === 'ar')
                                <img src="{{ asset('assets/media/flags/saudi-arabia.svg') }}" alt="AR" class="rounded-circle"/>
                            @else
                                <img src="{{ asset('assets/media/flags/united-kingdom.svg') }}" alt="EN" class="rounded-circle"/>
                            @endif
                        </div>

                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg
                menu-state-primary fw-bold fs-6 w-150px py-3" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="{{ url('locale/ar') }}"
                                   class="menu-link px-3 {{ app()->getLocale() === 'ar' ? 'active' : '' }}">
                                    <img src="{{ asset('assets/media/flags/saudi-arabia.svg') }}" width="18" class="me-2 rounded-circle"/>
                                    العربية
                                </a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="{{ url('locale/en') }}"
                                   class="menu-link px-3 {{ app()->getLocale() === 'en' ? 'active' : '' }}">
                                    <img src="{{ asset('assets/media/flags/united-kingdom.svg') }}" width="18" class="me-2 rounded-circle"/>
                                    English
                                </a>
                            </div>
                        </div>
                    </div>
--}}

                    <!--begin::User-->
                    <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
                        <!--begin::Menu wrapper-->
                        <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click"
                            data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                            @if(\Illuminate\Support\Facades\Auth::user()->image??"")
                                <img alt="Logo"
                                     src="{{ \Illuminate\Support\Facades\Storage::disk('s3')->url(\Illuminate\Support\Facades\Auth::user()->image) }}" />
                            @else

                                <img src="{{ asset('assets/media/avatars/150-26.jpg') }}" alt="user" />
                            @endif
                        </div>
                        <!--begin::Menu-->
                        <div class="py-4 menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold fs-6 w-275px"
                            data-kt-menu="true">
                            <!--begin::Menu item-->
                            <div class="px-3 menu-item">
                                <div class="px-3 menu-content d-flex align-items-center">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-50px me-5">
                                        @if(\Illuminate\Support\Facades\Auth::user()->image??"")
                                            <img alt="Logo"
                                                 src="{{ \Illuminate\Support\Facades\Storage::disk('s3')->url(\Illuminate\Support\Facades\Auth::user()->image) }}" />
                                        @else
                                            <img alt="Logo" src="{{ asset('assets/media/avatars/150-26.jpg') }}" />
                                        @endif
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Username-->
                                    <div class="d-flex flex-column ">
                                        <div class="fw-bolder d-flex align-items-center fs-5">
                                            {{ \Illuminate\Support\Facades\Auth::user()->full_name ?? '' }}

                                        </div>
                                        <a href="#"
                                            class="fw-bold text-muted text-hover-primary fs-7">{{ \Illuminate\Support\Facades\Auth::user()->email ?? '' }}</a>
                                    </div>

                                    <!--end::Username-->
                                </div>
                            </div>
                            <!--end::Menu item-->
                            <div class="my-2 separator"></div>


                            <!--begin::Menu item-->
                            <div class="px-5 menu-item">
                                <a class="px-5 menu-link" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('message.logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                            </div>
                            <!--end::Menu item-->

                        </div>

                        <!--end::Menu-->
                        <!--end::Menu wrapper-->
                    </div>
                    <!--end::Menu-->

                    <!--end::User -->
                    <!--begin::Heaeder menu toggle-->

                    <!--end::Heaeder menu toggle-->
                </div>
                <!--end::Toolbar wrapper-->
            <!--end::Topbar-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Container-->
</div>
