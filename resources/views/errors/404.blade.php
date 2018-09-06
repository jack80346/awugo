<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="refresh" content="3;url=/" />
        <title>Awugo-找不到網頁</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="/css/checkbox.css">
		<style type="text/css">
			html{
				min-width: 1440px;
			}
			body{
				font-family: Microsoft JhengHei;
				min-width: 1440px;color:#000;
			}
			@yield('instyle')
		</style>
        
    </head>
<body style="text-align: center;color: #000;">
	<img src='/pic/404.png' />
		<footer>
			<p class="mt-5 mb-3 text-center text-muted" style="clear: both;">© 2017-2018 長龍科技股份有限公司</p>
		</footer>
	
	<!-- jQuery331 -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>

    <script type="text/javascript">
    	@yield('custom_script')
    	$(function(){
    		@yield('custom_ready_script')
    		//判斷頁面導航紐按下樣式
    		//color: #ED1A23;background-color: #ffffff;border-color: #ffffff;
    </script>
</body>
</html>