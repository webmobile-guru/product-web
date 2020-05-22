@extends('admin.template.dialog')
@section('dialogTitle') {{trans('admin/user/show.View_User')}} @endsection
@section('dialogContent')
<div class="modal-body">
    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading">
            <h3 class="panel-title">{{ ucfirst($user->full_name) }}</h3>
        </div>
        <div class="panel-body">
            <div class="col-md-7 col-sm-12">
                <p> <strong>{{trans('admin/user/show.First_Name')}}:</strong> {{ ucfirst($user->first_name) }} </p>
                @if($user->middle_name)
                    <p> <strong>{{trans('admin/user/show.Middle_Name')}}:</strong> {{ ucfirst($user->middle_name) }} </p>
                @endif
                @if($user->last_name)
                    <p> <strong>{{trans('admin/user/show.Last_Name')}}:</strong> {{ ucfirst($user->last_name) }} </p>
                @endif
                <p> <strong>{{trans('admin/user/show.email')}}:</strong> {{ $user->email }} </p>
                <p> <strong>{{trans('admin/user/show.Phone')}}:</strong> {{ isset($user->profile->phone)?$user->profile->phone:trans('admin/user/show.Not_Available') }} </p>
                <p> <strong>{{trans('admin/user/show.DOB')}}:</strong> {{ isset($user->profile->dob)?$user->profile->dob:trans('admin/user/show.Not_Available') }} </p>
                <p> <strong>{{trans('admin/user/show.passport_num')}}:</strong> {{ isset($user->profile->ide_no)?$user->profile->ide_no:trans('admin/user/show.Not_Available') }} </p>
                <p> <strong>{{trans('admin/user/show.passport_verify')}}:</strong> {{ isset($user->profile->ide_verify)?(($user->profile->ide_verify==1)?'Verified':'Unverified'):'' }} </p>
                <p> <strong>{{trans('admin/user/show.Street_Address')}}:</strong> {{ isset($user->profile->address)?$user->profile->address:trans('admin/user/show.Not_Available') }} </p>
                <p> <strong>{{trans('admin/user/show.City')}}:</strong> {{ isset($user->profile->city)?$user->profile->city:trans('admin/user/show.Not_Available') }} </p>
                <p> <strong>{{trans('admin/user/show.State')}}:</strong> {{ isset($user->profile->state)?$user->profile->state:trans('admin/user/show.Not_Available') }} </p>
                <p> <strong>{{trans('admin/user/show.Postal_Code')}}:</strong> {{ isset($user->profile->zip)?$user->profile->zip:trans('admin/user/show.Not_Available') }} </p>
                <p> <strong>{{trans('admin/user/show.Country')}}:</strong> {{ isset($user->profile->country->name)?$user->profile->country->name:trans('admin/user/show.Not_Available') }} </p>
                <p> <strong>{{trans('admin/user/show.Status')}}:</strong> {{ ($user->status)?(trans('admin/user/show.Active')):(trans('admin/user/show.Inactive')) }} </p>
                <p> <strong>{{trans('admin/user/show.Email_Verified')}}:</strong> {{ isset($user->profile->verified_at)?(trans('admin/user/show.Verified')):(trans('admin/user/show.Unverified')) }} </p>
                <p> <strong>{{trans('admin/user/show.Two_Factor_Enabled')}}:</strong> {{ isset($user->profile->status_two_fa)?(trans('admin/user/show.Yes')):(trans('admin/user/show.No')) }} </p>
            </div>
            @if($user->profile->avatar)
                <div class="col-md-5 col-sm-12">
                <div class="thumbnail">
                    <img src="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxOTkiIGhlaWdodD0iMjAwIj48cmVjdCB3aWR0aD0iMTk5IiBoZWlnaHQ9IjIwMCIgZmlsbD0iI2VlZSIvPjx0ZXh0IHRleHQtYW5jaG9yPSJtaWRkbGUiIHg9Ijk5LjUiIHk9IjEwMCIgc3R5bGU9ImZpbGw6I2FhYTtmb250LXdlaWdodDpib2xkO2ZvbnQtc2l6ZToxM3B4O2ZvbnQtZmFtaWx5OkFyaWFsLEhlbHZldGljYSxzYW5zLXNlcmlmO2RvbWluYW50LWJhc2VsaW5lOmNlbnRyYWwiPjE5OXgyMDA8L3RleHQ+PC9zdmc+" alt="100%x200" style="width: 100%; height: 200px; display: block;" data-src="../assets/global/plugins/holder.js/100%x200">            
                </div>
                {{-- <img src="{{ route('layout.avatar', $layout->user_pic) }}"> --}}
                </div>
            @endif
        </div>
        <!-- List group -->
        {{-- <ul class="list-group">
            <li class="list-group-item"> First Name
                <span class="badge badge-default"> 3 </span>
            </li>
            <li class="list-group-item"> Last name
                <span class="badge badge-success"> 11 </span>
            </li>
            <li class="list-group-item"> Emailt
                <span class="badge badge-danger"> new </span>
            </li>
            <li class="list-group-item"> Porta ac consectetur ac
                <span class="badge badge-warning"> 4 </span>
            </li>
            <li class="list-group-item"> Vestibulum at eros
                <span class="badge badge-info"> 3 </span>
            </li>
            <li class="list-group-item"> Vestibulum at eros </li>
        </ul> --}}
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn dark btn-outline" data-dismiss="modal">{{trans('admin/user/show.Close')}}</button>
    <button type="button" class="btn green" onclick="saveCoinPair('admin/coin', $('form[id=create-coin]'))">{{trans('admin/user/show.Save_changes')}}</button>
</div>
@stop
