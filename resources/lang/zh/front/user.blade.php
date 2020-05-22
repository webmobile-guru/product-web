<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
@include('front.layout.htmlheader')
<body class="header-sticky">
<section class="loading-overlay">
    <div class="Loading-Page">
        <h2 class="loader">Loading...</h2>
    </div>
</section>

<!-- Boxed -->
<div class="boxed">
    @include('front.layout.top-nav')
    @include('front.layout.header')

    <!-- Flat imagebox -->
    @yield('content')

    @include('front.layout.footer')

</div>

@include('front.layout.scripts')
<script>
	$(document).on('click', '#profile-image1', function(){ 
			$('#profile-image-upload').click();
	});
</script> 
</body>
</html>
