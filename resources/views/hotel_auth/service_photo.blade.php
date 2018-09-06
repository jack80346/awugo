<!DOCTYPE html>
<head>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<META HTTP-EQUIV="EXPIRES" CONTENT="0">
<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
<META HTTP-EQUIV="EXPIRES" CONTENT="Mon, 22 Jul 2002 11:12:01 GMT">
<title>設施服務照片上傳</title>
<link href="/css/dropzone.css" type="text/css" rel="stylesheet" />
<style type="text/css">
html,body{
	 width:900px;
	 max-width: 900px;
	 max-height: 700px;
	 height: 600px;
	 overflow: hidden;
}
</style>
</head>
<body>
	<div style="max-width: 850px;max-height: 700px;height: 700px; ">
	<div style="max-width: 850px;max-height: 480px;height: 480px;overflow: hidden;text-align: center; ">
		@if(!empty($ServiceInfo))
		<img src="/photos/service/800/{{$ServiceInfo->photo}}" alt="" style="max-width: 800px;">
		@endif
	</div>
	<div style="max-width: 850px;max-height: 100px;height: 100px;padding: 10px;margin-top:10px;">
		<div style="max-height: 100px;text-align: right;">
			<form id="photo_form" method="post" enctype="multipart/form-data" action="../service_photo_upload/{{$ServiceID}}">
				{{ csrf_field() }}
			  <span style="margin-right: 50px;font-weight: bold;float: left;">設施名稱：{{$ServiceName->service_name}}</span>
			  <input id="photo_browser" type="file" name="service_photo" onchange="autoUpload()" style="display: none;">
			  <input type="button" value="上傳照片" style="margin-bottom: 10px;" onclick="openBrowser()">
			  <span id="loading_span" style="display:none"><img src="/pic/sloading.gif" alt="">上傳中...</span>
			  <a href="javascript:delPhoto()" style="margin-right: 100px;">刪除照片</a>
			</form>
		</div>
		<div style="max-height: 100px;">
			費用：
			<input id="cost" name="cost" type="text" class="" placeholder="免費或付費" value="@if(!empty($ServiceInfo)){{$ServiceInfo->cost}}@endif" onblur="chgInfo()" style="width:40%;">
			開放時段：
			<input id="period" name="period" type="text" class="" placeholder="24小時或上午9點至下午10點" value="@if(!empty($ServiceInfo)){{$ServiceInfo->period}}@endif" onblur="chgInfo()" style="width:40%;">
		</div>
		<div style="max-height: 100px;">
			說明：
			<input type="text" id="comm" name="comm" class="" placeholder="付費說明及使用須知" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="@if(!empty($ServiceInfo)){{$ServiceInfo->comm}}@endif" style="width:91%;margin-top: 5px;" onblur="chgInfo()">
		</div>
		<div style="margin-top:5px;max-height: 30px;color:red;text-align: center;font-size:0.8rem">
			*內容未填寫.則該項目網站不會顯示
		</div>
	</div>
</div>
 </div>
 
</body>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
	$(function(){
		$('#loading_span').hide();
	});
	function openBrowser(){
		$('#photo_browser').click();
	}
	function autoUpload(){
		$('#loading_span').show();
		$('#photo_form').submit();
	}
	//刪除圖片
	function delPhoto(){
		if(confirm('確定要刪除此照片？')){
			$.ajax({
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        },
		        type: "POST",
		        url: './{{$ServiceID}}/del',
		        // data: {nokey:key},
		        success: function(data) {
		        	window.location.reload();
		    	}
		    });
		}
	}
	function chgInfo(){
		$.ajax({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        type: "POST",
	        url: './{{$ServiceID}}',
	        data: {cost:$('#cost').val(),period:$('#period').val(),comm:$('#comm').val()},
	        success: function(data) {
				window.location.reload();
	    	}
	    });
	}
</script>
</html>