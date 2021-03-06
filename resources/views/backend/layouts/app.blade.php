<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <meta name="description" content="This is an example dashboard created using build-in elements and components.">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="csrf-token" content="{{csrf_token()}}">
 
    <link href="{{asset('backend/css/main.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('backend/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
</head>
<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
        
        @include('backend.layouts.header')
        
        <div class="app-main">

            @include('backend.layouts.sidebar')

            <div class="app-main__outer">
                <div class="app-main__inner">
                    @yield('content')
                </div>

                @include('backend.layouts.footer')   
            </div>
        </div>
    </div>
<script type="text/javascript" src="{{asset('backend/js/main.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@yield('script')
<script>
    $(document).ready(function() {
        let token = document.head.querySelector('meta[name="csrf-token"]');

        if(token) {
            $.ajaxSetup({
                headers : {
                    'X-CSRF-TOKEN' : token.content
                }
            })
        }

        $('.back-btn').on('click', function() {
            window.history.go(-1);
            return false;
        })

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        @if(session('created'))
            Toast.fire({
                icon: 'success',
                title: '{{session('created')}}'
            })
        @endif

        @if(session('updated'))
            Toast.fire({
                icon: 'success',
                title: '{{session('updated')}}'
            })
        @endif

        window.Toast = Toast;
    })
</script>
</body>
</html>
