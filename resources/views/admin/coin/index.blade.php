@extends('admin.layouts.master')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('/home') }}">{{trans('admin/coin/index.Home')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{trans('admin/coin/index.Manage_Coin')}}</span>
        </li>
    </ul>
</div>                        
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('admin/coin/index.Coin')}}
    <small>{{trans('admin/coin/index.Master_Management')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
<div class="row">
    <div class="col-md-12">                                
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-settings font-red"></i>
                    <span class="caption-subject font-red sbold uppercase">{{trans('admin/coin/index.Coin_Master_Management')}}</span>
                </div>
                <div class="actions">                
                    <button class="btn red btn-outline sbold" name="create">{{trans('admin/coin/index.Add_Coin')}} </button>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-hover table-light">
                        <thead>
                            <tr>
                                <th> {{trans('admin/coin/index.ID')}} </th>
                                <th> {{trans('admin/coin/index.Name')}} </th>
                                <th> {{trans('admin/coin/index.Short_Name')}} </th>
                                <th> {{trans('admin/coin/index.Base')}} </th>
                                <th> {{trans('admin/coin/index.Status')}} </th>
                                <th style="width:20%" class="text-center"> {{trans('admin/coin/index.Action')}} </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($coins as $coin)
                                <tr>
                                    <td> {{ $coin->id }} </td>
                                    <td> {{ $coin->name }} </td>
                                    <td> {{ $coin->coin }} </td>
                                    <td>
                                        @if($coin->is_base)
                                            <a href="{{ route('admin.coin.changeBase', $coin->id) }}"  class="label label-sm label-info"> {{trans('admin/coin/index.Yes')}} </a>
                                        @else
                                            <a href="{{ route('admin.coin.changeBase', $coin->id) }}"  class="label label-sm label-warning"> {{trans('admin/coin/index.No')}} </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if($coin->status)
                                            <a href="{{ route('admin.coin.changeStatus', $coin->id) }}" class="label label-sm label-success"> {{trans('admin/coin/index.Active')}} </a>
                                        @else
                                            <a href="{{ route('admin.coin.changeStatus', $coin->id) }}" class="label label-sm label-danger"> {{trans('admin/coin/index.Inactive')}} </a>
                                        @endif
                                    </td>
                                    <td style="width:20%" class="text-center">
                                        <button name="edit" type="button" data-id="{{ $coin->id }}" class="btn btn-outline btn-circle btn-sm purple">
                                            <i class="fa fa-edit"></i> {{trans('admin/coin/index.Edit')}} 
                                        </button>
                                        <button name="delete" type="button" data-id="{{ $coin->id }}" class="btn btn-outline btn-circle btn-sm red">
                                            <i class="fa fa-trash"></i> {{trans('admin/coin/index.Delete')}} 
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center"> {{trans('admin/coin/index.exists')}} </td>
                                </tr>
                            @endforelse
                                <tr>
                                    <td colspan="6" class="text-right">{{ $coins->links() }}</td>
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
        $('button[name=create]').click(function () {
            $.ajax({
                type:'GET',
                url:baseURL + 'admin/coin/create',
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
                },
                xhr: function () {
                    var xhr = $.ajaxSettings.xhr();
                    xhr.onprogress = function e() {
                        // For downloads
                        if (e.lengthComputable) {
                            console.log(e.loaded / e.total);
                        }
                    };
                    xhr.upload.onprogress = function (e) {
                        // For uploads
                        if (e.lengthComputable) {
                            console.log(e.loaded / e.total);
                        }
                    };
                    return xhr;
                }
            });
        });

        $('button[name="edit"]').click(function(){
            var id = $(this).data('id');
            $.ajax({
                type:'GET',
                url:baseURL + 'admin/coin/'+ id +'/edit',
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
            
            bootbox.confirm('Are you sure you want to delete coin pair called "'
                    + row.find('td:eq(1)').text() +'"', function(result){
                if(result) {
                    $.ajax({
                        url: baseURL + 'admin/coin/'+ id,
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

function saveCoinPair(url, form, method = false)
{
    var formData = { 
        coin_name: form.find('input[name=coin_name]').val(),
        short_name: form.find('input[name=short_name]').val(),
        coin_type: form.find('input[name=coin_type]:checked').val(),
        withdraw_m: form.find('input[name=withdraw_m]:checked').val(),
        base_info: form.find('input[name=base_info]:checked').val(),
        status: form.find('input[name=status]:checked').val(),
        
    };

    if(method) {
        formData['_method'] = 'PUT';
    }
             
    $.ajax({
        url:baseURL + url,
        type:'POST',
        data:formData,            
        dataType:'json',                
        success:function(result){
            $('div[id=basic]').modal('hide');
            location.reload(true);
        },
        error:function(result){
            var errors = result.responseJSON;
      
            if('coin_name' in errors.errors) {
                var formGroup = form.find('div.form-group:eq(0)');
                formGroup.addClass('has-error');
                formGroup.find('p').text(errors.errors.coin_name[0]);
            } else {
                var formGroup = form.find('div.form-group:eq(0)');
                formGroup.removeClass('has-error');
                formGroup.find('p').text('');
            }
            if('short_name' in errors.errors) {
                var formGroup = form.find('div.form-group:eq(1)');
                formGroup.addClass('has-error');
                formGroup.find('p').text(errors.errors.short_name[0]);
            } else {
                var formGroup = form.find('div.form-group:eq(1)');
                formGroup.removeClass('has-error');
                formGroup.find('p').text('');
            }
            if('base_info' in errors.errors) {
                var formGroup = form.find('div.form-group:eq(2)');
                formGroup.addClass('has-error');
                formGroup.find('p').text(errors.errors.base_info[0]);
            } else {
                var formGroup = form.find('div.form-group:eq(2)');
                formGroup.removeClass('has-error');
                formGroup.find('p').text('');
            }
            if('coin_type' in errors.errors){
                var formGroup = form.find('div.form-group:eq(3)');
                formGroup.addClass('has-error');
                formGroup.find('p').text(errors.errors.coin_type[0]);
            } else {
                var formGroup = form.find('div.form-group:eq(3)');
                formGroup.removeClass('has-error');
                formGroup.find('p').text('');
            }
            if('withdraw_m' in errors.errors){
                var formGroup = form.find('div.form-group:eq(4)');
                formGroup.addClass('has-error');
                formGroup.find('p').text(errors.errors.withdraw_m[0]);
            } else {
                var formGroup = form.find('div.form-group:eq(4)');
                formGroup.removeClass('has-error');
                formGroup.find('p').text('');
            }
            if('status' in errors.errors){
                var formGroup = form.find('div.form-group:eq(5)');
                formGroup.addClass('has-error');
                formGroup.find('p').text(errors.errors.status[0]);
            } else {
                var formGroup = form.find('div.form-group:eq(5)');
                formGroup.removeClass('has-error');
                formGroup.find('p').text('');
            }
        }
    });
}
</script>
@endpush

