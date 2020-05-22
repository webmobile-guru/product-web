@extends('admin.layouts.master')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('/home') }}">{{trans('admin/coin-pair/index.Home')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{trans('admin/coin-pair/index.Manage_Coin_Pair')}}</span>
        </li>
    </ul>
</div>                        
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('admin/coin-pair/index.Coin_Pair')}}
    <small>{{trans('admin/coin-pair/index.Management')}}</small>
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
                    <span class="caption-subject font-red sbold uppercase">{{trans('admin/coin-pair/index.Coin_Master_Management')}}</span>
                </div>
                <div class="actions">                
                    <button class="btn red btn-outline sbold" name="create">{{trans('admin/coin-pair/index.Add_Coin_Pair')}}  </button>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-hover table-light">
                        <thead>
                            <tr>
                                <th> {{trans('admin/coin-pair/index.ID')}}</th>
                                <th> {{trans('admin/coin-pair/index.Base_Coin')}} </th>
                                <th> {{trans('admin/coin-pair/index.Secondary_Coin')}} </th>
                                <th> {{trans('admin/coin-pair/index.Coin_Pair_Name')}} </th>
                                <th> {{trans('admin/coin-pair/index.Status')}} </th>
                                <th style="width:20%" class="text-center"> {{trans('admin/coin-pair/index.Action')}} </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($coinPairs as $pair)
                                <tr>
                                    <td> {{ $pair->id }} </td>
                                    <td> {{ isset($pair->baseCoin->name)?$pair->baseCoin->name:'' }} </td>
                                    <td> {{ isset($pair->pairCoin->name)?$pair->pairCoin->name:'' }} </td>
                                    <td> {{ $pair->pair_name }} </td>
                                    <td>
                                        @if($pair->status)
                                            <a href="{{ route('admin.coinpair.changeStatus', $pair->id) }}" class="label label-sm label-success"> {{trans('admin/coin-pair/index.Active')}} </a>
                                        @else
                                            <a href="{{ route('admin.coinpair.changeStatus', $pair->id) }}" class="label label-sm label-danger"> {{trans('admin/coin-pair/index.Inactive')}} </a>
                                        @endif
                                    </td>
                                    <td style="width:20%" class="text-center">
                                        <button name="edit" type="button" data-id="{{ $pair->id }}" class="btn btn-outline btn-circle btn-sm purple">
                                            <i class="fa fa-edit"></i> {{trans('admin/coin-pair/index.Edit')}} 
                                        </button>
                                        <button name="delete" type="button" data-id="{{ $pair->id }}" class="btn btn-outline btn-circle btn-sm red">
                                            <i class="fa fa-trash"></i> {{trans('admin/coin-pair/index.Delete')}} 
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">{{trans('admin/coin-pair/index.exists')}}</td>
                                </tr>
                            @endforelse
                                <tr>
                                    <td colspan="6" class="text-right">{{ $coinPairs->links() }}</td>
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
                url:baseURL + 'admin/coin-pair/create',
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
                url:baseURL + 'admin/coin-pair/'+ id +'/edit',
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
            
            bootbox.confirm('Are you sure you want to delete coin called "'
                    + row.find('td:eq(1)').text() +'"', function(result){
                if(result) {
                    $.ajax({
                        url: baseURL + 'admin/coin-pair/'+ id,
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

function saveCoin(url, form, method = false)
{
    var formData = { 
        pair_name: form.find('input[name=pair_name]').val(),
        secondary_coin: form.find('select[name=secondary_coin]').val(),
        base_coin: form.find('select[name=base_coin]').val(),
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
        
            if('pair_name' in errors.errors) {
                var formGroup = form.find('div.form-group:eq(0)');
                formGroup.addClass('has-error');
                formGroup.find('p').text(errors.errors.pair_name[0]);
            } else {
                var formGroup = form.find('div.form-group:eq(0)');
                formGroup.removeClass('has-error');
                formGroup.find('p').text('');
            }
            if('secondary_coin' in errors.errors) {
                var formGroup = form.find('div.form-group:eq(1)');
                formGroup.addClass('has-error');
                formGroup.find('p').text(errors.errors.secondary_coin[0]);
            } else {
                var formGroup = form.find('div.form-group:eq(1)');
                formGroup.removeClass('has-error');
                formGroup.find('p').text('');
            }
            if('base_coin' in errors.errors) {
                var formGroup = form.find('div.form-group:eq(2)');
                formGroup.addClass('has-error');
                formGroup.find('p').text(errors.errors.base_coin[0]);
            } else {
                var formGroup = form.find('div.form-group:eq(2)');
                formGroup.removeClass('has-error');
                formGroup.find('p').text('');
            }            
            if('status' in errors.errors){
                var formGroup = form.find('div.form-group:eq(3)');
                formGroup.addClass('has-error');
                formGroup.find('p').text(errors.errors.status[0]);
            } else {
                var formGroup = form.find('div.form-group:eq(3)');
                formGroup.removeClass('has-error');
                formGroup.find('p').text('');
            }
        }
    });
}
</script>
@endpush

