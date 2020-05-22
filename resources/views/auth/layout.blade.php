<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    @include('front.layout.htmlheader')

<body class="login_bg">
    <!--login section start-->
    @yield('content')
    <!--login section end-->



    @include('front.layout.scripts')
</body>
</html>
