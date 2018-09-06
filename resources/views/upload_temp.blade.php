<!DOCTYPE html>
<head>
<meta charset="utf-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>檔案上傳測試</title>
<link href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css" type="text/css" rel="stylesheet" />
<style type="text/css">

</style>
</head>
<body>
 
 
<h2 align="center">拖曳式圖片上傳測試</h2>
 
 
 
 
<form id='form1' name='form1' action="/tw/api/image" class="dropzone" method="post" enctype="multipart/form-data">{{csrf_field()}}
</form>
 
 
</body>
<script src="/js/dropzone.js"></script>
<script type="text/javascript">
var fileCountOver =false;
Dropzone.options.form1 = {
	maxFilesize: 5,
	maxFiles: 10,
	uploadMultiple: true,
	acceptedFiles: ".png, .jpg",
	accept: function(file, done) {
            console.log(file);
            if (file.type != "image/jpeg" && file.type != "image/png") {
                done("Error! Files of this type are not accepted");
            }
            else { done(); }
        },
  	init: function() {
	    this.on("completemultiple", function(file) { 
	    	if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
		        alert('全部上傳完成'); 
		        if(fileCountOver){
		        	alert("一次最多只能傳"+ Dropzone.options.form1.maxFiles +"張照片\n已移除超出的圖片");
		        	fileCountOver =false;
		        }
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