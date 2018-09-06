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

<div class="row">
	<div class="col-md-2">
		<select class="form-control" id="area_level1" name="area_level1">
			@foreach($Countries as $key => $country)
				<option value='{{$country->nokey}}'>{{$country->area_name}}</option>
			@endforeach
		</select>
	</div>
	<div class="col-md-2">
		<select class="form-control" onchange="chg_area(this,2)" id="area_level2" name="area_level2">
		    <option value='-1'>-</option>
		  @foreach($Areas_level2 as $key => $area2)
				<option value='{{$area2->nokey}}'>{{$area2->area_name}}</option>
			@endforeach
		</select>
	</div>
	<div class="col-md-2">
		<select class="form-control" onchange="chg_area(this,3)" id="area_level3" name="area_level3">
		  <option value='-1'>-</option>
		</select>
	</div>
	<div class="col-md-2">
		<select class="form-control" onchange="chg_area(this,4)" id="area_level4" name="area_level4">
		  <option value='-1'>-</option>
		</select>
	</div>
	<div class="col-md-4">
		<div style="text-align:right;" >
			@if(in_array('40',$Auths))
			<a href="javascript:openAddArea()" class="btn btn-secondary">新增地區</a>
			@endif
			<a href="/{{@Country}}/auth/manager/area_list" class="btn btn-secondary">地區清單</a>
		</div>
	</div>
</div>
<!-- 隱藏新增地區欄 -->
<div id="addAreaPanel" name="addAreaPanel" class="row" style="margin:20px;display: none;">
	<div class="col-md-1 text-center">
		<span class="align-middle">地區名稱</span>
	</div>
	<div class="col-md-5">
		<input type="text" class="form-control" id="area_name" name="area_name" placeholder="請輸入地區名稱" value="">
	</div>
	<div class="col-md-2">
		<span class="btn btn-secondary" onclick="addArea()">新增</span>
	</div>
</div>
<!-- 隱藏讀取圖 -->
<div id="loading" name="loading" class="row text-center" style="display:none">
	<img src="/pic/loading.gif" class="text-right center">
</div>
<!-- 清單內容 -->
<table class="table table-hover" style="margin-top:10px;">
  <thead class="thead-light">
    <tr>
      <th scope="col">地區名稱</th>
      <th scope="col">郵遞區號</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody class="list_tr">

  </tbody>
</table>

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
//現存級別
var level_global=1;
	// 刪除地區
	function delArea(nokey){
		if(confirm('確定要刪除')){
			//開啟讀取模式
			$("#loading").slideDown();
			//
			$.ajax({
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        },
		        type: "POST",
		        url: 'area_del',
		        data: {req_nokey:nokey},
		        success: function(data) {
		        	$(".edit_field"+nokey).val("");
		        	refresh_area(level_global);
		    	},
		    	error: function(xhr, ajaxOptions, thrownError) {
					alert(xhr.responseText);
					$("#loading").slideUp();
				}
		    });
		}
		//alert(level_global+','+nokey+','+$(".edit_field"+nokey).val());
	}
	// 編輯地區
	function editArea(nokey){
		//開啟讀取模式
		$("#loading").slideDown();
		//
		$.ajax({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        type: "POST",
	        url: 'area_edit',
	        data: {req_nokey:nokey,req_name:$(".edit_field"+nokey).val(),zip_code:$(".zip_code"+nokey).val()},
	        success: function(data) {
	        	$(".edit_field"+nokey).val("");
	        	$("#loading").slideUp();
	        	refresh_area(level_global);
	    	},
	    	error: function(xhr, ajaxOptions, thrownError) {
				alert(xhr.responseText);
				$("#loading").slideUp();
			}
	    });
		//alert(level_global+','+nokey+','+$(".edit_field"+nokey).val());
	}
	//項目風琴開合效果
	function editAreaToggle(nokey){
		$('.edit_area').slideUp();
		$('.edit_area_row'+nokey).slideDown();
	}
	// 新增地區打開選項
	function openAddArea(){
		$("#addAreaPanel").slideToggle();
	}
	// 新增地區
	function addArea(){
		level1 =$("#area_level1").val();
		level2 =$("#area_level2").val();
		level3 =$("#area_level3").val();
		level4 =$("#area_level4").val();
		area_name =$("#area_name").val();

		//欲新增層級判斷 and 判斷父層
		level =1;
		if(level1 <0){
			level =1;
		}else if(level2 <0){
			level =2;
		}else if(level3 <0){
			level =3
		}else{
			level =4;
		}
		$.ajax({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        type: "POST",
	        url: 'area_add',
	        data: {level_no:level,parent_no:$("#area_level"+(level-1)).val(),area_string:area_name},
	        success: function(data) {
	        	refresh_area(level);
	        	$("#area_name").val("");
	    	},
	    	error: function(xhr, ajaxOptions, thrownError) {
				alert(xhr.responseText);
			}
	    });
	}
	//更新地區下拉式選單
	function refresh_area(level){
		$("#loading").slideDown();
		parent_val =$("#area_level"+(level-1)).val();
		$.ajax({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        type: "POST",
	        url: 'area_get',
	        data: {level:parent_val},
	        success: function(data) {
	        	//填入下一級選項，參數2為上一層級別
	        	fill_area(data,(level-1));
	        	//填入清單
	        	fill_list(data);
	        	//更新級別
	        	refresh_level();
	        	$("#loading").slideUp();
	    	}
	    });
	}
	// 切換選項時，level為該選項之級別值
	function chg_area(sel_obj, level){
		//清除新增地區填寫內容在隱藏
		$("#area_name").val("");
		$("#addAreaPanel").hide();
		//開啟讀取模式
		$("#loading").slideDown();
		sel_val =$(sel_obj).val();

		if(sel_val == '-1'){
			sel_val =$("#area_level"+(level-1)).val()
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
		        //填入清單
	        	fill_list(data);
	        	//更新級別
	        	refresh_level();
	    	}
	    });
	}
	//更新填入清單
	function fill_list(data){
		$(".list_tr").empty();
		for(i=0; i< data.length; i++){
			$("<tr><th scope=\"row\"><div class=\"row area_text_span"+ data[i]['nokey'] +"\" style=\"cursor: pointer;height: 38px;padding: 10px;\" onclick=\"editAreaToggle("+ data[i]['nokey'] +")\">"+ data[i]['area_name'] +"</div><div class=\"row edit_area edit_area_row"+ data[i]['nokey'] +"\" style=\"display:none\"><div class=\"col-md-10\"><input type=\"text\" class=\"form-control edit_field"+ data[i]['nokey'] +"\" data-nokey=\""+ data[i]['nokey'] +"\" value=\""+ data[i]['area_name'] +"\">郵遞區號<input type=\"text\" class=\"form-control zip_code"+ data[i]['nokey'] +"\" data-nokey=\""+ data[i]['nokey'] +"\" value=\""+ data[i]['zip_code'] +"\"></div><div class=\"col-md-2\"><a href=\"javascript:editArea("+ data[i]['nokey'] +");\" class=\"\">更名</a></div></div></th><td>"+ data[i]['zip_code'] +"</td><td><a href=\"javascript:delArea("+ data[i]['nokey'] +")\" class=\"\">刪除</a></td></tr>").appendTo(".list_tr");
		}
	}
	//更新級別
	function refresh_level(){
		for(i=1; i<=4; i++){
			if($("#area_level"+i).val() !='-1'){
				//要修改的地區級別，通常為當局級別的下層
				level_global =(i+1);
			}
		}
	}
	//填入下級選項
	function fill_area(data, level){
		level +=1;
		if(level <=4){
			$("#area_level"+level+" option[value!='-1']").remove();
			for(i=0; i< data.length; i++){
				$("#area_level"+level).append($('<option>', {
				    value: data[i]['nokey'],
				    text: data[i]['area_name']
				}));

			}
			//alert(data['1']['area_name']);
			//$("#area_level"+level+" option[value!='-1']").remove();
		}
		$("#loading").slideUp();
	}
$(window).resize(function(){
	$("body").css("margin-top",$("nav").height()+20);
});
@endsection
<!-- jQuery ready 狀態內閉包內插 -->
@section('custom_ready_script')
	$("body").css("margin-top",$("nav").height()+20);
	//觸發縣市選單
	$('#area_level2').val(-1).change();
	//停用完成跳出確認
	@if(!is_null(session()->get('controll_back_msg')))
		$('#okAlert').modal("toggle");
	@endif
@endsection