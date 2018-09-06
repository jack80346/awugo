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
	        處理完成
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">OK！</button>
	      </div>
	    </div>
	  </div>
	</div>
@endif
<div class="row">
	<div style="text-align:left;" class="col-md-6">
		<a href="/{{$Country}}/auth/manager/hotel_browse/{{$Hotel->nokey}}">{{$Hotel->name}}</a>／權限管理
	</div>
	<div style="text-align:right;" class="col-md-6">
		<a href="/{{$Country}}/auth/h{{$Hotel->nokey}}" class="btn btn-secondary">進入{{$Hotel->name}}後台</a>
		<a href="/{{$Country}}/auth/manager/hotel_auth_add/{{$Hotel->nokey}}" class="btn btn-secondary">新增飯店管理帳號</a>
	</div>
</div>

<table class="table table-hover" style="margin-top:10px;">
  <thead class="thead-light">
    <tr>
      <th scope="col">帳號</th>
      <th scope="col">使用者</th>
      <th scope="col">部門</th>
      <th scope="col">操作人員</th>
      <th scope="col">操作人IP</th>
      <th scope="col">最後更動時間</th>
      <th scope="col">啟用狀態</th>
    </tr>
  </thead>
  <tbody>
  	@foreach($Managers as $key => $Manager)
    <tr style="cursor: pointer;">
      <th scope="row" onclick="window.location.href='../hotel_auth_edit/{{$Hotel->nokey}}/{{$Manager->nokey}}'">{{$Manager->id}}</th>
      <td onclick="window.location.href='../hotel_auth_edit/{{$Hotel->nokey}}/{{$Manager->nokey}}'">{{$Manager->name}}</td>
      <td onclick="window.location.href='../hotel_auth_edit/{{$Hotel->nokey}}/{{$Manager->nokey}}'">{{$Manager->department}}</td>
      <td>{{$Manager->created_name}}</td>
      <td><a href="https://zh-hant.ipshu.com/ip_map?ip={{$Manager->ip}}" target='_blank'>{{$Manager->ip}}</a></td>
      <td onclick="window.location.href='../hotel_auth_edit/{{$Hotel->nokey}}/{{$Manager->nokey}}'">{{$Manager->updated_at->format('Y-m-d H:i')}}</td>
      <td>
      	<!-- 預設啟動狀態 -->
      	@if($Manager->enable ==0)
	      	關閉
		@else
			啟用
		@endif
      </td>
    </tr>
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

@endsection
<!-- jQuery ready 狀態內閉包內插 -->
@section('custom_ready_script')
	//停用完成跳出確認
	@if(!is_null(session()->get('controll_back_msg')))
		$('#okAlert').modal("toggle");
	@endif
@endsection