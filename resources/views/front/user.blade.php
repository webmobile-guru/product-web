<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
@include('front.layout.htmlheader')
    <body>
        @yield('content')

        <!--footer section start-->
        @include('front.layout.footer')
        <!--footer section end-->

        @include('front.layout.scripts')
    </body>
</html>
