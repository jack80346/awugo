@extends('hotel_auth.main_layout')

<!-- 標題 -->
@section('title', $Title)
<!-- 飯店名稱 -->
@section('hotel_name', $Hotel->name)
@section('hotel_id', $Hotel->nokey)
@section('main_fun', 1)
@section('sub_fun', 'price_suit')

@section('content')

	@if(!is_null(session()->get('controll_back_msg')))
	<!-- 隱藏區塊 -->
	@endif

	<div class="modal fade" id="room_sel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">選擇房型</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <ul>
                @foreach($RoomSelect as $key => $name)
                	<li><input class='ckb' type="checkbox" value="{{$name->nokey}}" />{{$name->name}}</li>
                @endforeach
              </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">OK！</button>
          </div>
        </div>
      </div>
    </div>

<div class="row" style="width: 98%;margin-left: 1%;display:inline-block;">
	<form action="price_suit?s={{$SuitID}}" method="POST" onsubmit="return valid(this);">
		{{ csrf_field() }}

		@if($AddMode)
			<div class="field_div">
				<span class="field_title">套裝名稱：</span>
				<input type="" name="" style="width:350px;color: red;">
				<a href="javascript:room_sel()" style="margin-left: 10px;">按此勾選房型</a>
			</div>
		@else
			<div class="field_div">
				<span class="field_title">選擇方案名稱：</span>
				<select name="room_list" id="room_list" style="width: 250px;" onchange="chgSuit()">
					@foreach($SuitSelect as $key => $suit)
					<option value="{{$suit->nokey}}" @if(!$AddMode && $SuitID==$suit->nokey)selected=''@endif>{{$suit->name}}</option>
					@endforeach
				</select>
				<a href="javascript:editSuit()" class="btn btn-primary btn-sm">修改方案</a>
				<a href="javascript:addSuit()" class="btn btn-primary btn-sm">新增方案+</a>
				<a href="javascript:room_sel()" style="margin-left: 10px;">按此勾選房型</a>
			</div>
		@endif

		<div class="field_div">
			<span class="field_title">住宿人數：</span> <span style="display: inline-block;width: 180px;"></span>
			<span class="field_title">套用房型：</span> <span></span>
		</div>

		<div style="clear:both;">
		<div style="text-align: center;font-weight: bolder;">
			<span style="color: red;">一般常態性之房價設定</span> 
		</div>
		<table width="100%" id="price_table" border="0">
			<tr bgcolor="#FBEEC7">
				<td align="center">人數</td>
				<td align="center">週一~週四</td>
				<td align="center">週五</td>
				<td align="center">週六</td>
				<td align="center">週日</td>
				<td align="center">適用區間</td>
			</tr>
		</table>	
		
	</form>
</div>

@endsection

@section('instyle')
.field_div{
  margin-bottom:10px;
}
.field_title{
  color:green;
  font-weight:bold;
}
@endsection


<!-- js獨立區塊腳本 -->
@section('custom_script')

//勾選優惠人次視窗
function room_sel(){
  $('#room_sel').modal("toggle");
}

function addSuit(){
	window.location.href='price_suit?a=1';
}

function chgSuit(){
	
}
@endsection