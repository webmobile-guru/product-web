<!-- Javascript -->
<script type="text/javascript" src="{{ asset('js/jquery.easing.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/owl.carousel.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery-waypoints.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/smoothscroll.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/menu_script.js') }}"></script>

<!-- Revolution Slider -->
<script type="text/javascript" src="{{ asset('js/jquery.themepunch.tools.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/jquery.themepunch.revolution.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/slider.js') }}"></script>
<script>
$(document).ready(function () {
    $('#select_country').attr('data-selected-country','EN');
    $('#select_country').flagStrap();
		
});
</script>
<!-- Page level Scripts -->
<script type="text/javascript"> var baseURL = '{!! url('/') !!}/'; $(document).ready(function(){ $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } }); }); </script>
@stack('js')
