<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="{{ $profile[42]->value }}" />
    <meta name="keywords" content="{{ $profile[43]->value }}" />
    <meta name="author" content="{{ $profile[5]->value }}" />

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset($profile[2]->value) }}" type="image/x-icon" />

    <!-- [Page specific CSS] start -->
    <link href="{{ asset('/css/plugins/animate.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- [Page specific CSS] end -->
    <!-- [Font] Family -->
    <link rel="stylesheet" href="{{ asset('/fonts/inter/inter.css') }}" id="main-font-link" />

    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('/fonts/tabler-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('/css/style-preset.css') }}" />
    <link rel="stylesheet" href="{{ asset('/css/landing.css') }}" />
</head>

<body class="landing-page">
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    @include('tripay::header')

    <div class="container" style="margin-top: 100px;">
        <div class="card social-profile">
            <img src="{{ asset('/images/application/img-profile-cover.jpg') }}" alt="" class="w-100 card-img-top">
        </div>
        <h1>500</h1>
        <h3>Ooops, Failed To Load Payment Gateway</h3>
    </div>
    <script src="{{ asset('/js/jquery.min.js') }}"></script>
    <!-- Required Js -->
    <script src="{{ asset('/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('/js/config.js') }}"></script>
    <script src="{{ asset('/js/plugins/feather.min.js') }}"></script>

    <!-- [Page Specific JS] start -->
    <script src="{{ asset('/js/plugins/wow.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/Jarallax.js') }}"></script>
    <script>
        // Start [ Menu hide/show on scroll ]
        let ost = 0;
        document.addEventListener('scroll', function() {
            let cOst = document.documentElement.scrollTop;
            if (cOst == 0) {
                document.querySelector('.navbar').classList.add('top-nav-collapse');
            } else if (cOst > ost) {
                document.querySelector('.navbar').classList.add('top-nav-collapse');
                document.querySelector('.navbar').classList.remove('default');
            } else {
                document.querySelector('.navbar').classList.add('default');
                document.querySelector('.navbar').classList.remove('top-nav-collapse');
            }
            ost = cOst;
        });
        // End [ Menu hide/show on scroll ]
        var wow = new WOW({
            animateClass: 'animated'
        });
        wow.init();

        // slider start
        $('.screen-slide').owlCarousel({
            loop: true,
            margin: 30,
            center: true,
            nav: false,
            dotsContainer: '.app_dotsContainer',
            URLhashListener: true,
            items: 1
        });
        $('.workspace-slider').owlCarousel({
            loop: true,
            margin: 30,
            center: true,
            nav: false,
            dotsContainer: '.workspace-card-block',
            URLhashListener: true,
            items: 1.5
        });
        // slider end
        // marquee start
    </script>
    <!-- [Page Specific JS] end -->
    <div class="pct-c-btn">
        <a href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_pc_layout">
            <svg class="pc-icon">
                <use xlink:href="#custom-setting-2"></use>
            </svg>
        </a>
    </div>
    <div class="offcanvas border-0 pct-offcanvas offcanvas-end" tabindex="-1" id="offcanvas_pc_layout">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Settings</h5>
            <button type="button" class="btn btn-icon btn-link-danger" data-bs-dismiss="offcanvas"
                aria-label="Close"><i class="ti ti-x"></i></button>
        </div>
        <div class="pct-body" style="height: calc(100% - 85px)">
            <div class="offcanvas-body py-0">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="pc-dark">
                            <h6 class="mb-1">Theme Mode</h6>
                            <p class="text-muted text-sm">Choose light or dark mode or Auto</p>
                            <div class="row theme-layout">
                                <div class="col-4">
                                    <div class="d-grid">
                                        <button class="preset-btn btn" data-value="true"
                                            onclick="layout_change('light');">
                                            <svg class="pc-icon text-warning">
                                                <use xlink:href="#custom-sun-1"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="d-grid">
                                        <button class="preset-btn btn" data-value="false"
                                            onclick="layout_change('dark');">
                                            <svg class="pc-icon">
                                                <use xlink:href="#custom-moon"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="d-grid">
                                        <button class="preset-btn btn" data-value="default"
                                            onclick="layout_change_default();">
                                            <svg class="pc-icon">
                                                <use xlink:href="#custom-setting-2"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <h6 class="mb-1">Theme Contrast</h6>
                        <p class="text-muted text-sm">Choose theme contrast</p>
                        <div class="row theme-contrast">
                            <div class="col-6">
                                <div class="d-grid">
                                    <button class="preset-btn btn" data-value="true"
                                        onclick="layout_sidebar_change('true');">
                                        <svg class="pc-icon">
                                            <use xlink:href="#custom-mask"></use>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-grid">
                                    <button class="preset-btn btn" data-value="false"
                                        onclick="layout_sidebar_change('false');">
                                        <svg class="pc-icon">
                                            <use xlink:href="#custom-mask-1-outline"></use>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <h6 class="mb-1">Custom Theme</h6>
                        <p class="text-muted text-sm">Choose your Primary color</p>
                        <div class="theme-color preset-color">
                            <a href="#!" class="active" data-value="preset-1"><i class="ti ti-check"></i></a>
                            <a href="#!" data-value="preset-2"><i class="ti ti-check"></i></a>
                            <a href="#!" data-value="preset-3"><i class="ti ti-check"></i></a>
                            <a href="#!" data-value="preset-4"><i class="ti ti-check"></i></a>
                            <a href="#!" data-value="preset-5"><i class="ti ti-check"></i></a>
                            <a href="#!" data-value="preset-6"><i class="ti ti-check"></i></a>
                            <a href="#!" data-value="preset-7"><i class="ti ti-check"></i></a>
                            <a href="#!" data-value="preset-8"><i class="ti ti-check"></i></a>
                            <a href="#!" data-value="preset-9"><i class="ti ti-check"></i></a>
                            <a href="#!" data-value="preset-10"><i class="ti ti-check"></i></a>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <h6 class="mb-1">Sidebar Caption</h6>
                        <p class="text-muted text-sm">Sidebar Caption Hide/Show</p>
                        <div class="row theme-nav-caption">
                            <div class="col-6">
                                <div class="d-grid">
                                    <button class="preset-btn btn" data-value="true"
                                        onclick="layout_caption_change('true');">
                                        <img src="{{ asset('/images/customizer/img-caption-1.svg') }}" alt="img"
                                            class="img-fluid" width="70%" />
                                    </button>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-grid">
                                    <button class="preset-btn btn" data-value="false"
                                        onclick="layout_caption_change('false');">
                                        <img src="{{ asset('/images/customizer/img-caption-2.svg') }}" alt="img"
                                            class="img-fluid" width="70%" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="pc-rtl">
                            <h6 class="mb-1">Theme Layout</h6>
                            <p class="text-muted text-sm">LTR/RTL</p>
                            <div class="row theme-direction">
                                <div class="col-6">
                                    <div class="d-grid">
                                        <button class="preset-btn btn" data-value="false"
                                            onclick="layout_rtl_change('false');">
                                            <img src="{{ asset('/images/customizer/img-layout-1.svg') }}"
                                                alt="img" class="img-fluid" width="70%" />
                                        </button>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-grid">
                                        <button class="preset-btn btn" data-value="true"
                                            onclick="layout_rtl_change('true');">
                                            <img src="{{ asset('/images/customizer/img-layout-2.svg') }}"
                                                alt="img" class="img-fluid" width="70%" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="pc-container-width">
                            <h6 class="mb-1">Layout Width</h6>
                            <p class="text-muted text-sm">Choose Full or Container Layout</p>
                            <div class="row theme-container">
                                <div class="col-6">
                                    <div class="d-grid">
                                        <button class="preset-btn btn" data-value="false"
                                            onclick="change_box_container('false')">
                                            <img src="{{ asset('/images/customizer/img-container-1.svg') }}"
                                                alt="img" class="img-fluid" width="70%" />
                                        </button>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-grid">
                                        <button class="preset-btn btn" data-value="true"
                                            onclick="change_box_container('true')">
                                            <img src="{{ asset('/images/customizer/img-container-2.svg') }}"
                                                alt="img" class="img-fluid" width="70%" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-grid">
                            <button class="btn btn-light-danger" id="layoutreset">Reset Layout</button>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @include('tripay::footer')
</body>

</html>
