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
	        已刪除此區
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">OK！</button>
	      </div>
	    </div>
	  </div>
	</div>
@endif
<!-- 下拉式選單組合 -->
<div class="row search_row">
	<div class="col-md-1 search-padding">
		<select class="form-control" id="state" name="state">
		  <option value='-1'@if($QueryArray['state']=='-1') selected="" @endif>狀態</option>
		  <option value='0'@if($QueryArray['state']=='0') selected="" @endif>上線</option>
		  <option value='1'@if($QueryArray['state']=='1') selected="" @endif>下線</option>
		  <option value='2'@if($QueryArray['state']=='2') selected="" @endif>關閉</option>
		</select>
	</div>
	<div class="col-md-1 search-padding">
		<select class="form-control" id="ver" name="ver">
		  <option value='-1'@if($QueryArray['ver']=='-1') selected="" @endif>版本</option>
		  <option value='A'@if($QueryArray['ver']=='A') selected="" @endif>A</option>
		  <option value='B'@if($QueryArray['ver']=='B') selected="" @endif>B</option>
		  <option value='C'@if($QueryArray['ver']=='C') selected="" @endif>C</option>
		  <option value='D'@if($QueryArray['ver']=='D') selected="" @endif>D</option>
		  <option value='G'@if($QueryArray['ver']=='G') selected="" @endif>G</option>
		  <option value='A,CA'@if($QueryArray['ver']=='A,CA') selected="" @endif>A,CA</option>
		  <option value='B,C'@if($QueryArray['ver']=='B,C') selected="" @endif>B,C</option>
		  <option value='BG,G'@if($QueryArray['ver']=='BG,G') selected="" @endif>BG,G</option>
		  <option value='D,C'@if($QueryArray['ver']=='D,C') selected="" @endif>D,C</option>
		  <option value='DG,G'@if($QueryArray['ver']=='DG,G') selected="" @endif>DG,G</option>
		  <option value='DA,CA'@if($QueryArray['ver']=='DA,CA') selected="" @endif>DA,CA</option>
		  <option value='A,CA,DA'@if($QueryArray['ver']=='A,CA,DA') selected="" @endif>A,CA,DA</option>
		  <option value='B,C,D'@if($QueryArray['ver']=='B,C,D') selected="" @endif>B,C,D</option>
		  <option value='BG,G,DG'@if($QueryArray['ver']=='BG,G,DG') selected="" @endif>BG,G,DG</option>
		</select>
	</div>
	<div class="col-md-1 search-padding">
		<select class="form-control" id="legal" name="legal">
		  <option value='-1'@if($QueryArray['legal']=='-1') selected="" @endif>是否合法</option>
		  <option value='1'@if($QueryArray['legal']=='1') selected="" @endif>合法</option>
		  <option value='2'@if($QueryArray['legal']=='2') selected="" @endif>非法</option>
		</select>
	</div>
	<div class="col-md-1 search-padding">
		<select class="form-control" id="area2" name="area2" onchange="chg_area(this,2)">
		  <option value='-1'>地區/縣市</option>
		  @foreach($Areas_level2 as $key=>$city)
		  <option value='{{$city->nokey}}'@if($QueryArray['area2']==$city->nokey) selected="" @endif>{{$city->area_name}}</option>
		  @endforeach
		</select>
	</div>
	<div class="col-md-1 search-padding">
		<select class="form-control" id="area3" name="area3">
		  <option value='-1'>鄉鎮/區</option>
		</select>
	</div>
	<div class="col-md-1 search-padding">
		<select class="form-control" id="ctrl" name="ctrl">
		  <option value='-1'@if($QueryArray['ctrl']=='-1') selected="" @endif>控管</option>
		  <option value='0'@if($QueryArray['ctrl']=='0') selected="" @endif>立即訂房</option>
		  <option value='1'@if($QueryArray['ctrl']=='1') selected="" @endif>客服訂房</option>
		</select>
	</div>
	<div class="col-md-1 search-padding">
		<select class="form-control" id="c_type" name="c_type">
		  <option value='-1'@if($QueryArray['c_type']=='1') selected="" @endif>合作種類</option>
		  <option value='合約'@if($QueryArray['c_type']=='合約') selected="" @endif>合約</option>
		  <option value='住宿卷'@if($QueryArray['c_type']=='住宿卷') selected="" @endif>住宿卷</option>
		  <option value='約卷'@if($QueryArray['c_type']=='約卷') selected="" @endif>約卷</option>
		</select>
	</div>
	<div class="col-md-1 search-padding">
		<select class="form-control" id="room_count" name="room_count">
		  <option value='-1'@if($QueryArray['room_count']=='-1') selected="" @endif>房間數量</option>
		  <option value='100'@if($QueryArray['room_count']=='100') selected="" @endif>100以上</option>
		  <option value='50-99'@if($QueryArray['room_count']=='50-99') selected="" @endif>50-99</option>
		  <option value='15-49'@if($QueryArray['room_count']=='15-49') selected="" @endif>15-49</option>
		  <option value='1-14'@if($QueryArray['room_count']=='1-14') selected="" @endif>1-14</option>
		</select>
	</div>
	<div class="col-md-1 search-padding">
		<select class="form-control" id="holiday" name="holiday">
		  <option value='-1'@if($QueryArray['holiday']=='-1') selected="" @endif>連假房價</option>
		  <option value='0'@if($QueryArray['holiday']=='0') selected="" @endif>未設</option>
		  <option value='1'@if($QueryArray['holiday']=='1') selected="" @endif>比照週六</option>
		  <option value='2'@if($QueryArray['holiday']=='2') selected="" @endif>高於周六</option>
		</select>
	</div>
	<div class="col-md-1 search-padding" style="min-width: 194px;">
		<input type="text" class="form-control" id="search" name="search" placeholder="關鍵字搜尋" value="{{$QueryArray['search']}}">
	</div>
	<div class="col-md-1 search-padding" style="min-width: 135px;">
		<a href="javascript:search()" class="btn btn-primary">搜尋</a>
		<a class="btn btn-primary" href="hotel_add">新增</a>
	</div>
	
</div>
<!-- 清單內容 -->
<div class="row">
	<table class="table table-hover" style="margin-top:10px;">
	  <thead class="thead-light">
	    <tr>
	      <th scope="col">編號</th>
	      <th scope="col">飯店名稱</th>
	      <th scope="col">狀態</th>
	      <th scope="col">發票</th>
	      <th scope="col">版本</th>
	      <th scope="col">比價表</th>
	      <th scope="col">訂金</th>
	      <th scope="col">服務費</th>
	      <th scope="col">紅利</th>
	      <th scope="col">開房年月</th>
	      <th scope="col">房間數</th>
	      <th scope="col">合作種類</th>
	      <th scope="col">控管</th>
	      <th scope="col">權限</th>
	      <th scope="col">操作</th>
	    </tr>
	  </thead>
	  <tbody class="list_tr">
	  	@foreach($Hotels as $key => $hotel)
			<tr>
		      <th style="cursor: pointer;" onclick="window.location.href='hotel_browse/{{ $hotel->nokey }}'" scope="row">{{ $hotel->nokey }}</th>
		      <td style="cursor: pointer;" onclick="window.location.href='hotel_browse/{{ $hotel->nokey }}'">
		      	@if($hotel->state==2)
					<a href="hotel_browse/{{ $hotel->nokey }}" style="color:#aeaeae">{{ $hotel->name }}</a>
		      	@elseif($hotel->state==1)
					<a href="hotel_browse/{{ $hotel->nokey }}" style="color:#000">{{ $hotel->name }}</a>
				@else
					<a href="hotel_browse/{{ $hotel->nokey }}" style="color:blue">{{ $hotel->name }}</a>
		      	@endif
		      </td>
		      <td>
		      	@if($hotel->state==0)
					上線
		      	@elseif($hotel->state==1)
					下線
				@else
					關閉
		      	@endif
		      </td>
		      <td>
		      	@if($hotel->invoice_type==0)
					甲
		      	@elseif($hotel->invoice_type==1)
					乙
				@else
					丙
		      	@endif
		      </td>
		      <td>{{ $hotel->version }}</td>
		      <td>--</td>
		      <td>{{$hotel->deposit}}%</td>
		      <td>
					{{$hotel->fees_c}}%
		      </td>
		      <td>
					{{$hotel->fees_c_bonus}}%
		      </td>
		      <td>--</td>
		      <td>{{$hotel->type_room}}</td>
		      <td>{{$hotel->cooperation}}</td>
		      <td>
		      	@if($hotel->control==0)
					<span style="color: #dba502">立即訂房</span>
				@else
					客服訂房
		      	@endif
		      </td>
		      <td><a href="hotel_auth_list/{{ $hotel->nokey }}">權限</a></td>
		      <td>
		      	<a href="hotel_edit/{{ $hotel->nokey }}">修改</a>
		      </td>
	    </tr>
	    @endforeach
	  </tbody>
	</table>
</div>

<div id="nav_pagerow" class="row">
{{ $Hotels->links('vendor.pagination.bootstrap-4') }}
</div>

@endsection
<!-- style內置區塊 -->
@section('instyle')
	/** 分頁樣式 */
	#nav_pagerow{
		float: right;
		left: -35%;
		position: relative;
	}
	#nav_pagerow > ul{
		float:left;
		left: 50%;
		position: relative;
	}
	.search-padding{
		padding-left: 5px;
		padding-right: 5px;
	}
	.search-padding select{
		
	}
@endsection
<!-- js獨立區塊腳本 -->
@section('custom_script')
//修改URI參數
function updateQueryStringParameter(uri, key, value) {
  var re = new RegExp("([?&])" + key + "=.*?(&|$)", "i");
  var separator = uri.indexOf('?') !== -1 ? "&" : "?";
  if (uri.match(re)) {
    return uri.replace(re, '$1' + key + "=" + value + '$2');
  }
  else {
    return uri + separator + key + "=" + value;
  }
}
// 搜尋組合字串
	function search(){
		qString='';
		qString +='?state='+$('#state :selected').val();			//狀態
		qString +='&ver='+$('#ver :selected').val();				//版本
		qString +='&country='+$('#country :selected').val();		//國家
		qString +='&legal='+$('#legal :selected').val();			//合法性
		qString +='&area2='+$('#area2 :selected').val();			//縣市
		qString +='&area3='+$('#area3 :selected').val();			//鄉鎮區域
		qString +='&ctrl='+$('#ctrl :selected').val();				//控管
		qString +='&c_type='+$('#c_type :selected').val();			//合作種類
		qString +='&room_count='+$('#room_count :selected').val();	//房間數量
		qString +='&holiday='+$('#holiday :selected').val();		//連假房價
		qString +='&search='+$('#search').val();					//飯店名稱
		window.location.href=qString;
	}
// 切換選項時，level為該選項之級別值
	function chg_area(sel_obj, level){
		$("#area"+(level+1)).prop('disabled', true);
		$("#area"+(level+1)+" option").remove();
		sel_val =$(sel_obj).val();

		if(sel_val == '-1'){
			sel_val =$("#area"+(level-1)).val();
			$("#area"+(level+1)).append($('<option>', {
				    value: -1,
				    text: '鄉鎮/區域'
				}));
			$("#area"+(level+1)).prop('disabled', false);
		}
		$.ajax({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        type: "POST",
	        url: 'area_get',
	        data: {level:sel_val},
	        success: function(data) {
	        	//填入下一級選項
	        	fill_area(data,level);
	    	}
	    });
	}
	
	//填入下級選項
	function fill_area(data, level){
		if(level <=4){
			$("#area"+(level+1)+" option[value!='-1']").remove();
			$("#area"+(level+1)).append($('<option>', {
				    value: -1,
				    text: '區域'
				}));
			if($("#area"+level).val() !='-1'){
				for(i=0; i< data.length; i++){
					$("#area"+(level+1)).append($('<option>', {
					    value: data[i]['nokey'],
					    text: data[i]['area_name']
					}));
				}
			}
			$("#area"+(level+1)).prop('disabled', false);
			//如果區域已選，則自動選取區域
			if('{{$QueryArray['area3']}}' !=-1 && '{{$QueryArray['area3']}}' !=''){
				$("#area"+(level+1)).val({{$QueryArray['area3']}}).change();
			}
		}
	}
//快捷關閉上線
	function disableHotel(key){
		<!-- $('#'+target).prop('disabled', true); -->
		if(confirm('確定要關閉？')){
			$.ajax({
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        },
		        type: "POST",
		        url: 'hotel_disable/'+key,
		        data: {nokey:key},
		        success: function(data) {
		        	window.location.reload();
		        	<!-- $('#'+target).val(""); -->
		        	<!-- $('#'+target).val(data[0]['zip_code']); -->
		        	<!-- $('#'+target).prop('disabled', false); -->
		    	}
		    });
		}
	}
	$(window).resize(function(){
		$("body").css("margin-top",$("nav").height()+20);
	});
@endsection
<!-- jQuery ready 狀態內閉包內插 -->
@section('custom_ready_script')
	$("body").css("margin-top",$("nav").height()+20);
	//大幅跳頁字串
	pags_uri=updateQueryStringParameter(window.location.search, 'page', '30');
	//縣市不等於預設，則觸發
	if($('#area2').val() !=-1){
		$('#area2').val({{$QueryArray['area2']}}).change();
	}
	//停用完成跳出確認
	@if(!is_null(session()->get('controll_back_msg')))
		$('#okAlert').modal("toggle");
	@endif
@endsection