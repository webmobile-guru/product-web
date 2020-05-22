@extends('front.user')
@section('content')
<!--Banner section-->
    @guest
		@include('front.layout.guest-header')
	@else
		@include('front.layout.user-header')
	@endguest
   
    <section class="all_padding">
    <div class="container">
        <div class="sm_heading">
            <h3>Testimonials</h3>
            <h4>See what our existing client have to say about us</h4>
        </div>
        <div class="testimonial_inner">
          <div class="row">
            <div class="col-md-4 col-sm-4 col-xs-6">
              <div class="testimonial_border">
                  <div class="testimonial_body">
                      <p>"For long, I’ve been seeking treatment for my Arthritis. I undertook several pills &amp; medicines that didn’t seem to work. Dr. Good Health’s Arthritis oil has worked wonders for me. Within a few months, my joint pain was reduced drastically. I could walk properly for longer distances without any pain. My joints have become stronger than before and all the credit goes to this wonderful ayurvedic remedy" </p>
                      <h3>John Deo</h3>
                      <h4>Designer</h4>
                  </div>
                  <div class="testimonial_footer">
                      <img class="client_img" src="{{ asset('/hotbtc/img/client_01.jpg') }}" alt="">
                      <div class="client_reating">
                          <i class="fas fa-star"></i>
                          <i class="fas fa-star"></i>
                          <i class="fas fa-star"></i>
                          <i class="fas fa-star"></i>
                          <i class="far fa-star"></i>
                      </div>
                  </div>
              </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-6">
              <div class="testimonial_border">
                  <div class="testimonial_body">
                      <p>"For long, I’ve been seeking treatment for my Arthritis. I undertook several pills &amp; medicines that didn’t seem to work. Dr. Good Health’s Arthritis oil has worked wonders for me. Within a few months, my joint pain was reduced drastically. I could walk properly for longer distances without any pain. My joints have become stronger than before and all the credit goes to this wonderful ayurvedic remedy" </p>
                      <h3>John Deo</h3>
                      <h4>Designer</h4>
                  </div>
                  <div class="testimonial_footer">
                      <img class="client_img" src="{{ asset('/hotbtc/img/client_02.jpg') }}" alt="">
                      <div class="client_reating">
                          <i class="fas fa-star"></i>
                          <i class="fas fa-star"></i>
                          <i class="fas fa-star"></i>
                          <i class="fas fa-star"></i>
                          <i class="far fa-star"></i>
                      </div>
                  </div>
              </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-6">
              <div class="testimonial_border">
                  <div class="testimonial_body">
                      <p>"For long, I’ve been seeking treatment for my Arthritis. I undertook several pills &amp; medicines that didn’t seem to work. Dr. Good Health’s Arthritis oil has worked wonders for me. Within a few months, my joint pain was reduced drastically. I could walk properly for longer distances without any pain. My joints have become stronger than before and all the credit goes to this wonderful ayurvedic remedy" </p>
                      <h3>John Deo</h3>
                      <h4>Designer</h4>
                  </div>
                  <div class="testimonial_footer">
                      <img class="client_img" src="{{ asset('/hotbtc/img/nobody_m.jpg') }}" alt="">
                      <div class="client_reating">
                          <i class="fas fa-star"></i>
                          <i class="fas fa-star"></i>
                          <i class="fas fa-star"></i>
                          <i class="fas fa-star"></i>
                          <i class="far fa-star"></i>
                      </div>
                  </div>
              </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-6">
              <div class="testimonial_border">
                  <div class="testimonial_body">
                      <p>"For long, I’ve been seeking treatment for my Arthritis. I undertook several pills &amp; medicines that didn’t seem to work. Dr. Good Health’s Arthritis oil has worked wonders for me. Within a few months, my joint pain was reduced drastically. I could walk properly for longer distances without any pain. My joints have become stronger than before and all the credit goes to this wonderful ayurvedic remedy" </p>
                      <h3>John Deo</h3>
                      <h4>Designer</h4>
                  </div>
                  <div class="testimonial_footer">
                      <img class="client_img" src="{{ asset('/hotbtc/img/client_03.jpg') }}" alt="">
                      <div class="client_reating">
                          <i class="fas fa-star"></i>
                          <i class="fas fa-star"></i>
                          <i class="fas fa-star"></i>
                          <i class="fas fa-star"></i>
                          <i class="far fa-star"></i>
                      </div>
                  </div>
              </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-6">
              <div class="testimonial_border">
                  <div class="testimonial_body">
                      <p>"For long, I’ve been seeking treatment for my Arthritis. I undertook several pills &amp; medicines that didn’t seem to work. Dr. Good Health’s Arthritis oil has worked wonders for me. Within a few months, my joint pain was reduced drastically. I could walk properly for longer distances without any pain. My joints have become stronger than before and all the credit goes to this wonderful ayurvedic remedy" </p>
                      <h3>John Deo</h3>
                      <h4>Designer</h4>
                  </div>
                  <div class="testimonial_footer">
                      <img class="client_img" src="{{ asset('/hotbtc/img/client_04.jpg') }}" alt="">
                      <div class="client_reating">
                          <i class="fas fa-star"></i>
                          <i class="fas fa-star"></i>
                          <i class="fas fa-star"></i>
                          <i class="fas fa-star"></i>
                          <i class="far fa-star"></i>
                      </div>
                  </div>
              </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-6">
              <div class="testimonial_border">
                  <div class="testimonial_body">
                      <p>"For long, I’ve been seeking treatment for my Arthritis. I undertook several pills &amp; medicines that didn’t seem to work. Dr. Good Health’s Arthritis oil has worked wonders for me. Within a few months, my joint pain was reduced drastically. I could walk properly for longer distances without any pain. My joints have become stronger than before and all the credit goes to this wonderful ayurvedic remedy" </p>
                      <h3>John Deo</h3>
                      <h4>Designer</h4>
                  </div>
                  <div class="testimonial_footer">
                      <img class="client_img" src="{{ asset('/hotbtc/img/client_05.jpg') }}" alt="">
                      <div class="client_reating">
                          <i class="fas fa-star"></i>
                          <i class="fas fa-star"></i>
                          <i class="fas fa-star"></i>
                          <i class="fas fa-star"></i>
                          <i class="far fa-star"></i>
                      </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</section>




@endsection
