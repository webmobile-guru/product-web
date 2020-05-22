$(document).ready(function(){
    // ===== Scroll to Top ==== 
        $(window).scroll(function() {
            if ($(this).scrollTop() >= 50) {       
                $('#return-to-top').fadeIn(200);   
            } else {
                $('#return-to-top').fadeOut(200);  
            }
        });
        $('#return-to-top').click(function() {     
            $('body,html').animate({
                scrollTop : 0                     
            }, 500);
        });
    //loader//
    $(".introLoading").fadeOut(0);    
        
    $( "#openNav" ).click(function() {
        $('#mySidenav').addClass('open');
        $('body').addClass('open-bg');
      });
      $( "#closeNav" ).click(function() {
        $('#mySidenav').removeClass('open');
        $('body').removeClass('open-bg');
      });
    
     
      $('[data-toggle="tooltip"]').tooltip(); 
    // ===== marquee ==== 
        $(function (){
            $('.simple-marquee-container').SimpleMarquee();
         }); 
    


    
    });
    
    
    
    
    
    
    
    