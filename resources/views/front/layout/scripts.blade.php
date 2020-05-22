
<script  src="{{ asset('/doch/js/jquery.min.js') }}"></script>
<script  src="{{ asset('/doch/js/bootstrap.min.js') }}"></script>
<script  src="{{ asset('/doch/js/popper.min.js') }}"></script>
<script  src="{{ asset('/doch/js/owl.carousel.js') }}"></script>
<script  src="{{ asset('/doch/js/custome.js') }}"></script>
<script  src="{{ asset('/doch/js/menu_script.js?fgbxd') }}"></script>
<script src="https://www.highcharts.com/samples/data/ohlc.js"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-toastr/toastr.min.js') }}" ></script>
<script src="{{ asset('assets/pages/scripts/ui-toastr.js') }}" ></script>




<script>
$(function(){
    
    var btnloader = document.querySelector('.btnloader');
    
    btnloader.addEventListener("click", function() {
        $('.introLoading').show();
      
    }, false);
    
});
</script>


<script>
$(document).ready(function () {
    $(".accordion_head").click(function() {
    if ($('.accordion_body').is(':visible')) {
      $(".accordion_body").slideUp(300);
      $(".plusminus").text('+');
    }
    if ($(this).next(".accordion_body").is(':visible')) {
      $(this).next(".accordion_body").slideUp(300);
      $(this).children(".plusminus").text('+');
    } else {
      $(this).next(".accordion_body").slideDown(300);
      $(this).children(".plusminus").text('-');
    }
  });
    var language = $('html').attr('lang');
    var baseURL = '{!! url('/') !!}';

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    /*$('#select_country').attr('data-selected-country',language.toUpperCase());

    $('#select_country').flagStrap({
        onSelect: function (value, element) {
            $.ajax({
                type: "GET",
                url: baseURL + '/locale/' + value,
                dataType:"json",
                success: function( result ) {
                    if(result.status) {
                        location.reload();
                    }
                }
            });
        }
    });*/
});
</script>
<!-- Page level Scripts -->

<script>
    var baseURL = '{!! url('/') !!}/';
    $(document).ready(function(){
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
    });
</script>


@stack('js')



<!-- Start of  Zendesk Widget script -->
<script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=0d2c781a-3ace-4627-84f8-29ae16e6b895"> </script>
<!-- End of  Zendesk Widget script -->