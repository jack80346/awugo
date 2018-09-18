@extends('hotel_auth.main_layout')

<!-- 標題 -->
@section('title', $Title)
<!-- 飯店名稱 -->
@section('hotel_name', $Hotel->name)
@section('hotel_id', $Hotel->nokey)
@section('main_fun', 1)
@section('sub_fun', 'price_normal')

@section('content')
@if(!is_null(session()->get('controll_back_msg')))
<!-- 隱藏區塊 -->
@endif

<div class="row" style="width: 98%;margin-left: 1%;display:inline-block;">
	<form action="price_normal?r={{$RoomID}}" method="POST" onsubmit="return valid(this);">
		{{ csrf_field() }}
	<div style="float:left;width:580px;">
		選擇房型：
		<select name="room_list" id="room_list" style="width: 250px;" onchange="chgRoom()">
			@foreach($RoomSelect as $key => $room)
			<option value="{{$room->nokey}}" @if($RoomID==$room->nokey)selected=''@endif>{{$room->name}}</option>
			@endforeach
		</select>
		<a href="javascript:void(0)" onclick="redirectDetail()" >房型詳細資料</a>　幣別　新台幣(元)
	</div>
	<div style="float:right;width:192px;margin-bottom: 10px;">
		<a href="javascript:chgMod()" class="btn btn-primary btn-sm" style="@if($BrowseTag!=1)display:none;@endif">新增或修改區間房價</a>
		<a href="javascript:clonePrice()" class="btn btn-primary btn-sm" style="@if($BrowseTag ==1)display:none;@endif">新增區間房價+</a>
	</div>
	<div style="clear:both;">
		<table width="100%" id="price_table" border="0">
			<tr bgcolor="#FBEEC7">
				<td align="center">人數</td>
				<td align="center">週一~週四</td>
				<td align="center">週五</td>
				<td align="center">週六</td>
				<td align="center">週日</td>
				<td align="center">適用區間</td>
			</tr>
			@foreach($PriceNormal as $key => $normal)
			<tr class="@if(count($RoomSaleArray)>=($key+1))cloneTr @endif a{{floor($key/count($RoomSaleArray)+1)}} " @if(($key+1)%count($RoomSaleArray)==0)style="border-bottom: 5px solid #00366d;" @endif>
				<td width="10%" align="center">{{$normal->people}}<input name="sale_people[]" id="sale_people[]" type="text" value="{{$normal->people}}" style="display:none;"></td>
				<td width="15%" align="center">@if($BrowseTag!=1)<input style="width:50%;border: solid 1px;" name="weekday[]" id="weekday[]" class="weekday" type="text" value="{{$normal->weekday}}">@else{{$normal->weekday}}@endif</td>
				<td width="15%" align="center">@if($BrowseTag!=1)<input style="width:50%;border: solid 1px;" name="friday[]" id="friday[]" class="friday" type="text" value="{{$normal->friday}}">@else{{$normal->friday}}@endif</td>
				<td width="15%" align="center">@if($BrowseTag!=1)<input style="width:50%;border: solid 1px;" name="saturday[]" id="saturday[]" class="saturday" type="text" value="{{$normal->saturday}}">@else{{$normal->saturday}}@endif</td>
				<td width="15%" align="center">@if($BrowseTag!=1)<input style="width:50%;border: solid 1px;" name="sunday[]" id="sunday[]" class="sunday" type="text" value="{{$normal->sunday}}">@else{{$normal->sunday}}@endif</td>
				<td width="30%" align="left" rowspan="{{count($RoomSaleArray)}}" style="@if($key>0 && $key%count($RoomSaleArray)!=0)display:none;@endif @if($key%count($RoomSaleArray)==0) border-bottom: 5px solid #00366d; @endif">
					<input style="display:none;" type="radio" data-ser="{{$normal->people}}{{$normal->merge}}" id="price_year{{$normal->people}}{{$normal->merge}}" name="price_year{{$normal->people}}{{$normal->merge}}" value="0">
					<input style="display:none;" type="radio" value="1" checked="" data-ser="{{$normal->people}}{{$normal->merge}}" id="price_year{{$normal->people}}{{$normal->merge}}" name="price_year{{$normal->people}}{{$normal->merge}}">
					@if($BrowseTag!=1)
					<select data-ser="{{$normal->people}}{{$normal->merge}}" id="price_time_month_start[]" name="price_time_month_start[]" class="st{{floor($key/count($RoomSaleArray)+1)}} dt @if($key%count($RoomSaleArray)==0) xst @endif " onchange="chgDate({{floor($key/count($RoomSaleArray)+1)}},this,'st')" >
						@for($i=1;$i<=12;$i++)
						<option value="{{$i}}" @if(substr($normal->start,5,2)==str_pad($i,2,'0',STR_PAD_LEFT))selected=""@endif>{{str_pad($i,2,'0',STR_PAD_LEFT)}}</option>
						@endfor
					</select>
					@else{{str_pad(substr($normal->start,5,2),2,'0',STR_PAD_LEFT)}}@endif
					月
					@if($BrowseTag!=1)
					<select data-ser="{{$normal->people}}{{$normal->merge}}" id="price_time_day_start[]" name="price_time_day_start[]" class="sd{{floor($key/count($RoomSaleArray)+1)}} sd @if($key%count($RoomSaleArray)==0) xsd @endif " onchange="chgDate({{floor($key/count($RoomSaleArray)+1)}},this,'sd')">
						@for($i=1;$i<=31;$i++)
						<option value="{{$i}}" @if(substr($normal->start,8,2)==str_pad($i,2,'0',STR_PAD_LEFT))selected=""@endif>{{str_pad($i,2,'0',STR_PAD_LEFT)}}</option>
						@endfor
					</select>
					@else{{str_pad(substr($normal->start,8,2),2,'0',STR_PAD_LEFT)}}@endif
					日

					至
					@if($BrowseTag!=1)
					<select data-ser="{{$normal->people}}{{$normal->merge}}" id="price_time_month_end[]" name="price_time_month_end[]" class="et{{floor($key/count($RoomSaleArray)+1)}} et @if($key%count($RoomSaleArray)==0) xet @endif " onchange="chgDate({{floor($key/count($RoomSaleArray)+1)}},this,'et')">
						@for($i=1;$i<=12;$i++)
						<option value="{{$i}}" @if(substr($normal->end,5,2)==str_pad($i,2,'0',STR_PAD_LEFT))selected=""@endif>{{str_pad($i,2,'0',STR_PAD_LEFT)}}</option>
						@endfor
					</select>
					@else{{str_pad(substr($normal->end,5,2),2,'0',STR_PAD_LEFT)}}@endif
					月
					@if($BrowseTag!=1)
					<select id="price_time_day_start[]" name="price_time_day_end[]" class="ed{{floor($key/count($RoomSaleArray)+1)}} ed @if($key%count($RoomSaleArray)==0) xed @endif " onchange="chgDate({{floor($key/count($RoomSaleArray)+1)}},this,'ed')">
						@for($i=1;$i<=31;$i++)
						<option value="{{$i}}" @if(substr($normal->end,8,2)==str_pad($i,2,'0',STR_PAD_LEFT))selected=""@endif>{{str_pad($i,2,'0',STR_PAD_LEFT)}}</option>
						@endfor
					</select>
					@else{{str_pad(substr($normal->end,8,2),2,'0',STR_PAD_LEFT)}}@endif
					日
					<a href="javascript:delTime('a{{floor($key/count($RoomSaleArray)+1)}}')" class="delTime" style="">刪除此區間</a>
				</td>

			</tr>
			@endforeach
		</table>

		@php
			rsort($RoomSaleArray);
		@endphp

		<div style="text-align: center;font-weight: bolder;">
			<span style="color: red;">連續(特殊)假期之房價設定</span> 幣別　新台幣(元)
		</div>

		<table width="100%" id="price_table" border="0">
			<tbody>
			@foreach($PeriodYear as $k=>$year)
				@php
					$YearSpecial = isset($PriceSpecial[$year])?$PriceSpecial[$year]:[];
					if(empty($YearSpecial)){
						$YearSpecialByPeriod = [];
					}else{
						$YearSpecialByPeriod = $YearSpecial->groupBy(function ($item) {
						    return $item['period_start']."~".$item['period_end'];
						});
					}
					$RoomSaleArrayCount = count($RoomSaleArray)+1;
					$YearSpecialByPeriodCount = count($YearSpecialByPeriod);
					$colspan = ($YearSpecialByPeriodCount<$PriceSpecialMaxCount)? $PriceSpecialMaxCount-$YearSpecialByPeriodCount+1: 0;
					//dd($LastYearSpecialByPeriod->toArray());
				@endphp
				<tr>
					<td align="center" @if($RoomSaleArrayCount>1) rowspan="{{ $RoomSaleArrayCount }}" @endif width="190" class="border-bottom">{{ $year }}年 @if($k==0)<div class="icon-cross"><a href="">刪</a> @endif</div>
					<td align="center" width="80">\</td>
					@foreach($YearSpecialByPeriod as $period => $special)
					<td align="center" width="200">{{ $period }}</td>
					@endforeach
					<td align="center" @if($colspan>0) colspan="{{$colspan}}" @endif></td>
					<td align="center" @if($RoomSaleArrayCount>1) rowspan="{{ $RoomSaleArrayCount }}" @endif width="150" class="border-bottom">
						<a href="">新增</a> <a href="">修改</a>
					</td>
				</tr>
				@foreach($RoomSaleArray as $key=>$sale_people)
				<tr class="{{ ($key==count($RoomSaleArray)-1)?'border-bottom':'' }}">
					<td align="center">{{$sale_people}}</td>
					@foreach($YearSpecialByPeriod as $period => $special)
						@php
							$SaleArray = $special->keyBy('people');
						@endphp
						<td align="center">{{ !empty($SaleArray[$sale_people])? $SaleArray[$sale_people]->price: 0 }}</td>
					@endforeach
					<td align="center" @if($colspan>0) colspan="{{$colspan}}" @endif></td>
				</tr>
				@endforeach
			@endforeach	

		</tbody>
		</table>

		<input type="text" value="{{$MergeLastNo+1}}" name="totalPriceSet" id="totalPriceSet" style="display:none;">
		<input type="text" value="{{count($RoomSaleArray)}}" name="totalSalePeople" id="totalSalePeople" style="display:none;">
		<div class="col-md-4 text-center" style="margin: auto;margin-top: 10px;">
			<button type="submit" class="btn btn-primary btn-sm" style="@if($BrowseTag ==1)display:none;@endif">確定修改</button>
		</div>
	</div>
	</form>
</div>
<!-- main -->

@endsection

@section('instyle')
table {  
  border: 1px solid grey;  
  border-collapse: collapse;  
}  
tr, td {  
  border: 1px solid grey;  
}
td > input{
	border: 1px solid #cecece;
}
.border-bottom{
	border-bottom: 5px solid #00366d !important;
}
@endsection

<!-- js獨立區塊腳本 -->
@section('custom_script')

//
function chgDate(no,obj, typeName){
	$('.'+typeName+no).val($(obj).val());
}

//導向客房詳細
function redirectDetail(){
	window.location.href='room_set/'+$("#room_list :selected").val();
}
//切換編輯模式
function chgMod(){
	window.location.href='price_normal?r={{$RoomID}}&b=0';
}
//切換客房
function chgRoom(){
	window.location.href='price_normal?r='+$("#room_list :selected").val()+'&b={{$BrowseTag}}';
}

//刪除區間
function delTime(time){
	if(confirm('確定刪除此區間房價嗎？')){
		$("."+ time).remove();
		$("#totalPriceSet").val((trNo1+1)-1);
		trNo1--;
		time =time.substr(1);
		$.ajax({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        type: "POST",
	        url: 'price_normal_del',
	        data: {room_id:{{$Room_Key}},merge:time},
	        success: function(data) {
	          window.location.reload();
	      }
	    });
	}
}

//複製區間房價表格(除單選紐，其餘改用陣列)
trNo1 ={{$MergeLastNo}};
st=sd=et=ed=0
function clonePrice(){
	trNo1++;
	tr_clone =$(".cloneTr").clone().removeClass("cloneTr").removeClass("a1").addClass("a"+(trNo1+1));
	//房價空白
	tr_clone.children().find('.weekday').attr('value',"0");
	tr_clone.children().find('.friday').attr('value',"0");
	tr_clone.children().find('.saturday').attr('value',"0");
	tr_clone.children().find('.sunday').attr('value',"0");
	//
	if(et <12 && ed<=31){
		if(st==0){
			st =parseInt(tr_clone.children().find('.et1').val());
			sd =parseInt(tr_clone.children().find('.sd1').val());
			et =parseInt(tr_clone.children().find('.et1').val());
			ed =parseInt(tr_clone.children().find('.ed1').val());
		}
		tr_clone.children().find('.st1').val(et+1);
		tr_clone.children().find('.sd1').val(1);
		tr_clone.children().find('.et1').val(12);
		tr_clone.children().find('.ed1').val(31);
		et++;
		st++;
	}
	//
	tr_clone.children().find('.delTime').attr('href',"javascript:delTime('a"+ (trNo1+1) +"')").show();
	tr_clone.children().find("select[class^='st']").addClass('st'+(trNo1+1));
	tr_clone.children().find("select[class^='st']").attr('onchange',"chgDate("+(trNo1+1)+",this,'st')");
	tr_clone.children().find("select[class^='sd']").addClass('sd'+(trNo1+1));
	tr_clone.children().find("select[class^='sd']").attr('onchange',"chgDate("+(trNo1+1)+",this,'sd')");
	tr_clone.children().find("select[class^='et']").addClass('et'+(trNo1+1));
	tr_clone.children().find("select[class^='et']").attr('onchange',"chgDate("+(trNo1+1)+",this,'et')");
	tr_clone.children().find("select[class^='ed']").addClass('ed'+(trNo1+1));
	tr_clone.children().find("select[class^='ed']").attr('onchange',"chgDate("+(trNo1+1)+",this,'ed')");
	//
	@foreach($RoomSaleArray as $key => $sale)
		tr_clone.children().find("input[name^='price_year{{$sale}}']").attr('id','price_year'+($("input[name^='price_year{{$sale}}']").data('ser')+trNo1)).attr('name','price_year'+($("input[name^='price_year{{$sale}}']").data('ser')+trNo1));
		//
	@endforeach
	//
	$("#price_table").append(tr_clone);
	$("#totalPriceSet").val((trNo1+1));
}
function valid(obj){
	setCount =parseInt($('#totalPriceSet').val())*parseInt($('#totalSalePeople').val());
	dateStr ='';
	beforeDT ='';
	nowDT ='';
	today=new Date();
	allow =true;
	//alert($('.xsd').length);
	if($('.xsd').length >1){
		//alert($('.xsd').length);
		$('.xsd').each(function(i){
			if(i>0){
				//上一個結束日
				beforeDT =today.getFullYear()+'/'+$('.xet').eq(i-1).val()+'/'+validDate($('.xet').eq(i-1).val(),$('.xed').eq(i-1).val());
				//本次開始日
				nowDT =today.getFullYear()+'/'+$('.xst').eq(i).val()+'/'+validDate($('.xst').eq(i).val(),$('.xsd').eq(i).val());
				if(Date.parse(beforeDT) > Date.parse(nowDT)){
					//alert(Date.parse(beforeDT) > Date.parse(nowDT));
					allow =false;
				}
			}
			//alert((parseInt(Date.parse(beforeDT)+1) > Date.parse(nowDT))+','+Date.parse(beforeDT)+','+Date.parse(nowDT));
		});
		if(!allow){
			alert('日期重複.請重新設定');
		}
	}
	//return false;
	return allow;
}

function validDate(mon,day){
	var monDay =[31,28,31,30,31,30,31,31,30,31,30,31];
	if(day<31){
		return day;
	}
	if(day == 31){
		for(var i=0;i<monDay.length;i++){
			if((i+1)==mon){
				day =monDay[i];
				break;
			}
		}
	}
	return day;
}
@endsection

<!-- jQuery ready 狀態內閉包內插 -->
@section('custom_ready_script')
//alert(Date.parse('2018-03-31')>Date.parse('2018-04-1'));
$(".delTime").eq(0).hide();
@if($MergeLastNo ==0 && $PriceNormal[0]->weekday =='' && $BrowseTag==1)
	//alert('{{$MergeLastNo}}');
	$('.cloneTr').hide();
@endif

@endsection