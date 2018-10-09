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
	<form action="price_normal?r={{$RoomID}}" method="POST" id="price_normal_form" onsubmit="return valid(this);">
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
		<a href="javascript:chgMod()" class="btn btn-primary btn-sm">修改房價</a>
		<a href="javascript:clonePrice()" class="btn btn-primary btn-sm">新增區間房價+</a>
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
				<td width="15%" align="center">@if($BrowseTag!=1)<input style="widt族h:50%;border: solid 1px;" name="weekday[]" id="weekday[]" class="weekday" type="text" value="{{$normal->weekday}}">@else{{$normal->weekday}}@endif</td>
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
		<div>&nbsp;</div>
		<div style="text-align: left;float: left;">
			<span style="display: inline-block;left: 110px;position: absolute;">日期填寫範例:2月10日請寫為0210</span> 
		</div>
		<div style="text-align: right;float: right;">
			政府公告節日表 <a href="#">107</a> <a href="#">108</a>
		</div>
		<div style="text-align: center;font-weight: bolder;">
			<span style="color: red;">連續(特殊)假期之房價設定</span> 
		</div>
		

		<table width="100%" id="price_table_special" border="0">
			<tbody>
			@foreach($PeriodYear as $k=>$year)
				@php
					$YearSpecial = isset($PriceSpecial[$year])?$PriceSpecial[$year]:[];
					if(empty($YearSpecial)){
						$YearSpecialByPeriod = [];
					}else{
						$YearSpecialByPeriod = $YearSpecial->groupBy(function ($item) {
						    if($item['period_start'] == $item['period_end']){
						    	return $item['period_start'];
						    }else{
						    	return $item['period_start']."~".$item['period_end'];
						    }
						});
					}
					$RoomSaleArrayCount = count($RoomSaleArray)+1;
					$YearSpecialByPeriodCount = count($YearSpecialByPeriod);
					$colspan = ($YearSpecialByPeriodCount<$PriceSpecialMaxCount)? $PriceSpecialMaxCount-$YearSpecialByPeriodCount+1: 0;
					//dd($YearSpecialByPeriod);
				@endphp
				<tr data-year="{{ $year }}">
					<td align="center" @if($RoomSaleArrayCount>1) rowspan="{{ $RoomSaleArrayCount }}" @endif width="190" class="border-bottom"><span class="year">{{ $year }}</span> 年 @if($k==0&&count($PeriodYear)>2)<div class="icon-cross"><a href="javascript:dontShowLastYear({{ $year }})">刪</a></div> @endif
					<td align="center" width="80"><b>人數</b></td>
					@foreach($YearSpecialByPeriod as $period => $special)
						@php 
							$keyArray = $special->implode('nokey', ',');
						@endphp
					<td align="center" width="200"><b>{{ $period }}</b> <span class="icon-cross"><a href="#" data-keys="{{ $keyArray }}" class="delSpecial">刪</a></span>
					</td>
					@endforeach
					<td align="center" class="fillcol" @if($colspan>0) colspan="{{$colspan}}" @endif></td>
					<td align="center" @if($RoomSaleArrayCount>1) rowspan="{{ $RoomSaleArrayCount }}" @endif width="150" class="border-bottom">
						<a href="javascript:chgMod()">修改</a><a href="#" class="addSpecial">新增</a>
					</td>
				</tr>
				@foreach($RoomSaleArray as $key=>$sale_people)
				<tr class="{{ ($key==count($RoomSaleArray)-1)?'border-bottom':'' }}">
					<td align="center">{{$sale_people}}</td>
					@foreach($YearSpecialByPeriod as $period => $special)
						@php
							$SaleArray = $special->keyBy('people');
							$SpecialID = !empty($SaleArray[$sale_people])? $SaleArray[$sale_people]->nokey: 0;
							$Price = !empty($SaleArray[$sale_people])? $SaleArray[$sale_people]->price: 0;
							$PeriodArray = explode("~",$period);
						@endphp
						<td align="center" data-id="{{ $SpecialID }}">@if($BrowseTag!=1)<input style="width:50%;border: solid 1px;" name="Special[price][]"  class="Special_price" type="text" value="{{ $Price }}">@else{{ $Price }}@endif 
							<input type="hidden" name="Special[year][]" value="{{ $year }}">
							<input type="hidden" name="Special[sale_people][]" value="{{ $sale_people }}">
							<input type="hidden" name="Special[period_start][]" value="{{ $PeriodArray[0] }}">
							<input type="hidden" name="Special[period_end][]" value="{{ isset($PeriodArray[1])?$PeriodArray[1]:$PeriodArray[0] }}">
						</td>
					@endforeach
					<td align="center" class="fillcol" @if($colspan>0) colspan="{{$colspan}}" @endif></td>
				</tr>
				@endforeach
			@endforeach	

		</tbody>
		</table>

		<hr/>
		<div>
			<p style="height: 24px;">1.若連續住宿，第2天以後房價是否優惠？<input type="radio" name="sale_w" value="0" id="sale_n"/><label for="sale_n">不優惠</label><input type="radio" name="sale_w" value="1" id="sale_y" /><label for="sale_y">優惠</label>，第2天以後房價打<input style="width: 28px;height: 24px;">	折(若有優惠，可於補充說明細述)</p>
			<p>2.若房價打0，表示該日或該星期不開放預訂。</p>
			<p>3.起始日期，必須全年度完整設定。</p>
		</div>

		<hr/>
		
		<input type="text" value="{{$MergeLastNo+1}}" name="totalPriceSet" id="totalPriceSet" style="display:none;">
		<input type="text" value="{{count($RoomSaleArray)}}" name="totalSalePeople" id="totalSalePeople" style="display:none;">
		<div class="col-md-4 text-center" style="margin: auto;margin-top: 10px;">
			<button type="button" onclick="javascript:allSubmit()" class="btn btn-primary btn-sm" style="@if($BrowseTag==1)display:none;@endif">確定修改</button>
			<button type="button" onclick="javascript:chgMod(1)" class="btn btn-default btn-sm" style="@if($BrowseTag==1)display:none;@endif">取消修改</button>
		</div>

		<div id="other-setting">
			<div class="line-block">	
				<span class="tt012">Check-in: </span>
				<div class="timearea">平日
				<select>
					@for ($i = 0; $i < 24; $i++)
					    <option> {{ $i }} </option>
					@endfor
				</select>時
				<select>
					@for ($i = 0; $i < 60; $i++)
					    <option> {{ $i }} </option>
					@endfor
				</select>分</div> 
				假日
				<div class="timearea"><input type="checkbox" name="">同平日	
				<select>
					@for ($i = 0; $i < 24; $i++)
					    <option> {{ $i }} </option>
					@endfor
				</select>時
				<select>
					@for ($i = 0; $i < 60; $i++)
					    <option> {{ $i }} </option>
					@endfor
				</select>分</div>

				<span class="tt012">Check-out: </span>
				<div class="timearea">平日
				<select>
					@for ($i = 0; $i < 24; $i++)
					    <option> {{ $i }} </option>
					@endfor
				</select>時
				<select>
					@for ($i = 0; $i < 60; $i++)
					    <option> {{ $i }} </option>
					@endfor
				</select>分</div>
				假日
				<div class="timearea"><input type="checkbox" name="">同平日	
				<select>
					@for ($i = 0; $i < 24; $i++)
					    <option> {{ $i }} </option>
					@endfor
				</select>時
				<select>
					@for ($i = 0; $i < 60; $i++)
					    <option> {{ $i }} </option>
					@endfor
				</select>分	</div>
			</div> 
			<div class="line-block">
				<span class="tt012">餐飲服務: </span>
					<div class="ts022 checkbox checkbox-primary"><input type="checkbox" id="breadfast_1" name=""><label for="breadfast_1">早餐 </label></div> 
					<div class="ts022 checkbox checkbox-primary"><input type="checkbox" id="breadfast_2" name=""><label for="breadfast_2">中西式早餐 </div>
					<div class="ts022 checkbox checkbox-primary"><input type="checkbox" id="breadfast_3" name=""><label for="breadfast_3">午餐 </div>
					<div class="ts022 checkbox checkbox-primary"><input type="checkbox" id="breadfast_4" name=""><label for="breadfast_4">晚餐 </div>
					<div class="ts022 checkbox checkbox-primary"><input type="checkbox" id="breadfast_5" name=""><label for="breadfast_5">午或晚餐 </div>
					<div class="ts022 checkbox checkbox-primary"><input type="checkbox" id="breadfast_6" name=""><label for="breadfast_6">下午茶 </div>
					<div class="ts022 checkbox checkbox-primary"><input type="checkbox" id="breadfast_7" name=""><label for="breadfast_7">消夜 </div>
					<input type="checkbox" name=""><input type="text" name="" placeholder="說明">
			</div>

			<div class="line-block">
				<span class="tt012">攜帶寵物: </span>
					<div class="ts022 text-blue "><input type="radio" name="setting_carry_pat" checked>是 </div>
					<div class="ts022"><input type="radio" name="setting_carry_pat">是，清潔費每隻<input type="text" style="width: 50px;"> </div>
					<div class="ts022"><input type="radio" name="setting_carry_pat">是，提供安置場所 </div>
					<div class="ts022"><input type="radio" name="setting_carry_pat">禁止 </div>
					<input type="checkbox" name=""><input type="text" placeholder="說明" name="">
			</div>
			<div class="line-block">
				<span class="tt012">加人加床: </span>
					<div class="ts022 text-blue"><input type="radio" name="setting_add_bed" checked>不提供 </div>
					<div class="ts022"><input type="radio" name="setting_add_bed">加1人無加床費用 </div>
					<div class="ts022"><input type="radio" name="setting_add_bed">加1床費用<input type="text" style="width: 50px;"> </div>
					<input type="checkbox" name=""><input type="text" placeholder="說明" name="">
			</div>
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
p{
	margin-bottom: 0;
}
.tt012{
	color:#2c982c;
	font-weight: 600;
	margin: 2px;
}
.timearea{
	display:inline-block;
	margin-right:30px;
}
.line-block{
	height: 30px;
}
#other-setting .ts022{
	display:inline-block;
	margin-right:12px;
	padding-top:5px;
}
#other-setting input[type="text"]{
	height:26px;
}
.text-blue{
	color:blue;
}
@endsection

<!-- js獨立區塊腳本 -->
@section('custom_script')

//
function chgDate(no, obj, typeName){
	$('.'+typeName+no).val($(obj).val());
}

//導向客房詳細
function redirectDetail(){
	window.location.href='room_set/'+$("#room_list :selected").val();
}
//切換編輯模式
function chgMod(b, add_row_flag){
	b = (!!b)?1:0;
	if(!!add_row_flag){
		sessionStorage.setItem('add_row_flag',add_row_flag);
	}
	window.location.href='price_normal?r={{$RoomID}}&b='+b;
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

//刪除特殊房價
function delSpecial(keys,dom){
	if(confirm('確定刪除此連續(特殊)假期之房價嗎？')){
		$(dom).unbind();
		$.ajax({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        type: "POST",
	        url: 'price_special_del',
	        data: {keys:keys},
	        success: function(data) {
	          window.location.reload();
	      	}
	    });
	}
}

function dontShowLastYear(year){
	if(confirm('確定刪除'+year+'年度所有連續(特殊)假期之房價嗎？')){
		$.ajax({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        type: "POST",
	        url: 'dont_show_last_year',
	        data: {room_id:$('#room_list').val()},
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

	if("{{$BrowseTag}}"=="1"){
		chgMod(0, 'normal');return;
	}

	trNo1++;
	tr_clone =$(".cloneTr").clone().removeClass("cloneTr").removeClass("a1").addClass("a"+(trNo1+1));
	//房價空白
	/*tr_clone.children().find('.weekda').val("");
	tr_clone.children().find('.friday').val("");
	tr_clone.children().find('.saturday').val("");
	tr_clone.children().find('.sunday').val("");*/
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
	var monDay =[31,29,31,30,31,30,31,31,30,31,30,31];
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

function validPeriodFormat(period){
	//判斷是否為0101~1231,否則預設0101
	var defult = "0101";
	var mon = parseInt(period.substr(0,2));
	var day = parseInt(period.substr(2,2));
	
	var monDay =[31,29,31,30,31,30,31,31,30,31,30,31];
	if(mon<=12&&mon>0){
		var max = monDay[mon-1];
		if(day<=max){
			return period;
		}
	}
	return defult;
}

function validAllPeriod(){
	var pass = false;

	//判斷所有欄位不能空白
	//$("#")

	//判斷每個區間必須 前<後
	

	//判斷同列不能有重複區間

	pass = true;
	return pass;
}

function allSubmit(){
	var pass = validAllPeriod();
	if(pass){
		$("#price_normal_form").submit();
	}
}

@endsection

<!-- jQuery ready 狀態內閉包內插 -->
@section('custom_ready_script')
//alert(Date.parse('2018-03-31')>Date.parse('2018-04-1'));
$(".delTime").eq(0).hide();

@if($MergeLastNo ==0 && isset($PriceNormal[0]) && $PriceNormal[0]->weekday =='')
	//alert('{{$MergeLastNo}}');
	$('.cloneTr').hide();
@endif

var new_key=0;
$("a.addSpecial").click(function(){
	
	new_key++;
	$('tr.current').removeClass('current');
	var tr = $(this).parentsUntil('tr').parent().addClass('current');
	var cur_year = tr.data("year");

	if("{{$BrowseTag}}"=="1"){
		chgMod(0,cur_year);return;
	}

	var rowspan = $(this).parent().attr('rowspan');
	var first_td = $("<td align='center'>").width(200).html('<span"><input class="new_period_start" data-key="'+new_key+'" style="width: 80px;" /> ~ <input class="new_period_end" data-key="'+new_key+'" style="width: 80px"/></span>');
	var this_fillcol = tr.find('td.fillcol').before(first_td);
	var cutr=tr;

	for(var x=0; x<rowspan-1; x++){
		cutr = cutr.next().addClass('current');
		var cur_people = cutr.find('td:first').text();
		var dom = $("<td align='center'>").addClass('new_key_'+new_key).width(200).html('<input name="Special[price][]" style="width: 120px;" /><input type="hidden" name="Special[year][]" value="'+cur_year+'"><input type="hidden" name="Special[sale_people][]" value="'+cur_people+'"> <input type="hidden" name="Special[period_start][]" class="period_start"> <input type="hidden" name="Special[period_end][]" class="period_end">'); 
		cutr.find('td.fillcol').before(dom);
	}
	$('#price_table_special tr').not('.current').find('td.fillcol').each(function(index){
		var int_colspan = parseInt($(this).attr('colspan'));
		var cur_colspan = isNaN(int_colspan)?1:int_colspan;
		$(this).attr('colspan', cur_colspan+1);
	});
});

$('a.delSpecial').click(function(){
	var keys = $(this).data("keys").toString();
	keys = keys.split(",");
	delSpecial(keys, $(this));
});

//自動新增區間
var add_row_flag = sessionStorage.getItem('add_row_flag');
if(!!add_row_flag){
	@if($MergeLastNo >=0 && isset($PriceNormal[0]) && $PriceNormal[0]->weekday !='' && $BrowseTag!=1)
		if(add_row_flag=='normal'){
			clonePrice();
		}
	@endif
	if(!isNaN(add_row_flag)){
		$("tr[data-year="+add_row_flag+"]").find("a.addSpecial").trigger("click");	
	}
	sessionStorage.removeItem('add_row_flag');
}

$("body").on("change","input.new_period_start",function(){
	var key = $(this).data("key");
	$(this).val(validPeriodFormat($(this).val()));
	$('td.new_key_'+key).find('input.period_start').val($(this).val());
});
$("body").on("change","input.new_period_end",function(){
	var key = $(this).data("key");
	$(this).val(validPeriodFormat($(this).val()));
	$('td.new_key_'+key).find('input.period_end').val($(this).val());
});
$("#other-setting .ts022 input:radio").on('change',function(){
	var pp = $(this).parent();
	var ppp = pp.parent();

	$('.ts022',ppp).removeClass('text-blue');
	pp.addClass('text-blue');
});
$("#other-setting .ts022 input:checkbox").on('change',function(){
	var pp = $(this).parent();

	if(this.checked){
		pp.addClass('text-blue');
	}else{
		pp.removeClass('text-blue');
	}
});
@endsection