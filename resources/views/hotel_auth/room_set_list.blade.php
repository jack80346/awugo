@extends('hotel_auth.main_layout')

<!-- 標題 -->
@section('title', $Title)
@section('sub_fun', 'room_set')
@section('main_fun', 0)
<!-- 飯店名稱 -->
@section('hotel_name', $Hotel->name)
@section('hotel_id', $Hotel->nokey)

@section('content')

    <div class="modal fade" id="okAlert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">套用下列範例名稱</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              123
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">OK！</button>
          </div>
        </div>
      </div>
    </div>

<div>
<ul style="list-style: none;">
  <li class="count_type" style="width: 70px;"><a href="room_set"@if($PeopleQ==''&&$TypeQ=='') style="color:red"@endif>全部房型</a></li>
  @if(in_array(1,$RoomTypeDistinctArray))<li class="count_type" style="width: 70px;"><a href="room_set?t=1"@if($TypeQ=='1') style="color:red" @endif>背包客</a></li>@endif
  @if(in_array(1,$PeopleDistinctArray))<li class="count_type"><a href="room_set?p=1"@if($PeopleQ=='1') style="color:red" @endif>1人</a></li>@endif
  @if(in_array(2,$PeopleDistinctArray))<li class="count_type"><a href="room_set?p=2"@if($PeopleQ=='2') style="color:red" @endif>2人</a></li>@endif
  @if(in_array(3,$PeopleDistinctArray))<li class="count_type"><a href="room_set?p=3"@if($PeopleQ=='3') style="color:red" @endif>3人</a></li>@endif
  @if(in_array(4,$PeopleDistinctArray))<li class="count_type"><a href="room_set?p=4"@if($PeopleQ=='4') style="color:red" @endif>4人</a></li>@endif
  @if(in_array(5,$PeopleDistinctArray))<li class="count_type"><a href="room_set?p=5"@if($PeopleQ=='5') style="color:red" @endif>5人</a></li>@endif
  @if(in_array(6,$PeopleDistinctArray))<li class="count_type"><a href="room_set?p=6"@if($PeopleQ=='6') style="color:red" @endif>6人</a></li>@endif
  @if(in_array(7,$PeopleDistinctArray))<li class="count_type"><a href="room_set?p=7"@if($PeopleQ=='7') style="color:red" @endif>7人</a></li>@endif
  @if(in_array(8,$PeopleDistinctArray))<li class="count_type"><a href="room_set?p=8"@if($PeopleQ=='8') style="color:red" @endif>8人</a></li>@endif
  @if(in_array(9,$PeopleDistinctArray))<li class="count_type"><a href="room_set?p=9"@if($PeopleQ=='9') style="color:red" @endif>9人</a></li>@endif
  @if(in_array(10,$PeopleDistinctArray))<li class="count_type"><a href="room_set?p=10"@if($PeopleQ=='10') style="color:red" @endif>10人</a></li>@endif
  @if(in_array(11,$PeopleDistinctArray))<li class="count_type"><a href="room_set?p=11"@if($PeopleQ=='11') style="color:red" @endif>11人</a></li>@endif
  @if(in_array(12,$PeopleDistinctArray))<li class="count_type"><a href="room_set?p=12"@if($PeopleQ=='12') style="color:red" @endif>12人</a></li>@endif
  @if($MaxPeopleCount >0)<li class="count_type" style="width: 70px;"><a href="room_set?p=13"@if($PeopleQ=='13') style="color:red" @endif>13人以上</a></li>@endif
  @if(in_array(2,$RoomTypeDistinctArray))<li class="count_type"><a href="room_set?t=2"@if($TypeQ=='2') style="color:red" @endif>包棟</a></li>@endif
  @if(in_array(3,$RoomTypeDistinctArray))<li class="count_type"><a href="room_set?t=3"@if($TypeQ=='3') style="color:red" @endif>包層</a></li>@endif
  @if(in_array(4,$RoomTypeDistinctArray))<li class="count_type"><a href="room_set?t=4"@if($TypeQ=='4') style="color:red" @endif>露營</a></li>@endif
</ul>
<div style="width:100px;float:right;top: -45px;position:relative;"><a href="./room_set/add">新增房型</a></div>
</div>
@foreach($RoomSet as $key => $room)
<div>
  <table width="100%" class="main_table" border="0" cellspacing="0" cellpadding="0" style="">
    <tbody>
    <tr>
      <td width="15%" height="150" rowspan="3" bgcolor="#FFFFFF" ><div align="center"><img src="/photos/room/250/{{$RoomPhotosArray[$key]}}" width="188" height="137"></div></td>
      <td bgcolor="#FBEEC7" align="center" style="width: 300px;">房型名稱</td>
      <td bgcolor="#FBEEC7" align="center" style="width: 500px;" >床型</td>
      <td bgcolor="#FBEEC7" align="center" >住宿人數</td>
      <td bgcolor="#FBEEC7" align="center" >總間數</td>
      <td bgcolor="#FBEEC7" align="center" >開放間數</td>
      <td bgcolor="#FBEEC7" align="center" >面積(坪)</td>
      <td rowspan="2" valign="top" align="center">
        <a href="room_set/{{$room->nokey}}">編輯</a>
        <br>
        <br>
        <a href="room_del/{{$room->nokey}}" onclick="return confirm('確定要刪除嗎？')">刪除</a>
      </td>
    </tr>
    <tr>
      <td bgcolor="#FFFFFF" style="color:red"><div align="left">{{$room->name}}</div></td>
      <td bgcolor="#FFFFFF" >
        @foreach($RoomBeds[$key] as $rkey => $bed)
          {{$bed}} <br>
        @endforeach
      </td>
      <td bgcolor="#FFFFFF" align="center" >{{$room->min_people}}</td>
      <td bgcolor="#FFFFFF" align="center" >{{$room->room_count}}</td>
      <td bgcolor="#FFFFFF" align="center" >{{$room->room_open_count}}</td>
      <td bgcolor="#FFFFFF" align="center" >{{$room->room_area}}</td>
      </tr>
    <tr>
      <td colspan="8" bgcolor="#FFFFFF"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
        <tbody><tr>
          <td style="border: 0px;"><span style="color:#269547;font-weight: bold;">房間特色：</span>{{$room->room_feature}}</td>
        </tr>
        <tr>
          <td style="border: 0px;"><span style="color:#269547;font-weight: bold;">房內設施：</span>
            @foreach($DeviceArray[$key] as $kk => $device)
                @foreach($Device as $k => $dv)
                  @if($dv->nokey ==$device)
                    {{$dv->service_name}}｜
                  @endif
                @endforeach
            @endforeach
          </td>
        </tr>
      </tbody></table></td>
      </tr>
  </tbody></table>
  <p></p>
</div>
@endforeach
<!-- main -->

@endsection

@section('instyle')
.count_type{
  display: inline-block;
  width:45px;
  text-align:center;
}
.main_table {
    width:98%;
    margin: auto;
    border: 1px solid #999; border-collapse: collapse;
}
.main_table > tr, td {
    border: 1px solid #999;
}

@endsection

<!-- js獨立區塊腳本 -->
@section('custom_script')
//$('.checkbox :checked').parent().addClass("service_select");



@endsection

<!-- jQuery ready 狀態內閉包內插 -->
@section('custom_ready_script')

@endsection