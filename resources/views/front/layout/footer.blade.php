
<footer>
  <div class="footer_bottom">
      <div class="container">

      <div class="row">
        <div class="col-md-6 col-sm-6">
          <h4>{{trans('front/layout/footer.About_us')}}</h4>
          <p>{{trans('front/layout/footer.AboutUsContent')}}</p>
        </div> 
        <div class="col-md-6 col-sm-6">
          <div class="row">
            <div class="col-md-6 col-sm-6">
            <h4>{{trans('front/layout/footer.ContactUs')}}</h4>
            <ul class="location_ul">
             <li>
                <span><i class="fa fa-map-marker"></i></span>
                {{trans('front/layout/footer.Address')}}		
              </li>
              {{-- <li>
                <span><i class="fa fa-phone"></i></span>
                +91 1234567890					
              </li> --}}
              <li>
                <span><i class="fa fa-envelope-o"></i></span>
                info@doch.exchange					
              </li>
					
                </ul>
            </div>
            <div class="col-md-6 col-sm-6">
              <div class="footer_about">
                <h4>{{trans('front/layout/footer.QuickLink')}}</h4>
                <ul>
                  <li><a href="{{ route('page.about') }}">{{trans('front/layout/footer.About_us')}}</a></li>
                  <li><a href="{{ route('page.faq') }}">{{trans('front/layout/footer.Faq')}}</a></li>
                  <li><a href="{{ route('page.privacy-policy') }}">{{trans('front/layout/footer.PrivacyPolicy')}}</a></li>
                  <li><a href="{{ route('page.terms-and-conditions') }}">{{trans('front/layout/footer.Terms_of_Service')}}</a></li>
                </ul>
             </div>
             
            <div class="dropdown">
              <button class="dropbtn">{{ App::getLocale() }}</button>
              <div class="dropdown-content">
              <a href="{{ route('portal.setLocale','en') }}">English</a>
              <a href="{{ route('portal.setLocale','ja') }}">Japanese</a>
              <a href="{{ route('portal.setLocale','ko') }}">Korean</a>
              <a href="{{ route('portal.setLocale','zh') }}">Chinese</a>
             <a href="{{ route('portal.setLocale','vi') }}">Vietnamese</a>

              </div>
            </div>
            </div>
        </div>
        </div>
      </div>
          <hr>
          <div class="footer_copyright">
              <h1 class="text-center">{{trans('front/layout/footer.Copyright')}}</h1>
           </div>
        </div>
  </div>
</footer>



