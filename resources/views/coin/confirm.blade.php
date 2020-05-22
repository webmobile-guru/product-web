@extends('front.user')
@section('content')
    @guest
        @include('front.layout.guest-header')
    @else
        @include('front.layout.user-header')
    @endguest
        <section class="all_padding">
            <div class="container">
                <div class="coin_list_section col-md-8 col-md-offset-2">
                    <div class="sm_heading">
                        <h2>{{trans('coin/confirm.Coin_List_Request')}}</h2>
                    </div>
                    @include('flash::message')
                    <div class="alert alert-success">
                        <p>{{trans('coin/confirm.Coin_Token_successfully_submited')}}</p>
                    </div>
                </div>
            </div>
        </section>
@endsection

@push('css')
<style type="text/css">
    div .form-group .file { visibility: hidden; position: absolute; }
</style>
@endpush
@push('js')
{{--<script type="text/javascript" src="{{ asset('js/submit-ico.js') }}"></script>--}}
@endpush
