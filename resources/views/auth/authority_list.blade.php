@extends('auth.main_layout')

<!-- 標題 -->
@section('title', $Title)

<!-- 導航按鈕按下狀態編號 -->
@section('nav_id', $Nav_ID)
<!-- 內容 -->
@section('content')
@if(!is_null(session()->get('controll_back_msg')))
	<div class="modal fade" id="okAlert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">確定</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        已停用此帳號
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">OK！</button>
	      </div>
	    </div>
	  </div>
	</div>
@endif
@if(in_array('34',$Auths))
<div style="text-align:right;">
	<a href="/{{$Country}}/auth/manager/authority_add" class="btn btn-secondary">新增帳號</a>
</div>
@endif

<table class="table table-hover" style="margin-top:10px;">
  <thead class="thead-light">
    <tr>
      <th scope="col">帳號</th>
      <th scope="col">使用者</th>
      <th scope="col">部門</th>
      <th scope="col">最後登入</th>
      @if(in_array('35',$Auths))
      <th scope="col">啟用狀態</th>
      @endif
    </tr>
  </thead>
  <tbody>
  	@foreach($Managers as $key => $Manager)
  	@if($Manager->id !='oxo')
    <tr style="cursor: pointer;">
      <th scope="row" onclick="window.location.href='./authority_edit/{{$Manager->nokey}}'">{{$Manager->id}}</th>
      <td onclick="window.location.href='./authority_edit/{{$Manager->nokey}}'">{{$Manager->name}}</td>
      <td onclick="window.location.href='./authority_edit/{{$Manager->nokey}}'">{{$Manager->department}}</td>
      <td onclick="window.location.href='./authority_edit/{{$Manager->nokey}}'">{{$Manager->updated_at->format('Y-m-d H:i')}}</td>
      @if(in_array('35',$Auths))
      <td>
      	<!-- 預設啟動狀態 -->
      	@if($Manager->enable ==0)
	      	<label class="custom-control custom-checkbox">
		    	<input type="checkbox" class="custom-control-input" value="" onchange="chg_enable(this,{{$Manager->nokey}})">
			    <span class="custom-control-indicator"></span>
			</label>
		@else
			<label class="custom-control custom-checkbox">
		    	<input checked="checked" type="checkbox" class="custom-control-input" value="" onchange="chg_enable(this,{{$Manager->nokey}})">
			    <span class="custom-control-indicator"></span>
			</label>
		@endif
      </td>
      @endif
    </tr>
    @endif
    @endforeach
  </tbody>
</table>
<!-- 分頁 -->
<div id="nav_pagerow">
{{ $Managers->links('vendor.pagination.bootstrap-4') }}
</div>
@endsection
<!-- style內置區塊 -->
@section('instyle')
/** 分頁樣式 */
#nav_pagerow{
	float: right;
	left: -50%;
	position: relative;
}
#nav_pagerow > ul{
	float:left;
	left: 50%;
	position: relative;
}
@endsection
<!-- js獨立區塊腳本 -->
@section('custom_script')
	function chg_enable(ckbox, root_key){
		$(ckbox).prop("disabled", true);
		val=1;
		if(!$(ckbox).prop("checked")){
			val=0;
		}
		$.ajax({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        type: "POST",
	        url: 'authority_enable/'+root_key,
	        data: {enable:val},
	        success: function(data) {
	        	window.setTimeout(function(){$(ckbox).prop("disabled", false);}, 2000 );
	    	}
	    });
	}
@endsection
<!-- jQuery ready 狀態內閉包內插 -->
@section('custom_ready_script')
	//停用完成跳出確認
	@if(!is_null(session()->get('controll_back_msg')))
		$('#okAlert').modal("toggle");
	@endif
	//移除權限不足則無法點即行列進入編輯頁面的效果
	@if(!in_array('35',$Auths))
		//移除可點樣式與連結
		$('tr').removeAttr("style").find('td').removeAttr("onclick");
		$('tr > th').removeAttr("onclick");
	@endif
@endsection