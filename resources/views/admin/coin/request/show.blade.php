@extends('admin.layouts.master')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="{{ url('/home') }}">{{trans('admin/coin/request/show.Home')}}</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>{{trans('admin/coin/request/show.Coin_List_Request')}}</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('admin/coin/request/show.Coin_List_Request')}}
    <small>{{trans('admin/coin/request/show.Management')}}</small>
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
                        <span class="caption-subject font-red sbold uppercase">{{trans('admin/coin/request/show.Coin_List_Master_Management')}}</span>
                    </div>
                    {{--<div class="actions">
                        <button class="btn red btn-outline sbold" name="create"> {{trans('admin/coin/request/show.Add_Coin')}}</button>
                    </div>--}}
                </div>
                <div class="portlet-body">
                    <div class="row">
                        {{--<div class="col-md-12"></div>--}}
                        <div class="col-md-6">
                            <div class="table-scrollable">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th colspan="2" style="background: #a48ad86b">{{trans('admin/coin/request/show.Coin_Profile')}}</th>
                                        </tr>
                                        <tr>
                                            <th>{{trans('admin/coin/request/show.Coin_Token_Name')}}:</th>
                                            <td>{{ ucfirst($item->coin_name) }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('admin/coin/request/show.Coin_Token_Symbol')}}:</th>
                                            <td>{{ $item->coin_symbol }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('admin/coin/request/show.Website')}}:</th>
                                            <td>{{ $item->website_link }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('admin/coin/request/show.Whitepaper')}}:</th>
                                            <td>{{ $item->whitepaper_link }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('admin/coin/request/show.One_Sentence_Pitch')}}:</th>
                                            <td colspan="2">{{ $item->one_sentence_pitch }}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="2" style="background: #a48ad86b">{{trans('admin/coin/request/show.Contact_Person_Profile')}}</th>
                                        </tr>
                                        <tr>
                                            <th>{{trans('admin/coin/request/show.Name')}}:</th>
                                            <td>{{ $item->full_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('admin/coin/request/show.Contact_Email')}}:</th>
                                            <td>{{ $item->contact_email }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('admin/coin/request/show.Company_Name')}}:</th>
                                            <td>{{ $item->company_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('admin/coin/request/show.Position_in_Company')}}:</th>
                                            <td>{{ $item->position_in_company }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="table-scrollable">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th colspan="2" style="background: #a48ad86b">{{trans('admin/coin/request/show.Project_Profile')}}</th>
                                        </tr>
                                        <tr>
                                            <th>{{trans('admin/coin/request/show.Previously_Submited')}}:</th>
                                            <td>{{ ucfirst($item->previously_submited) }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('admin/coin/request/show.Project_Name')}}:</th>
                                            <td>{{ $item->project_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>{{trans('admin/coin/request/show.Project_Nature')}}:</th>
                                            <td>{{ $item->project_nature }}</td>
                                        </tr>
                                        @if($item->project_application)
                                            <tr>
                                                <th>{{trans('admin/coin/request/show.Project_Application')}}:</th>
                                                <td>{{ $item->project_application }}</td>
                                            </tr>
                                        @endif
                                        @if($item->target_industry)
                                            <tr>
                                                <th>{{trans('admin/coin/request/show.Target_Industry')}}:</th>
                                                <td>{{ $item->target_industry }}</td>
                                            </tr>
                                        @endif

                                        @if($item->project_competetor)
                                            <tr>
                                                <th>{{trans('admin/coin/request/show.Project_Competetor')}}:</th>
                                                <td>{{ $item->project_competetor }}</td>
                                            </tr>
                                        @endif
                                        @if($item->remarks)
                                            <tr>
                                                <th>{{trans('admin/coin/request/show.Remarks')}}:</th>
                                                <td>{{ $item->remarks }}</td>
                                            </tr>
                                        @endif
                                        @if(!$item->status)
                                            <tr>
                                                <td>
                                                    <button data-href="{{ route('admin.coin.request.approve', $item->id) }}" type="submit" class="btn btn-block btn-success" name="approve">{{trans('admin/coin/request/show.Approve')}}</button>
                                                </td>
                                                <td>
                                                    <button data-href="{{ route('admin.coin.request.reject', $item->id) }}" type="submit" class="btn btn-block btn-danger" name="reject">{{trans('admin/coin/request/show.Reject')}}</button>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <th>
                                                    {{trans('admin/coin/request/show.Status')}}:
                                                </th>
                                                <td class="text-{{['warning', 'success', 'danger'][ $item->status]}}">{{ ["Pending", "Approved", "Rejected"][ $item->status] }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
<script src="{{ asset('assets/global/plugins/bootbox/bootbox.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('button[name=approve]').click(function () {
            var url = $(this).data('href');
            bootbox.confirm('Are you sure you want to approve this coin for listing?', function(result){
                if(result){
                    $.ajax({
                        type:'post',
                        url:url,
                        dataType:'json',
                        success:function(result){
                            if(result.status) {
                                location.reload();
                            }
                        },
                        error: function (result) {
                            console.log(result);
                        }
                    });
                }
            });
        });

        $('button[name=reject]').click(function () {
            var url = $(this).data('href');
            bootbox.confirm('Are you sure you want to reject this coin from listing?', function(result){
                if(result){
                    $.ajax({
                        type:'post',
                        url:url,
                        dataType:'json',
                        success:function(result){
                            if(result.status) {
                                location.reload();
                            }
                        },
                        error: function (result) {
                            console.log(result);
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
