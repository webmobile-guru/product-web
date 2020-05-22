@extends('admin.layouts.master')
@section('page-bar')
    <!-- BEGIN PAGE BAR -->
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="{{ url('/home') }}">{{trans('admin/ico/index.Home')}}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>{{trans('admin/ico/index.Manage_Ico')}}</span>
            </li>
        </ul>
    </div>
    <!-- END PAGE BAR -->
    <!-- BEGIN PAGE TITLE-->
    <h1 class="page-title">
        {{trans('admin/ico/index.ICO')}}
        <small>{{trans('admin/ico/index.Management')}}</small>
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
                        <span class="caption-subject font-red sbold uppercase">{{trans('admin/ico/index.Manage_ICO')}}</span>
                    </div>
                    {{--<div class="actions">
                        <button class="btn red btn-outline sbold" name="create">Add ICO </button>
                    </div>--}}
                </div>
                <div class="portlet-body">
                    <div class="table-scrollable">
                        <table class="table table-hover table-light">
                            <thead>
                                <tr>
                                    <th> {{trans('admin/ico/index.Logo')}} </th>
                                    <th> {{trans('admin/ico/index.ICO_Name')}}  </th>
                                    <th> {{trans('admin/ico/index.Description')}} </th>
                                    <th> {{trans('admin/ico/index.Sale_Start')}} </th>
                                    <th> {{trans('admin/ico/index.Sale_End')}} </th>
                                    <th> {{trans('admin/ico/index.Publish_Status')}} </th>
                                    <th>{{trans('admin/ico/index.Status')}}  </th>
                                    <th style="width:20%" class="text-center"> {{trans('admin/ico/index.Action')}} </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($icos as $ico)
                                    <tr>
                                        <td><img src="{{ url($ico->logo) }}" alt="" style="height: 70px; width: 70px;"></td>
                                        <td>{{ $ico->title }}</td>
                                        <td>@php echo substr($ico->short_description,0,60) @endphp ...</td>
                                        <td>{{ isset($ico->ico_start_at)?\Carbon\Carbon::parse($ico->ico_start_at)->toDateString():'TBD' }}</td>
                                        <td>{{ isset($ico->ico_start_at)?\Carbon\Carbon::parse($ico->ico_start_at)->toDateString():'TBD' }}</td>
                                        <td><span class="text-{{ ['info', 'success', 'danger'][$ico->publish_status] }}">{{ ['Pending', 'Approved', 'Rejected'][$ico->publish_status] }}</span></td>
                                        <td>{{ $ico->status }}</td>
                                        <td>
                                            <a href="{{ route('admin.ico.display', $ico->slug) }}" class="btn btn-xs btn-info" title="View! view complete detailed description of ico"><i class="fa fa-eye"></i></a>
                                            <a href="{{ route('admin.ico.edit', $ico->slug) }}"  class="btn btn-xs btn-warning" title="Edit! here you can modify data of ico"><i class="fa fa-edit"></i></a>
                                            @if($ico->publish_status == 0)
                                                <button name="approve" class="btn btn-xs btn-success" data-url="{{ route('admin.ico.approve', $ico->slug) }}" title="Approve! approve the ico for publish, will be seen on list"><i class="fa fa-check"></i></button>
                                                <button name="reject" class="btn btn-xs btn-danger" data-url="{{ route('admin.ico.reject', $ico->slug) }}" title="Reject! reject the ico for publish on list"><i class="fa fa-times"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="8" class="text-center"> {{trans('admin/ico/index.Data_doesnot_exists')}}</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                         <div class="row" style="float:right;">{{ $icos->links() }}</div>
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
            var action = $(this).data('url');
            var csrf = $('meta[name=csrf-token]').attr('content');
            bootbox.confirm("<form id='infos' method='post' action='"+ action +"'>\
            <input type='hidden' name='_token' value='"+csrf+"'>\
                Publish On:<input type='date' name='publish_on' class='form-control' /><br/>\
                Remarks:<input type='text' name='remarks' class='form-control' />\
                </form>", function(result) {
                if(result)
                    $('#infos').submit();
            });
        });

        $('button[name=reject]').click(function () {
            var action = $(this).data('url');
            var csrf = $('meta[name=csrf-token]').attr('content');
            bootbox.confirm("<form id='infos' method='post' action='"+ action +"'>\
            <input type='hidden' name='_token' value='"+csrf+"'>\
                Reason of rejection:<input type='text' name='remarks' class='form-control' />\
                </form>", function(result) {
                if(result)
                    $('#infos').submit();
            });
        });
    });
</script>
@endpush
