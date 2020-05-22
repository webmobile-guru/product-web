@extends('admin.layouts.master')
@section('page-bar')

<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ route('home') }}">{{trans('admin/user/index.Home')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{trans('admin/user/index.Manage_User')}}</span>
        </li>
    </ul>
</div>                        
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('admin/user/index.User')}}
    <small>{{trans('admin/user/index.Management')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">{{trans('admin/user/index.Search')}}</div>
            </div>
            <div class="portlet-body flip-scroll">
                <form name="search" method="get" class="form-horizontal" action="{{ route('admin.user.index') }}">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="">{{trans('admin/user/index.First_Name')}}</label>
                            <input type="text" name="first_name" value="{{ request()->first_name }}" class="form-control" placeholder="{{trans('admin/user/index.Search_By_First_Name')}}">
                        </div>
                        <div class="col-md-4">
                            <label for="">{{trans('admin/user/index.Last_Name')}}</label>
                            <input type="text" name="last_name" value="{{ request()->last_name }}" class="form-control" placeholder="{{trans('admin/user/index.Search_By_Last_Name')}}">
                        </div>
                        <div class="col-md-4">
                            <label for="">{{trans('admin/user/index.email')}}</label>
                            <input type="email" name="email" value="{{ request()->email }}" class="form-control" placeholder="{{trans('admin/user/index.Search_By_Email')}}">
                        </div>
                        <div class="col-md-4">
                            <label for="">{{trans('admin/user/index.Role')}}</label>
                            <select name="role" class="form-control">
                                <option value="">-- {{trans('admin/user/index.Select_Role')}} --</option>
                                <option value="admin" @if(request()->role == 'admin') selected @endif>{{trans('admin/user/index.Admin')}}</option>
                                <option value="subscriber" @if(request()->role == 'subscriber') selected @endif>{{trans('admin/user/index.Subscriber')}}</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">{{trans('admin/user/index.Status')}}</label>
                            <select name="status" class="form-control">
                                <option value="">-- {{trans('admin/user/index.Select_Status')}} --</option>
                                <option value="active" @if(request()->status == 'active') selected @endif>{{trans('admin/user/index.Active')}}</option>
                                <option value="inactive" @if(request()->status == 'inactive') selected @endif>{{trans('admin/user/index.Inactive')}}</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="">{{trans('admin/user/edit.Passport_verify')}}</label>
                            <select name="ide_verify" class="form-control">
                                <option value="">-- {{trans('admin/user/index.select')}} --</option>
                                <option value=1 @if(request()->ide_verify == 1) selected @endif>{{trans('admin/user/index.Verified')}}</option>
                                <option value=2 @if(request()->ide_verify == 2) selected @endif>{{trans('admin/user/index.Unverified')}}</option>
                                <option value=3 @if(request()->ide_verify == 3) selected @endif>{{trans('admin/user/index.Not_Uploaded')}}</option>
                            </select>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <label for="">&nbsp;</label>
                            <button type="submit" class="btn btn-block btn-primary" name="search" value="true">{{trans('admin/user/index.Search')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>                                
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <span class="caption-subject font-red sbold uppercase">{{trans('admin/user/index.User_Management')}}</span>
                </div>
                <div class="actions">                
                    <button class="btn red btn-outline sbold" name="create"> {{trans('admin/user/index.Add_User')}} </button>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-hover table-light">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th>{{trans('admin/user/index.Name')}}  </th>
                                <th>{{trans('admin/user/index.email')}} </th>
                                <th>{{trans('admin/user/index.Role')}}  </th>
                                <th>{{trans('admin/user/index.Status')}}  </th>
                                <th style="width:25%" class="text-center">{{trans('admin/user/index.Action')}}  </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td> {{ $user->id }} </td>
                                    <td> {{ $user->full_name }} </td>
                                    <td> {{ $user->email }} </td>
                                    <td> 
                                        <label class="label label-sm label-{{($user->profile->role=='admin')?'info':'warning'}}"> {{ $user->profile->role }} </label>
                                    </td>                                    
                                    <td>
                                        @if($user->profile->status)
                                            <label class="label label-sm label-success">{{trans('admin/user/index.Active')}}  </label>
                                        @else
                                            <label class="label label-sm label-danger">{{trans('admin/user/index.Inactive')}}  </label>
                                        @endif
                                    </td>
                                    <td style="width:30%" class="text-center">
                                        <a href="{{ route('admin.user.login', [$user->id]) }}" class="btn btn-outline btn-circle btn-sm yellow">
                                            <i class="fa fa-lock"></i>{{trans('admin/user/index.Login')}} 
                                        </a>
                                        <button name="view" type="button" data-id="{{ $user->id }}" class="btn btn-outline btn-circle btn-sm blue">
                                            <i class="fa fa-eye"></i>{{trans('admin/user/index.View')}}  
                                        </button>
                                        <button name="edit" type="button" data-id="{{ $user->id }}" class="btn btn-outline btn-circle btn-sm purple">
                                            <i class="fa fa-edit"></i>{{trans('admin/user/index.Edit')}}  
                                        </button>
                                        <!--<button name="delete" type="button" data-id="{{ $user->id }}" class="btn btn-outline btn-circle btn-sm red">
                                            <i class="fa fa-trash"></i>{{trans('admin/user/index.Delete')}}  
                                        </button>-->
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">{{trans('admin/user/index.Data')}} </td>
                                </tr>
                            @endforelse
                            <tr>
                                <td colspan="6" class="text-right">
                                    {{ $users->links() }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="dialog" class="modal" role="dialog"></div>

@include('admin.template.loader')

@endsection
@push('js')
<script src="{{ asset('assets/global/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
	
    $(document).ready(function(){  
		
		
        $('button[name=view]').click(function () {
            var id = $(this).data('id');  
            $.ajax({
                type:'GET',
                url:baseURL + 'admin/user/'+id,            
                dataType:'html',
                beforeSend: function () {
                    $('div[id=myLoader]').modal({backdrop:false});
                },
                success: function (result) {
                    $('div[id=dialog]')
                            .empty().html(result);
                    $('div[id=myLoader]').modal('hide');
                    $('div[id=dialog]').modal({backdrop:false});
                },
                error: function (result) { 
                    $('div[id=myLoader]').modal('hide');
                }
            });
        });

        $('button[name=create]').click(function () {
            $.ajax({
                type:'GET',
                url:baseURL + 'admin/user/create',
                dataType:'html',
                beforeSend: function () {
                    $('div[id=myLoader]').modal({backdrop:false});
                },
                success: function (result) {
                    $('div[id=dialog]')
                            .empty().html(result);
                    $('div[id=myLoader]').modal('hide');
                    $('div[id=dialog]').modal({backdrop:false});
                },
                error: function (result) {
                    $('div[id=myLoader]').modal('hide');
                }
            });
        });

        $('button[name="edit"]').click(function(){
            var id = $(this).data('id');
            $.ajax({
                type:'GET',
                url:baseURL + 'admin/user/'+ id+'/edit',
                dataType:'html',
                beforeSend: function () {
                    $('div[id=myLoader]').modal({backdrop:false});
                },
                success: function (result) { 
                    $('div[id=dialog]')
                            .empty().html(result);
                    $('div[id=myLoader]').modal('hide');
                    $('div[id=dialog]').modal({backdrop:false});
                },
                error: function (result) { 
                    $('div[id=myLoader]').modal('hide');
                }
            });
        });

        $('button[name="delete"]').click(function(){
            var id = $(this).data('id');
            var row = $(this).closest('tr');

            var data = {_method:'DELETE'};
            
            bootbox.confirm('Are you sure you want to delete user called "'
                    + row.find('td:eq(1)').text() +'"', function(result){
                if(result) {
                    $.ajax({
                        url: baseURL + 'admin/user/'+ id,
                        type: 'POST',
                        data: data,
                        dataType:'json',
                        success: function (result) {
                            if(result.status){
                                row.remove();
                            }
                            bootbox.alert(result.message);
                        },
                        error: function (result) {
                            console.log(result);
                        }
                    });
                }
            })
        });   
    });

    function saveUser(url, form, method = false)
    {
        
        var form_data = $('#modify-user')[0];
        var formData = new FormData(form_data);
        
        formData.append('ide_img', $('input[type=file]')[0].files[0]); 
        formData.append('_method', 'PUT');

        JSON.stringify(Object.fromEntries(formData));

        $.ajax({
            url:baseURL + url,
            type:'POST',
            data:formData,
            dataType:'json',
            processData: false,
            contentType: false,
            success:function(result){ 
				$('.above_error').html("");
                $('div[id=basic]').modal('hide');
                location.reload(true);
            },
            error:function(result){ 
                var errors = result.responseJSON.errors;
            $('.above_error').html("Please check the error above");
                if('first_name' in errors) {
                   var formGroup = form.find('input[name=first_name]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.first_name[0]);
                } else {
                    var formGroup = form.find('input[name=first_name]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }
                if('country' in errors) {
                    var formGroup = form.find('input[name=country]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.country[0]);
                } else {
                    var formGroup = form.find('input[name=country]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }
                if('zip' in errors) {
                    var formGroup = form.find('input[name=zip]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.zip[0]);
                } else {
                    var formGroup = form.find('input[name=zip]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }
                if('state' in errors) {
                    var formGroup = form.find('input[name=state]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.state[0]);
                } else {
                    var formGroup = form.find('input[name=state]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }
                if('city' in errors) {
                    var formGroup = form.find('input[name=city]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.city[0]);
                } else {
                    var formGroup = form.find('input[name=city]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }
                if('address' in errors) {
                    var formGroup = form.find('input[name=address]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.address[0]);
                } else {
                    var formGroup = form.find('input[name=address]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }
                if('last_name' in errors) {
                    var formGroup = form.find('input[name=last_name]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.last_name[0]);
                } else {
                    var formGroup = form.find('input[name=last_name]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }
                if('phone' in errors) {
                    var formGroup = form.find('input[name=phone]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.phone[0]);
                } else {
                    var formGroup = form.find('input[name=phone]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }
                if('email' in errors) {
                    var formGroup = form.find('input[name=email]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.email[0]);
                } else {
                    var formGroup = form.find('input[name=email]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }
                if('password' in errors) {
                    var formGroup = form.find('input[name=password]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.password[0]);
                } else {
                    var formGroup = form.find('input[name=password]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }
                if('role' in errors){
                    var formGroup = form.find('input[name=role]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.role[0]);
                } else {
                    var formGroup = form.find('input[name=role]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }
                if('status' in errors){
                    var formGroup = form.find('input[name=status]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.status[0]);
                } else {
                    var formGroup = form.find('input[name=status]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }
                if('ssn' in errors){
                    var formGroup = form.find('input[name=ssn]').closest('div.form-group');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text(errors.ssn[0]);
                } else {
                    var formGroup = form.find('input[name=ssn]').closest('div.form-group');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }
                 if(('mm' in errors) || ('dd' in errors) || ('yy' in errors)){
                    var formGroup = form.find('input[name=yy]').closest('div.dob');
                    formGroup.addClass('has-error');
                    formGroup.find('p').text("Invalid date");
                } else {
                    var formGroup = form.find('input[name=yy]').closest('div.dob');
                    formGroup.removeClass('has-error');
                    formGroup.find('p').text('');
                }
                
            }
        });
    }
</script>
@endpush
