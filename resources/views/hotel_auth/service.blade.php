@extends('hotel_auth.main_layout')

<!-- 標題 -->
@section('title', $Title)
@section('sub_fun', 'service')
@section('main_fun', 0)
<!-- 飯店名稱 -->
@section('hotel_name', $Hotel->name)

@section('content')
@if(!is_null(session()->get('controll_back_msg')))
    <div class="modal fade" id="okAlert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">編輯完成</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            已編輯成功
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">OK！</button>
          </div>
        </div>
      </div>
    </div>
@endif

<form action="service" method="POST">
	{{ csrf_field() }}
	<div style="width: 98%;margin: auto;">
		<table width="100%">
			@foreach($ServiceGroups as $i => $group)
			<tr>
				<td>
					<div class="row service_group" style="display: block;margin:0px;color:#269547;">{{$group->service_name}}</div>
					<div class="row service_item" style="margin:0px;margin-bottom: 20px;">
						@foreach($ServiceItems as $j => $item)
							@if($item->parent == $group->nokey)
							<div class="col-md-2 service_item">
								<div class="input-group">
									<div class="checkbox checkbox-primary" style="padding-top:5px;">
										<input onchange="check_service(this)" type="checkbox" class="checkbox" value="{{$item->nokey}}" data-id="{{$item->nokey}}" id="service{{$item->nokey}}" name="service[]" @if(in_array($item->nokey,$HotelServiceID)) checked="" @endif>
										<label for="service{{$item->nokey}}">{{$item->service_name}}</label>
										@if($item->upload)
											<span style="display: none;"><a class="fancybox fancybox.iframe" data-type="iframe" data-src="service_photo/{{$item->nokey}}" href="service_photo/{{$item->nokey}}" data-toggle="lightbox" style="font-size: 0.8rem;">說明</a></span>
										@endif
									</div>
								</div>
							</div>
							@endif
						@endforeach
					</div>
				</td>
			</tr>
			@endforeach
		</table>
	</div>

		<button class="btn btn-lg btn-primary btn-block" type="submit" style="width: 95%;margin:auto">儲存資料</button>
</form>
<!-- main -->

@endsection

@section('instyle')


.service_group{
	font-weight:bold;
	padding:10px;
}
.service_item{
	
}
.service_select {
	color:#E5670D;
}
@endsection

<!-- js獨立區塊腳本 -->
@section('custom_script')

//判斷是否勾選，勾選變藍字
function check_service(obj){
	if($(obj).prop("checked")){
		$(obj).parent().addClass("service_select").find("span").show();
	}else{
		$(obj).parent().removeClass("service_select").find("span").hide();
	}
}

@endsection

<!-- jQuery ready 狀態內閉包內插 -->
@section('custom_ready_script')
//將已勾選的設施服務加上藍字
$(".service_item > .input-group > .checkbox > input:checkbox:checked").parent().addClass("service_select").find("span").show();


//啟動lightbox效果
$(".fancybox").fancybox({
	'width': 850,
    'height': 250,
    'transitionIn': 'elastic', // this option is for v1.3.4
    'transitionOut': 'elastic', // this option is for v1.3.4
    // if using v2.x AND set class fancybox.iframe, you may not need this
    'type': 'iframe',
    // if you want your iframe always will be 600x250 regardless the viewport size
    'fitToView' : false,  // use autoScale for v1.3.4
    afterClose  : function() { 
    	//關閉後自動重整
        //window.location.reload();
    }
});
//停用完成跳出確認
    @if(!is_null(session()->get('controll_back_msg')))
        $('#okAlert').modal("toggle");
    @endif
@endsection