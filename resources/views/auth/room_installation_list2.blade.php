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
	        已刪除此服務
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
	        <h5 class="modal-title" id="exampleModalLabel">修改名稱</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      	請輸入新名稱：
	      	<input id="service_nokey" name="service_nokey" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="" placeholder="請輸入服務名稱" style="display:none;">
	        <input id="new_service_name" name="new_service_name" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="" placeholder="在此輸入新名稱" required="required">
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="edit_service()">確定修改</button>
	      </div>
	    </div>
	  </div>
	</div>
<!-- ** -->
<div class="row" style="height: 40px;">
	<div style="margin:5px;">
	</div>
	
	<div style="margin-right:5px;">
		<select class="form-control" id="group_sel" name="group_sel" onchange="chg_group(this)">
		  <option value='-1'@if($Group_Query=='-1') selected=""  @endif>所有服務設施與群組</option>
		  <option value='-2'@if($Group_Query=='-2') selected=""  @endif>所有群組</option>
		  @foreach($Room_Installation_Groups as $key => $group)
			<option value='{{$group->nokey}}'@if($Group_Query==$group->nokey) selected=""  @endif>{{$group->service_name}}（{{$group->child_count}}）</option>
		  @endforeach
		</select>
	</div>
	<a href="javascript:toggle_service_interface()" class="btn btn btn-primary" style="">新增設施與服務或群組</a>
</div>
<!-- 新增設施服務介面 -->
<div class="row" style="clear: both;display: none;margin: auto;width: 60%;" id="service_interface">
	<div style="float:right;margin:5px;">
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
		<input id="add_service_text" name="add_service_text" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="" placeholder="請輸入名稱" required="required">
	</div>
	<div style="float:right;margin:5px;">
		<a href="javascript:add_service()" class="btn btn-primary">確定新增</a>
		<a href="javascript:toggle_service_interface()" class="btn btn-primary">取消</a>
	</div>
</div>
<!-- 清單內容 -->
<table class="table table-hover" style="margin-top:10px;">
  <thead class="thead-light">
    <tr>
      <th scope="col">設施服務名稱</th>
      <th scope="col">所屬群組</th>
      <th scope="col"></th>
    </tr>
  </thead>
  
  <tbody class="list_tr">
	@foreach($Room_Installation_Items as $key => $item)
		<tr>
			<td>{{$item->service_name}}</td>
			<td>
				@if(!$item->is_group)
					{{$item->sl_name}}
				@else
					<span style="color: #dba502">設施群組名稱</span>
				@endif

			</td>
			<td>
				<a href="#" onclick="open_edit_interface('{{$item->service_name}}',{{$item->nokey}})" class="btn btn-primary">修改</a>
				<a href="#" onclick="del_service({{$item->nokey}},{{$item->is_group}})" class="btn btn-primary">刪除</a>
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
	        url: 'service_del',
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
	if($('#new_service_name').val() ==''){
		alert('請填寫名稱');
	}else{
		$.ajax({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        type: "POST",
	        url: 'service_edit',
	        data: {name:$('#new_service_name').val(),nokey:$('#service_nokey').val()},
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
function open_edit_interface(service_name, key){
	$('#new_service_name').val(service_name);
	$('#service_nokey').val(key);
	$('#editWindow').modal("toggle");
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
	        url: 'service_add',
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