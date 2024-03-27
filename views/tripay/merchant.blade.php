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

    <div class="container" style="margin-top: 100px;">
        <div class="row">
            @foreach ($data as $item)
                <div class="col-md-3 mb-5">
                    <div class="card">
                        <div class="card-header">
                            <img src="{{ $item['icon_url'] }}" class="card-img-top" alt="{{ $item['name'] }}">
                        </div>
                        <div class="card-body">
                            {{-- <h4 class="card-title">{{ $item['name'] }}</h4> --}}
                            <p class="card-text">Code : <b>{{ $item['code'] }}</b></p>
                            {{-- <p class="card-text">Type: {{ $item['type'] }}</p>
                            <p class="card-text">Fee Merchant: {{ $item['fee_merchant']['flat'] }} + {{ $item['fee_merchant']['percent'] }}%</p>
                            <p class="card-text">Fee Customer: {{ $item['fee_customer']['flat'] }} + {{ $item['fee_customer']['percent'] }}%</p> --}}
                            <p class="card-text">Admin Fee : <b>{{ $item['total_fee']['flat'] }} +
                                    {{ $item['total_fee']['percent'] }}%</b></p>
                            <p class="card-text">Active : <b>{{ $item['active'] ? 'Yes' : 'No' }}</b></p>
                        </div>
                        <div class="card-footer">
                            <button data-pc-animate="blur" type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#animateModal{{ $item['code'] }}">
                                Bayar
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Modal --}}

                <div class="modal fade modal-animate anim-blur" id="animateModal{{ $item['code'] }}" tabindex="-1"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Payment Method - {{ $item['code'] }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                </button>
                            </div>
                            <form action="{{ route('tripay.merchantstore') }}" enctype="multipart/form-data" method="POST"
                            class="needs-validation" novalidate="">
                            @csrf
                                <div class="modal-body">
                                    <label class="form-label" for="invoice_number">Invoice Number Tagihan <sup
                                            class="text-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                                            data-bs-original-title="wajib di isi untuk pemberitahuan melalui email">*</sup></label>
                                    <input type="text" class="form-control" name="invoice_number" id="invoice_number"
                                        value="" placeholder="INVxxxxxxx" required>
                                    <input type="hidden" hidden aria-hidden="true" class="form-control" name="code" id="code"
                                        value="{{ $item['code'] }}" required>
                                    <div class="valid-feedback"> Looks good! </div>
                                    <div class="invalid-feedback"> Harap isi invoice number tagihan. </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary shadow-2">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="{{ asset('/js/jquery.min.js') }}"></script>
    <!-- Required Js -->
    <script src="{{ asset('/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('/js/config.js') }}"></script>
    <script src="{{ asset('/js/pcoded.js') }}"></script>
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
    {{-- @include('tripay::header') --}}
    @include('tripay::footer')
</body>

</html>
