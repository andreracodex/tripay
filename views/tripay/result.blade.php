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

        <h1>Payment Details</h1>
        <ul class="mt-3">
            <li>Nomor Refrensi Bayar:</li>
                <p><b><i>{{ $data['reference'] }}</i></b></p>
            <li>Merchant Ref:</li>
                <p><b><i>{{ $data['merchant_ref'] }}</i></b></p>
            <li>Payment Name:</li>
                <p><b><i>{{ $data['payment_name'] }}</i></b></p>
            <li>Customer Name:</li>
                <p><b><i>{{ $data['customer_name'] }}</i></b></p>
            <li>Customer Email:</li>
                <p><b><i>{{ $data['customer_email'] }}</i></b></p>
            <li>Customer Phone:</li>
                <p><b><i>{{ $data['customer_phone'] }}</i></b></p>
            <li>Jumlah yang Harus Dibayar:</li>
                <p><b><i>{{ Number::currency($data['amount'], in: 'IDR', locale: 'id') }}</i></b></p>
            <li>Customer Fee: </li>
                <p><b><i>{{ Number::currency($data['fee_merchant'], in: 'IDR', locale: 'id') }}</i></b></p>
            <li>Harga Paket: </li>
                <p><b><i>{{ Number::currency($data['amount_received'], in: 'IDR', locale: 'id') }}</i></b></p>
            <li>Pay Code (Virtual Number): </li>
                <p><b><i>{{ $data['pay_code'] }}</i></b></p>
            <li>Status: </li>
                <p><b><i>{{ $data['status'] }}</i></b></p>
            <li>Expired Time to Pay: </li>
                <p><b><i>{{ date('Y-m-d H:i', $data['expired_time']) }}</i></b></p>
        </ul>

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
    @include('tripay::header')
    @include('tripay::footer')
</body>

</html>
