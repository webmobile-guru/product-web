@extends('admin.layouts.master')
@section('page-bar')
        <!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <span>{{trans('admin/news/index.Dashboard')}}</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('admin/news/index.News')}}
    <small>{{trans('admin/news/index.Management')}}</small>
</h1>
<!-- END PAGE TITLE-->
@endsection
@section('contents')
@include('flash::message')

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-settings font-red"></i>
                        <span class="caption-subject font-red sbold uppercase">{{trans('admin/news/index.News_Publishing_Management')}}</span>
                    </div>
                    <div class="actions">
                        <a href="{{ route('admin.news.create') }}" class="btn red btn-outline sbold">{{trans('admin/news/index.Add_News')}}  </a>
                    </div>
                </div>
                <div class="portlet-body">
                    @foreach($news as $item)
                        <div class="well well-sm">
                            <h4 class="block">{{ $item->heading }}</h4>
                            {!! html_entity_decode($item->content) !!}
                            <p class="text-right">{{trans('admin/news/index.Posted')}} <strong>{{ $item->user->full_name }}</strong> {{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</p>
                            <form style="float: right;" action="{{route('admin.news.delete')}}" method="POST">
                                <input type="hidden" name="_token" value="{{ csrf_token()  }}">
                                <input type="hidden"  name="id" value="{{ $item->id }}">
                                <button class="btn btn-block btn-primary" type="submit">Delete</button>               
                            </form>
                            <br style="clear:both" />
                        </div>
                    @endforeach
                </div>
                <div class="portlet-footer text-right">{{ $news->links() }}</div>
            </div>
        </div>
    </div>
@endsection
