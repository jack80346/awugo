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
              <ul id="room_sel_ul">
                @foreach($RoomSelect as $key => $name)
                	<li><input class='ckb' type="checkbox" value="{{$name->nokey}}" data-people="{{$name->sale_people}}"/>{{$name->name}}</li>
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

		<div class="field_div">
			<span class="field_title">新增方案名稱：</span>
			<input type="" name="" style="width:350px;color: red;">
			<a href="javascript:room_sel()" style="margin-left: 10px;">按此勾選房型</a>
		</div>

		<div class="field_div">
			<span class="field_title">住宿人數：</span> <span id="room_sel_people" style="display: inline-block;width: 180px;"></span>
			<span class="field_title">套用房型：</span> <span id="room_sel_all" style="color:blue;"></span>
			<input type="hidden" id="room_sel_csv" name="room_sel_csv" value="">
		</div>

		<div style="float:right;width:192px;margin-bottom: 10px;">
			<a href="javascript:chgMod()" class="btn btn-primary btn-sm">修改房價</a>
			<a href="javascript:clonePrice()" class="btn btn-primary btn-sm">新增區間房價+</a>
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

<script id="hidden-template" type="text/x-custom-template">
<tr class="cloneTr " style="border-bottom: 5px solid #00366d;">
	<td width="10%" align="center" class="sale_people"><input name="sale_people[]" id="sale_people[]" type="text" value="" style="display:none;"></td>
	<td width="15%" align="center"><input style="widt族h:50%;border: solid 1px;" name="weekday[]" id="weekday[]" class="weekday" type="text" value=""></td>
	<td width="15%" align="center"><input style="width:50%;border: solid 1px;" name="friday[]" id="friday[]" class="friday" type="text" value=""></td>
	<td width="15%" align="center"><input style="width:50%;border: solid 1px;" name="saturday[]" id="saturday[]" class="saturday" type="text" value=""></td>
	<td width="15%" align="center"><input style="width:50%;border: solid 1px;" name="sunday[]" id="sunday[]" class="sunday" type="text" value=""></td>
	<td width="30%" align="left" rowspan="1" style="  border-bottom: 5px solid #00366d; ">
	<input style="display:none;" type="radio" data-ser="50" id="price_year50" name="price_year50" value="0">
	<input style="display:none;" type="radio" value="1" checked="" data-ser="50" id="price_year50" name="price_year50">
	<select data-ser="50" id="price_time_month_start[]" name="price_time_month_start[]" class="st1 dt  xst  " onchange="chgDate(1,this,'st')">
	@for($i=1;$i<=12;$i++)
		<option value="{{$i}}">{{str_pad($i,2,'0',STR_PAD_LEFT)}}</option>
	@endfor
	</select>
	月
	<select data-ser="50" id="price_time_day_start[]" name="price_time_day_start[]" class="sd1 sd  xsd  " onchange="chgDate(1,this,'sd')">
	@for($i=1;$i<=31;$i++)
		<option value="{{$i}}">{{str_pad($i,2,'0',STR_PAD_LEFT)}}</option>
	@endfor
	</select>
	日
	至
	<select data-ser="50" id="price_time_month_end[]" name="price_time_month_end[]" class="et1 et  xet  " onchange="chgDate(1,this,'et')">
	@for($i=1;$i<=12;$i++)
		<option value="{{$i}}">{{str_pad($i,2,'0',STR_PAD_LEFT)}}</option>
	@endfor
	</select>
	月
	<select id="price_time_day_start[]" name="price_time_day_end[]" class="ed1 ed  xed  " onchange="chgDate(1,this,'ed')">
	@for($i=1;$i<=31;$i++)
		<option value="{{$i}}">{{str_pad($i,2,'0',STR_PAD_LEFT)}}</option>
	@endfor
	</select>
	日
	<a href="javascript:delTime('a1')" class="delTime" style="display: none;">刪除此區間</a>
	</td>
</tr>
</script>
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

function union_arrays (x, y) {
  var obj = {};
  for (var i = x.length-1; i >= 0; -- i)
     obj[x[i]] = x[i];
  for (var i = y.length-1; i >= 0; -- i)
     obj[y[i]] = y[i];
  var res = []
  for (var k in obj) {
    if (obj.hasOwnProperty(k))  // <-- optional
      res.push(obj[k]);
  }
  return res;
}

function array_trim (arr){
	var tmp = [];
	for( var x in arr){
		if(arr[x] !=''){
			tmp.push(arr[x]);
		}	
	}
	return tmp;
}

@endsection

<!-- jQuery ready 狀態內閉包內插 -->
@section('custom_ready_script')

$("#room_sel_ul input.ckb").on('change',function(){
	
	var dd = [];
	var pp = [];
	$("#room_sel_ul input.ckb:checked").each(function(){
		var tt = $(this).parent().text();
		var people = array_trim($(this).data('people').split(','));

		dd.push(tt);
		pp = union_arrays(pp, people);
	});
	$('#room_sel_all').text(dd.join(' ,'));
	$('#room_sel_people').text(pp.join(' ,'));

	$('tr.add_clum').remove();
	for(var x in pp){
		console.log(pp[x]);
		var template = $('#hidden-template').find('td.sale_people').text(pp[x]).html();
		console.log(template);
		$("#price_table").append(template);
	}
	
});

@endsection