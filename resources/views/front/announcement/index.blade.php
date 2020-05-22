
@extends('front.user')
@section('content')
@include('front.layout.user-header')
<section class="small_padding bg_color1">
    <div class="container">
    <div class="all_heading text-center">
        <h2>{{trans('front/announcement/index.Announcements')}}</h2>
      </div>

        <div class="card_shadow">
            
            <div class="table-responsive">
            
            <table class="table buy_order_table market_trade table-hover">
                    <thead>
                    <tr>
                        <th>{{trans('front/announcement/index.Heading')}}</th>
                        <th>{{trans('front/announcement/index.Content')}}</th>
                        <th>{{trans('front/announcement/index.Created_at')}}</th> 
                        
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($news as $new)
                            <tr>
                                <td>{{ $new->heading }}</td>
                                <td class="viewContent" data-id="{{$new->id}}" data-toggle="modal" data-target="#myModal" style="cursor: pointer;">{{trans('front/announcement/index.view')}}</td>
                                <td>{{ $new->created_at }}</td>
                               
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>


 <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title announcement_heading"></h4>
        </div>
        <div class="modal-body">
          <p class="announcement_content"></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<!--deposite_modal-->
@endsection
@push('js')
<script type="text/javascript">
    
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
	$(document).on("click",".viewContent",function() {
       
		var news_id =  $(this).attr('data-id');  
		var url = baseURL + 'announcement/'+ news_id; 
		$.ajax({
            url:url,
            type:'GET',
            dataType:'json',
            
            success:function(result) { 
                $('.announcement_heading').html(result.news.heading);
                $('.announcement_content').html(result.news.content);
            },
            error:function(result) {
				
            },
		});
	});


</script>
@endpush

