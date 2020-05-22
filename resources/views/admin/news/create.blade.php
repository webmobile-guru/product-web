@extends('admin.layouts.master')
@section('page-bar')
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <span>{{trans('admin/news/create.Dashboard')}}</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h1 class="page-title">
    {{trans('admin/news/create.News')}}
    <small>{{trans('admin/news/create.Management')}}</small>
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
                        <span class="caption-subject font-red sbold uppercase">{{trans('admin/news/create.News_Publishing_Management')}}</span>
                    </div>
                    <div class="actions">
                        <a href="{{ route('admin.news.index') }}" class="btn red btn-outline sbold"> {{trans('admin/news/create.Back')}} </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <form class="form-horizontal" action="{{ route('admin.news.store') }}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token()  }}">
                        <div class="form-group has-{{ $errors->has('heading')?'error':'feedback' }}">
                            <label class="col-md-3 control-label">{{trans('admin/news/create.Heading')}}: </label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="heading" value="{{ old('heading') }}">
                                <p class="help-block">{{ $errors->first('heading') }}</p>
                            </div>
                        </div>
                        <div class="form-group has-{{ $errors->has('content')?'error':'feedback' }}">
                            <label class="col-md-3 control-label">{{trans('admin/news/create.Content')}}: </label>
                            <div class="col-md-9">
                                <textarea name="content" class="form-control" rows="12" >{{ old('content') }}</textarea>
                                <p class="help-block">{{ $errors->first('content') }}</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12 text-right">
                                <button class="btn btn-danger" type="reset"><i class="fa fa-refresh"></i>{{trans('admin/news/create.Reset')}} !</button>
                                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>{{trans('admin/news/create.Create')}} !</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
<link href="{{ asset('assets/global/plugins/bootstrap-summernote/summernote.css') }}" rel="stylesheet">
@endpush
@push('js')
<script type="text/javascript" src="{{ asset('assets/global/plugins/bootstrap-summernote/summernote.js') }}"></script>
<script>
    $(document).ready(function() {
        $('textarea[name=content]').summernote({
            height:300
        });
    });
</script>
@endpush

