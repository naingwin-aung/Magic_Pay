<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <!-- Font-Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Daterange Picker -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>
<body>
    <div class="header__menu">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row header__height">
                    <div class="col-2 text-right">
                        @if (!request()->is('/'))
                            <a href="#" class="back-btn">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        @endif
                    </div>
                    <div class="col-8">
                        <a href="#">
                            <h4 class="text-center">@yield('title')</h4>
                        </a>
                    </div>
                    <div class="col-2">
                        <a href="{{route('notification')}}">
                            <i class="fas fa-bell"></i> 
                            @if ($unread_noti_count != 0)
                                <span class="badge badge-pill badge-danger noti_badge">
                                    {{$unread_noti_count}}
                                </span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!--Scan Circle-->
    <a href="{{route('scanAndPay')}}" class="scan__circle">
        <div class="inside">
            <i class="fas fa-qrcode"></i>
        </div>
    </a>

    <div class="bottom__menu">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row text-center">
                    <div class="col-3 px-2">
                        <a href="{{route('home')}}">
                            <i class="fas fa-home"></i>
                            <p>Home</p>
                        </a>
                    </div>
                    <div class="col-3 px-2">
                        <a href="{{route('wallet')}}">
                            <i class="fas fa-wallet"></i>
                            <p>Wallet</p>
                        </a>
                    </div>
                    <div class="col-3 px-2">
                        <a href="{{route('transaction')}}">
                            <i class="fas fa-exchange-alt"></i>
                            <p>Transaction</p>
                        </a>
                    </div>
                    <div class="col-3 px-2">
                        <a href="{{route('profile')}}">
                            <i class="fas fa-user"></i>
                            <p>Profile</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script src="//unpkg.com/jscroll/dist/jquery.jscroll.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
@yield('script')
<script>
    $(document).ready(function() {
        $('.back-btn').on('click', function() {
            window.history.go(-1);
            return false;
        })
    })
</script>
</body>
</html>
