<!DOCTYPE html>
<head>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>拖拉式照片上傳</title>
<link href="/css/dropzone.css" type="text/css" rel="stylesheet" />
<style type="text/css">
html,body{
	 width:900px;
	 max-width: 900px;
	 max-height: 700px;
	 height: 400px;
	 overflow: hidden;
}
</style>
</head>
<body>
 <div style="max-width: 825px;max-height: 700px;height: 400px; padding: 0px;text-align: center;">
<h2 align="center">拖拉式照片上傳</h2>
<span style="color:red">一次上傳最多10張，照片上限30張</span>
 
 
 
<form style="margin-top: 10px;" id='form1' name='form1' action="/tw/api/image" class="dropzone" method="post" enctype="multipart/form-data">{{csrf_field()}}
</form>
 </div>
 
</body>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="/js/dropzone.js"></script>
<script type="text/javascript">


var fileCountOver =false;
Dropzone.options.form1 = {
	maxFilesize: 5,
	maxFiles: 10,
	uploadMultiple: false,
	acceptedFiles: ".png, .jpg",
	accept: function(file, done) {
            console.log(file);
            if (file.type != "image/jpeg" && file.type != "image/png") {
                done("Error! Files of this type are not accepted");
            }
            else { done(); }
        },
  	init: function() {

	    this.on("queuecomplete", function(file) { 
	    	if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
		        alert('全部上傳完成'); 
		        if(fileCountOver){
		        	alert("一次最多只能傳"+ Dropzone.options.form1.maxFiles +"張照片\n已移除超出的圖片");
		        	fileCountOver =false;
		        }
		        window.parent.location.reload();
		      }
	    });
	    this.on("maxfilesexceeded", function(file){
	    	this.removeFile(file);
	    	fileCountOver =true;
	    });
	  }
};

</script>

</html>