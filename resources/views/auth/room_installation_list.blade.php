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
	        已刪除此客房設施
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">OK！</button>
	      </div>
	    </div>
	  </div>
	</div>
@endif
<!-- *修改視窗* -->
<div class="modal fade" id="editWindow" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">修改設施名稱</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      	請輸入新名稱：
	      	<input id="service_nokey" name="service_nokey" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="" placeholder="請輸入服務名稱" style="display:none;">
	        <input id="new_service_name" name="new_service_name" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="" placeholder="請輸入新名稱" required="required">
	        是否提供上傳照片：
	        <input type="radio" id="upload0" value="1" name="upload">是
	        <input type="radio" id="upload1" value="0" name="upload">否
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="edit_service()">確定修改</button>
	      </div>
	    </div>
	  </div>
	</div>
<!-- ** -->
<div class="row" style="height: 40px;">
	<div style="margin-right: 15px;"></div>
	<a href="javascript:window.location.href='room_installation'" class="btn btn btn-danger" style="margin-right: 5px;">客房設施管理</a>
	<a href="javascript:window.location.href='room_name'" class="btn btn btn-primary" style="margin-right: 5px;">房型名稱管理</a>
	<a href="javascript:window.location.href='bed_name'" class="btn btn btn-primary" style="margin-right: 5px;">床型名稱管理</a>
</div>
<!-- 新增設施服務介面 -->
<div class="row" style="clear: both;width: 60%;margin-left:1px;" id="service_interface">
	<div style="margin-right:5px;padding-top: 5px;">
		<select class="form-control" id="group_sel" name="group_sel" onchange="chg_group(this)">
		  <option value='-1'@if($Group_Query=='-1') selected=""  @endif>所有客房設施與群組</option>
		  <option value='-2'@if($Group_Query=='-2') selected=""  @endif>所有客房設施群組</option>
		  @foreach($Room_Installation_Groups as $key => $group)
			<option value='{{$group->nokey}}'@if($Group_Query==$group->nokey) selected=""  @endif>{{$group->service_name}}（{{$group->child_count}}）</option>
		  @endforeach
		</select>
	</div>
	<div style="float:right;margin:5px;">
		<select class="form-control" id="add_group_sel" name="add_group_sel"@if($Group_Query=='-2') disabled=""  @endif>
		  <option value='-1'@if($Group_Query=='-2') selected=""  @endif>新增為群組</option>
		  @foreach($Room_Installation_Groups as $key => $group)
			<option value='{{$group->nokey}}'@if($Group_Query==$group->nokey) selected=""  @endif>{{$group->service_name}}（{{$group->child_count}}）</option>
		  @endforeach
		</select>
	</div>
	<div style="float:right;margin:5px;">
		<input id="add_service_text" name="add_service_text" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="" placeholder="" required="required" style="width: 245px;">
	</div>
	<div style="float:right;margin:5px;">
		<a href="javascript:add_service()" class="btn btn-primary">確定新增</a>
		<a href="javascript:toggle_service_interface()" class="btn btn-primary">關閉</a>
	</div>
</div>
<!-- 清單內容 -->
<table class="table table-hover" style="margin-top:10px;">
  <thead class="thead-light">
    <tr>
      <th scope="col">設施客房設施名稱</th>
      <th scope="col">上傳開放</th>
      <th scope="col">所屬群組</th>
      <th scope="col"></th>
    </tr>
  </thead>
  
  <tbody class="list_tr">
	@foreach($Room_Installation_Items as $key => $item)
		<tr>
			<td>{{$item->service_name}}</td>
			<td>
				@if($item->upload =='1')
					是
				@endif
			</td>
			<td>
				@if(!$item->is_group)
					{{$item->sl_name}}
				@else
					<span style="color: #dba502">設施群組名稱</span>
				@endif

			</td>
			<td>
				<a href="#" onclick="open_edit_interface('{{$item->service_name}}',{{$item->nokey}},{{$item->upload}})">修改</a>
				<a href="#" onclick="del_service({{$item->nokey}},{{$item->is_group}})">刪除</a>
			</td>
		</tr>
	@endforeach
  </tbody>

</table>
<div id="nav_pagerow" class="row">
{{ $Room_Installation_Items->links('vendor.pagination.bootstrap-4') }}
</div>

@endsection
<!-- js獨立區塊腳本 -->
@section('custom_script')
//執行刪除
function del_service(key,is_group){
	confirm_text =(is_group)?"確定要刪除此群組及所屬設施？":"確定要刪除此設施？";
	if(confirm(confirm_text)){
		//do ajax
		//console.log(confirm_text+'='+is_group);
		$.ajax({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        type: "POST",
	        url: 'room_installation_del',
	        data: {group:is_group,nokey:key},
	        success: function(data) {
	        	if(data=='no'){
		        	alert('權限不足或系統異常');
		        	window.location.href='main';
		        }else{
			        window.location.reload();
			    }
	        	
	    	}
	    });
	}
}
//執行修改
function edit_service(){
//	alert($('#new_service_name').val());
//	alert($('#service_nokey').val());
	upload_state =0;
	if($('#upload0').prop('checked')){
		upload_state =1;
	}
	if($('#new_service_name').val() ==''){
		alert('請填寫名稱');
	}else{
		$.ajax({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        type: "POST",
	        url: 'room_installation_edit',
	        data: {name:$('#new_service_name').val(),nokey:$('#service_nokey').val(),upload:upload_state},
	        success: function(data) {
	        	if(data=='no'){
		        	alert('權限不足或系統異常');
		        	window.location.href='main';
		        }else{
			        window.location.reload();
			    }
	        	
	    	}
	    });
	}
}
//打開修改視窗
function open_edit_interface(service_name, key, upload){
	$('#new_service_name').val(service_name);
	$('#service_nokey').val(key);
	$('#editWindow').modal("toggle");
	if(upload=='1'){
		$('#upload0').prop('checked',true);
	}else{
		$('#upload1').prop('checked',true);
	}
}
//切換群組查看
function chg_group(obj){
	window.location.href='?group='+$(obj).val();
}
//新增設施服務或群組
function add_service(){
	if($('#add_service_text').val() ==''){
		alert('請填寫名稱');
	}else{
		$.ajax({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        type: "POST",
	        url: 'room_installation_add',
	        data: {name:$('#add_service_text').val(),parent:$('#add_group_sel :selected').val()},
	        success: function(data) {
	        	if(data=='no'){
		        	alert('權限不足或系統異常');
		        	window.location.href='/tw/auth/manager/main';
		        }else{
			        window.location.reload();
			    }
	        	
	    	}
	    });
	}
}
//切換設施服務輸入介面
function toggle_service_interface(){
	$("#service_interface").slideToggle();
}
//
$(window).resize(function(){
	$("body").css("margin-top",$("nav").height()+20);
});
@endsection
<!-- jQuery ready 狀態內閉包內插 -->
@section('custom_ready_script')
	$("body").css("margin-top",$("nav").height()+20);
	//停用完成跳出確認
	@if(!is_null(session()->get('controll_back_msg')))
		$('#okAlert').modal("toggle");
	@endif
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
@endsection