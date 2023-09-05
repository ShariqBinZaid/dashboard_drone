<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
    data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <!--begin::Logo image-->
        <a href="{{ route('dashboard') }}">
            <img alt="Logo" src="{{ asset('assets/media/logos/logo-w.png') }}" {{-- <img alt="Logo" src="{{ asset('assets/media/logos/default-dark.svg') }}" --}}
                class="h-55px w-100 app-sidebar-logo-default" />
            <img alt="Logo" src="{{ asset('assets/media/logos/logo-w.png') }}" {{-- <img alt="Logo" src="{{ asset('assets/media/logos/default-small.svg') }}" --}}
                class="h-10px w-100 app-sidebar-logo-minimize" />
        </a>
        <!--end::Logo image-->
        <!--begin::Sidebar toggle-->
        <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">
            <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
            <span class="svg-icon svg-icon-2 rotate-180">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.5"
                        d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z"
                        fill="currentColor" />
                    <path
                        d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z"
                        fill="currentColor" />
                </svg>
            </span>
            <!--end::Svg Icon-->
        </div>
        <!--end::Sidebar toggle-->
    </div>
    <!--end::Logo-->
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
        <!--begin::Menu wrapper-->
        <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5"
            data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
            data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
            data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">

            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <a href="{{ route('dashboard') }}">
                        <span class="menu-link">
                            <span class="menu-icon {{ request()->is('dashboard') ? 'active' : '' }}">
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect x="2" y="2" width="9" height="9" rx="2"
                                            fill="currentColor"></rect>
                                        <rect opacity="0.3" x="13" y="2" width="9" height="9"
                                            rx="2" fill="currentColor"></rect>
                                        <rect opacity="0.3" x="13" y="13" width="9" height="9"
                                            rx="2" fill="currentColor"></rect>
                                        <rect opacity="0.3" x="2" y="13" width="9" height="9"
                                            rx="2" fill="currentColor"></rect>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Dashboard</span>
                        </span>
                    </a>
                </div>

            </div>

            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <a href="{{ route('user.index') }}">
                        <span class="menu-link">
                            <span class="menu-icon {{ request()->is('user') ? 'active' : '' }}">
                                <span class="svg-icon svg-icon-2">
                                    <svg fill="currentColor" width="800px" height="800px" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M15.71,12.71a6,6,0,1,0-7.42,0,10,10,0,0,0-6.22,8.18,1,1,0,0,0,2,.22,8,8,0,0,1,15.9,0,1,1,0,0,0,1,.89h.11a1,1,0,0,0,.88-1.1A10,10,0,0,0,15.71,12.71ZM12,12a4,4,0,1,1,4-4A4,4,0,0,1,12,12Z" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">User</span>
                        </span>
                    </a>
                </div>

            </div>

            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <a href="{{ route('categories.index') }}">
                        <span class="menu-link">
                            <span class="menu-icon {{ request()->is('user') ? 'active' : '' }}">
                                <span class="svg-icon svg-icon-2">
                                    <svg width="800px" height="800px" viewBox="0 0 512 512" version="1.1"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <title>Categories</title>
                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none"
                                            fill-rule="evenodd">
                                            <g id="icon" fill="currentColor"
                                                transform="translate(64.000000, 34.346667)">
                                                <path
                                                    d="M192,7.10542736e-15 L384,110.851252 L384,332.553755 L192,443.405007 L1.42108547e-14,332.553755 L1.42108547e-14,110.851252 L192,7.10542736e-15 Z M127.999,206.918 L128,357.189 L170.666667,381.824 L170.666667,231.552 L127.999,206.918 Z M42.6666667,157.653333 L42.6666667,307.920144 L85.333,332.555 L85.333,182.286 L42.6666667,157.653333 Z M275.991,97.759 L150.413,170.595 L192,194.605531 L317.866667,121.936377 L275.991,97.759 Z M192,49.267223 L66.1333333,121.936377 L107.795,145.989 L233.374,73.154 L192,49.267223 Z"
                                                    id="Combined-Shape">

                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Categories</span>
                        </span>
                    </a>
                </div>

            </div>

            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <a href="{{ route('subscriptions.index') }}">
                        <span class="menu-link">
                            <span class="menu-icon {{ request()->is('user') ? 'active' : '' }}">
                                <span class="svg-icon svg-icon-2">
                                    <svg width="800px" height="800px" viewBox="0 0 64 64" data-name="Layer 1"
                                        id="Layer_1" xmlns="http://www.w3.org/2000/svg">
                                        <defs>
                                            <style>
                                                .cls-1 {
                                                    fill: #fff;
                                                }

                                                .cls-2 {
                                                    fill: #fff;
                                                }
                                            </style>
                                        </defs>
                                        <title />
                                        <path class="cls-1"
                                            d="M57.43,50.5H52.26a2,2,0,1,1,0-4h3.17v-29H8.57v29H40.48a2,2,0,0,1,0,4H6.57a2,2,0,0,1-2-2v-33a2,2,0,0,1,2-2H57.43a2,2,0,0,1,2,2v33A2,2,0,0,1,57.43,50.5Z" />
                                        <path class="cls-1"
                                            d="M57.43,27.36H6.57a2,2,0,0,1-2-2V15.5a2,2,0,0,1,2-2H57.43a2,2,0,0,1,2,2v9.86A2,2,0,0,1,57.43,27.36Zm-48.86-4H55.43V17.5H8.57Z" />
                                        <path class="cls-2"
                                            d="M17.87,38.86H13.32a2,2,0,0,1,0-4h4.55a2,2,0,1,1,0,4Z" />
                                        <path class="cls-2" d="M32.34,38.86h-8.4a2,2,0,1,1,0-4h8.4a2,2,0,0,1,0,4Z" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Subscriptions</span>
                        </span>
                    </a>
                </div>

            </div>

            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <a href="{{ route('place.index') }}">
                        <span class="menu-link">
                            <span class="menu-icon {{ request()->is('user') ? 'active' : '' }}">
                                <span class="svg-icon svg-icon-2">
                                    <svg fill="#fff" width="800px" height="800px" viewBox="0 0 24 24"
                                        id="maps-location-place-right" data-name="Line Color"
                                        xmlns="http://www.w3.org/2000/svg" class="icon line-color">
                                        <path id="primary"
                                            d="M19,9h1a1,1,0,0,1,1,1V20a1,1,0,0,1-1,1H4a1,1,0,0,1-1-1V10A1,1,0,0,1,4,9h8"
                                            style="fill: none; stroke: rgb(255, 255, 255); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;">
                                        </path>
                                        <path id="primary-2" data-name="primary" d="M8,17l3-8m10,8H3m12,4V17"
                                            style="fill: none; stroke: rgb(255, 255, 255); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;">
                                        </path>
                                        <path id="secondary"
                                            d="M19,6.5a3.5,3.5,0,0,0-7,0C12,10,15.5,13,15.5,13S19,10,19,6.5Z"
                                            style="fill: none; stroke: rgb(44, 169, 188); stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;">
                                        </path>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Best Place</span>
                        </span>
                    </a>
                </div>

            </div>

            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <a href="{{ route('posts.index') }}">
                        <span class="menu-link">
                            <span class="menu-icon {{ request()->is('user') ? 'active' : '' }}">
                                <span class="svg-icon svg-icon-2">
                                    <svg fill="#fff" width="800px" height="800px" viewBox="0 0 32 32"
                                        style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;"
                                        version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"
                                        xmlns:serif="http://www.serif.com/"
                                        xmlns:xlink="http://www.w3.org/1999/xlink">

                                        <g id="Layer1">

                                            <path
                                                d="M16,6l-13,0c-0.552,0 -1,0.448 -1,1l0,22c0,0.552 0.448,1 1,1l22,0c0.552,0 1,-0.448 1,-1l0,-13c0,-0.552 -0.448,-1 -1,-1c-0.552,-0 -1,0.448 -1,1l0,12c0,0 -20,0 -20,0c0,0 0,-20 0,-20c-0,0 12,0 12,0c0.552,0 1,-0.448 1,-1c0,-0.552 -0.448,-1 -1,-1Zm-9,19l14,-0c0.552,0 1,-0.448 1,-1c0,-0.552 -0.448,-1 -1,-1l-14,0c-0.552,0 -1,0.448 -1,1c0,0.552 0.448,1 1,1Zm-0,-4l4,0c0.552,-0 1,-0.448 1,-1c-0,-0.552 -0.448,-1 -1,-1l-4,0c-0.552,-0 -1,0.448 -1,1c-0,0.552 0.448,1 1,1Zm22.707,-13.293c0.391,-0.39 0.391,-1.024 0,-1.414l-4,-4c-0.39,-0.391 -1.024,-0.391 -1.414,-0l-10,10c-0.14,0.139 -0.235,0.317 -0.274,0.511l-1,5c-0.065,0.328 0.037,0.667 0.274,0.903c0.236,0.237 0.575,0.339 0.903,0.274l5,-1c0.194,-0.039 0.372,-0.134 0.511,-0.274l10,-10Zm-22.707,9.293l4,0c0.552,0 1,-0.448 1,-1c0,-0.552 -0.448,-1 -1,-1l-4,0c-0.552,0 -1,0.448 -1,1c0,0.552 0.448,1 1,1Zm0,-4l5,-0c0.552,0 1,-0.448 1,-1c0,-0.552 -0.448,-1 -1,-1l-5,-0c-0.552,0 -1,0.448 -1,1c0,0.552 0.448,1 1,1Z" />

                                        </g>

                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Posts</span>
                        </span>
                    </a>
                </div>

            </div>

            {{-- <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <a href="{{ route('parent.index') }}">
                        <span class="menu-link">
                            <span class="menu-icon {{ request()->is('parent') ? 'active' : '' }}">
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.5 11C8.98528 11 11 8.98528 11 6.5C11 4.01472 8.98528 2 6.5 2C4.01472 2 2 4.01472 2 6.5C2 8.98528 4.01472 11 6.5 11Z"
                                            fill="currentColor" />
                                        <path opacity="0.3"
                                            d="M13 6.5C13 4 15 2 17.5 2C20 2 22 4 22 6.5C22 9 20 11 17.5 11C15 11 13 9 13 6.5ZM6.5 22C9 22 11 20 11 17.5C11 15 9 13 6.5 13C4 13 2 15 2 17.5C2 20 4 22 6.5 22ZM17.5 22C20 22 22 20 22 17.5C22 15 20 13 17.5 13C15 13 13 15 13 17.5C13 20 15 22 17.5 22Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Parents</span>
                        </span>
                    </a>
                </div>

            </div>

            <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                data-kt-menu="true" data-kt-menu-expand="false">

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    <a href="{{ route('packages.index') }}">
                        <span class="menu-link">
                            <span class="menu-icon {{ request()->is('parent') ? 'active' : '' }}">
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6.5 11C8.98528 11 11 8.98528 11 6.5C11 4.01472 8.98528 2 6.5 2C4.01472 2 2 4.01472 2 6.5C2 8.98528 4.01472 11 6.5 11Z"
                                            fill="currentColor" />
                                        <path opacity="0.3"
                                            d="M13 6.5C13 4 15 2 17.5 2C20 2 22 4 22 6.5C22 9 20 11 17.5 11C15 11 13 9 13 6.5ZM6.5 22C9 22 11 20 11 17.5C11 15 9 13 6.5 13C4 13 2 15 2 17.5C2 20 4 22 6.5 22ZM17.5 22C20 22 22 20 22 17.5C22 15 20 13 17.5 13C15 13 13 15 13 17.5C13 20 15 22 17.5 22Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Packages</span>

                        </span>
                    </a>
                </div>

            </div> --}}





        </div>
    </div>
</div>
