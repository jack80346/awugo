<!DOCTYPE html>
<head>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>照片修改</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
<style type="text/css">

</style>
</head>
<body style="overflow:hidden;max-width: 850px;max-height: 600px;height: 600px;">
 
<div style="max-width: 850px;max-height: 600px;height: 600px; ">
	<div style="max-width: 850px;max-height: 500px;overflow: hidden;text-align: center; ">
		<img src="/photos/800/{{$Photo->name}}.{{$Photo->picture_type}}" alt="" style="max-width: 800px;">
	</div>
	<div style="max-width: 850px;max-height: 100px;height: 100px;padding: 10px;margin-top:10px;">
		<div style="max-height: 100px;text-align: center;">
			照片分類：
			<select class="" id="ver" name="ver" style="width:140px;" onchange="changeCate({{$Photo->nokey}},this)">
		  	  	<option value='1'@if($Photo->category==1) selected='' @endif>環境設施</option>
			    <option value='2'@if($Photo->category==2) selected='' @endif>餐飲</option>
			    <option value='3'@if($Photo->category==3) selected='' @endif>溫泉SPA</option>
			    <option value='4'@if($Photo->category==4) selected='' @endif>客房</option>
			    <option value='-1'@if($Photo->category==-1) selected='' @endif>其他</option>
		  	</select>
			照片標題：
			<input id="pic_title{{$Photo->nokey}}" name="pic_title{{$Photo->nokey}}" type="text" class="" placeholder="照片標題及說明" value="{{$Photo->title}}" onblur="editPics({{$Photo->nokey}})">
			排序：
			<input type="number" id="pic_sort{{$Photo->nokey}}" name="pic_sort{{$Photo->nokey}}" class="" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{$Photo->sort}}" onblur="editPics({{$Photo->nokey}})" onkeyup="numcheck(this.id,this)" style="width:70px;">
			
		  	<a href="javascript:delPic({{$Photo->nokey}})">刪除</a>
		</div>
	</div>
</div>
 
</body>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script type="text/javascript">
//驗證數字，專屬特地給IE享用
function numcheck(id,time){
	var re = /^[0-9]+$/;
	if (!re.test(time.value)){
		alert("只能輸入數字");
	  	document.getElementById(id).value="0";
	}
}
//修改照片分類
function changeCate(key,obj){
	$.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: 'photos_cate',
        data: {nokey:key,cate:$(obj).val()},
        success: function(data) {
			window.location.reload();
    	}
    });
}
//修改照片資訊
function editPics(key){
		pTitle =$('#pic_title'+key).val();
		pSort =$('#pic_sort'+key).val();
		$.ajax({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        type: "POST",
	        url: 'photos_edit',
	        data: {nokey:key,title:pTitle,sort:pSort},
	        success: function(data) {

	    	}
	    });
}
//刪除照片
function delPic(key){
	if(confirm('確定要刪除此照片？')){
		$.ajax({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        type: "POST",
	        url: 'photos_del',
	        data: {nokey:key},
	        success: function(data) {
	        	window.location.reload();
	    	}
	    });
	}
}
</script>

</html>