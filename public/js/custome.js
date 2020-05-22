$(document).ready(function(){
    $(window).load(function() {
        $(".introLoading").fadeOut(0);
       })
      
         $(window).scroll(function () {
              if ($(this).scrollTop() > 500) {
                  $('#back-to-top').fadeIn();
              } else {
                  $('#back-to-top').fadeOut();
              }
          });
          // scroll body to 0px on click
          $('#back-to-top').click(function () {
              $('#back-to-top').tooltip('hide');
              $('body,html').animate({
                  scrollTop: 0
              }, 800);
              return false;
          });


          //toggle the component with class accordion_body
	$(".accordion_head").click(function(){
		if ($('.accordion_body').is(':visible')) {
			$(".accordion_body").slideUp(300);
			$(".plusminus").html('<i class="fa fa-plus"></i>');
		}
        if( $(this).next(".accordion_body").is(':visible')){
            $(this).next(".accordion_body").slideUp(300);
            $(this).children(".plusminus").html('<i class="fa fa-plus"></i>');
        }else {
            $(this).next(".accordion_body").slideDown(300); 
            $(this).children(".plusminus").html('<i class="fa fa-minus"></i>');
        }
	});

           

   
   });







