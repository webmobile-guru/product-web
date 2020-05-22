@extends('front.user')
@section('content')
@guest
    @include('front.layout.guest-header')
@else
    @include('front.layout.user-header')
@endguest
<section class="all_padding">
    <div class="container">
        <div class="sm_heading">
            <h3>Contact Us</h3>
            <h4>Lorem Ipsum is simply dummy text of the printing and typesetting</h4>
        </div>
        <div class="row">
          <div class="col-md-7 col-sm-7">
            <div class="contact_map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12301.513435478626!2d-96.04069517445691!3d39.57362236134922!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x87be3e79433f6007%3A0x86baec447b34422!2sAmerica+City%2C+KS+66540%2C+USA!5e0!3m2!1sen!2sin!4v1549350697177" style="border:0" allowfullscreen></iframe>
            </div>
          </div>
          <div class="col-md-5 col-sm-5">
            @include('flash::message')
                @if(count($errors) > 0)
                    <div class="alert alert-danger">                           
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach                           
                    </div>
                @endif
               <form method="post" action="{{ route('page.contact.post') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input class="login_input_text" name="enquirar" value="{{ old('enquirar') }}" type="text" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <input class="login_input_text" name="email" value="{{ old('enquirar') }}" type="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <textarea rows="5" name="comment" class="login_input_text" placeholder="Comment">{{ old('comment') }}</textarea>
                    </div>
                    <input class="sidenav_btn" type="submit" value="Submit">
                </form>
          </div>
        </div>
    </div>
</section>
@endsection
