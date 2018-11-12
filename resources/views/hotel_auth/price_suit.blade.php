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

<div class="row" style="width: 98%;margin-left: 1%;display:inline-block;">
	<form action="price_suit?s={{$SuitID}}" method="POST" onsubmit="return valid(this);">
		{{ csrf_field() }}

		@if($AddMode)
		<div style="float:left;width:580px;">
			套裝名稱：
			<input type="" name="">
		</div>
		@else

		<div style="float:left;width:580px;">
			選擇房型：
			<select name="room_list" id="room_list" style="width: 250px;" onchange="chgRoom()">
				@foreach($RoomSelect as $key => $room)
				<option value="{{$room->nokey}}" @if(!$AddMode && $RoomID==$room->nokey)selected=''@endif>{{$room->name}}</option>
				@endforeach
			</select>
			<a href="javascript:void(0)" onclick="redirectDetail()" >房型詳細資料</a>　幣別　新台幣(元)
		</div>
		@endif

	</form>
</div>

@endsection