<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('hotel_name') 管理後台 - @yield('title')</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">
        <!-- jQuery331 -->
	    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		<script type="text/javascript" src="/libs/fancy/jquery.mousewheel.pack.js?v=3.1.3"></script>
		<script type="text/javascript" src="/libs/fancy/jquery.fancybox.pack.js?v=2.1.5"></script>
		<link rel="stylesheet" type="text/css" href="/libs/fancy/jquery.fancybox.css?v=2.1.5" media="screen" />
		<link rel="stylesheet" type="text/css" href="/libs/fancy/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
		<script type="text/javascript" src="/libs/fancy/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
		<link rel="stylesheet" type="text/css" href="/libs/fancy/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
		<script type="text/javascript" src="/libs/fancy/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
		<script type="text/javascript" src="/libs/fancy/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
        <link rel="stylesheet" href="/css/checkbox.css">

		<style type="text/css">
			html{

			}
			body{
				font-family: Microsoft JhengHei;
				min-width: 1440px;
			}
			header{
				
			}
			.container{
				max-width: 1440px;color:#000;
				min-width: 100%;
				padding: 0px;
				margin:auto;
			}
			.container_padding{
				padding-left: 15px;
				padding-right: 15px;
			}
			.center {
			    margin: auto;
			}
			.input-group-text{
				color:#000;
			}
			.table td, .table th {
				padding:.2rem;
			}
			#top_nav ul > li{
				display:inline;
				margin:0px;
				margin-left: 5px;
				margin-right: 5px;
			}
			#top_nav ul{
				margin-bottom:0rem;
				margin-top:20px;
				padding-left: 0px;
			}
			#top_nav ul > li > a{
				color:#000;
			}
			#sys_btn{
				width:100%;
				height:70px;
			}
			#sys_btn ul{
				margin-bottom:5px;
				margin-top:20px;
				display: inline-block;
				width:100%;
			}
			#sys_btn ul > li{
				display:inline-block;
				min-width: 100px;
				color:#000;
				border: 0px;
			}
			#sys_btn ul > li > a{
				color: #000;
			}
			#subsys_btn{
				width:100%;
				height:50px;
			}
			#subsys_btn ul{
				margin-bottom:5px;
				margin-top:20px;
				display: inline-block;
				width:100%;
			}
			#subsys_btn ul > li{
				display:inline-block;
				width:12.2%;
				color:#000;
				border: 0px;
			}
			#subsys_btn ul > li > a{
				color: #000;
			}
			.btn-info{
				background: #c1e1ee;
			}
			.btn-info:hover{
				background-color: #8cd8f8;
			}
			#subsys_btn ul > .btn-warning{
				background-color: #f8e2a2;
			}
			@yield('instyle')
		</style>
        
    </head>
<body style="color: #000;">
	<header>
		<div class="container" style="background: #C1E1EE;max-width: 100%;padding-left: 15px;padding-right: 15px;height: 70px;">
			<div style="float: left;width:125px;height:62px;margin-right: 10px;"><img src="/pic/auth_layout_logo.png" alt=""></div>
			<div style="float: left;margin-top:15px;font-size: 20px;font-weight: bold;">@yield('hotel_name')管理系統</div>
			<div id="top_nav" style="float: right;">
				<ul>
					<li>房間管理</li>
					<li id="top_nav_item_menu">選單管理</li>
					<li>權限設定</li>
					<li>合約書</li>
					<li>awugo<->飯店留言</li>
					<li>{{session()->get('hotel_manager_name')}}</li>
					<li><a href="/tw/auth/{{Request::route()->parameters()['hotel_id']}}/logout" onclick="return confirm('確定要登出?')" id="logout_btn" name="logout_btn">登出</a></li>
				</ul>
			</div>
		</div>
		<div id="sys_btn">
			<ul class="container_padding">
				<li class="btn btn-info" id="hotel_profile"><a href="main">飯店資料</a></li>
				<li class="btn btn-info" id="room_price"><a href="price">房價表</a></li>
				<li class="btn btn-info" id="dashboard"><a href="#">最新資料</a></li>
				<li class="btn btn-info" id="booking_log"><a href="#">訂房紀錄</a></li>
				<li class="btn btn-info" id="account"><a href="#">費用管理</a></li>
				<li class="btn btn-info" id="booking_msg"><a href="#">訂單留言</a></li>
				<li class="btn btn-info" id="score"><a href="#">客戶評鑑</a></li>
				<li class="btn btn-info" id="guestbook"><a href="#">訪客留言</a></li>
				<li class="btn btn-info" id="news"><a href="#">最新消息</a></li>
				<li class="btn btn-info" id="album"><a href="#">網路相簿</a></li>
				<li class="btn btn-info" id="activity_photo"><a href="#">活動剪影</a></li>
				<li class="btn btn-info" id="video_share"><a href="#">影音分享</a></li>
				<li class="btn btn-info" id="report"><a href="#">媒體報導</a></li>
			</ul>
		</div>
		<div id="subsys_btn" style="margin-bottom: 5px;margin-top: -4px;">
			<ul id="hotel_subsys_ul" class="container_padding" style="margin-bottom: 0px;margin-top: 0px;display:none;">
				<li id="hotel_subsys-main" class="btn"><a href="main">基本資料</a></li>
				<li id="hotel_subsys-photos" class="btn"><a href="photos">照片上傳</a></li>
				<li id="hotel_subsys-service" class="btn"><a href="service">設施與服務</a></li>
				<li id="hotel_subsys-room_set" class="btn"><a href="room_set">客房設定</a></li>
			</ul>
			<ul id="hotel_subsys_ul" class="container_padding" style="margin-bottom: 0px;margin-top: 0px;display:none;">
				<li id="hotel_subsys-price" class="btn"><a href="price">全部房價</a></li>
				<li id="hotel_subsys-price_normal" class="btn"><a href="price_normal?b=1">一般房價</a></li>
				<li id="hotel_subsys-price_group" class="btn"><a href="#">套裝方案</a></li>
				<!-- <li id="hotel_subsys-price_group" class="btn"><a href="price_group">套裝方案</a></li> -->
			</ul>
		</div>
	</header>
	<div class="container">
		<!-- 錯誤訊息 -->
		@include('error_msg')

		@yield('content')
	</div>
		<footer>
			<p class="mt-5 mb-3 text-center text-muted" style="clear: both;">© 2017-2018 長龍科技股份有限公司　v0.2.1</p>
		</footer>
	<!-- ** -->
	<div style="width:350px;height:290px;position: absolute;top:0;background-color: #FFF;display: none;box-shadow: 0 6px 6px 2px #cacaca;" id="menu_manage_layout">
	    <div class="row" style="margin:0px;padding:5px;background-color: #B8CCE4;height: 30px;font-weight: 800;">勾選下列選單代表開啟功能，反之即關閉</div>
	    <div class="row" style="margin:0px;padding:5px;text-align: center;display: block;">
	    	<input type="checkbox" id="menu_manage[]" name="menu_manage[]">最新消息
	    </div>
	    <div class="row" style="margin:0px;padding:5px;text-align: center;display: block;">
	    	<input type="checkbox" id="menu_manage[]" name="menu_manage[]" checked="">訪客留言
	    </div>
	    <div class="row" style="margin:0px;padding:5px;text-align: center;display: block;">
	    	<input type="checkbox" id="menu_manage[]" name="menu_manage[]">網路相簿
	    </div>
	    <div class="row" style="margin:0px;padding:5px;text-align: center;display: block;">
	    	<input type="checkbox" id="menu_manage[]" name="menu_manage[]">活動剪影
	    </div>
	    <div class="row" style="margin:0px;padding:5px;text-align: center;display: block;">
	    	<input type="checkbox" id="menu_manage[]" name="menu_manage[]">影音分享
	    </div>
	    <div class="row" style="margin:0px;padding:5px;text-align: center;display: block;">
	    	<input type="checkbox" id="menu_manage[]" name="menu_manage[]">媒體報導
	    </div>
	    <div class="row" style="margin:0px;padding:5px;text-align: right;display: block;margin:5px;"><a href="#" class="btn btn-primary">確認</a></div>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="logoutAlert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">警告！</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        此動作即將登出，資料儲存好了嗎？
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">按錯</button>
	        <button type="button" class="btn btn-secondary" onclick="window.location.href='/{{$Country}}/auth/logout'">確定登出</button>
	      </div>
	    </div>
	  </div>
	</div>
	
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>

    <script type="text/javascript">

    	@yield('custom_script')
    	function setMenuManagePosition(){
    		mLeft =$('#top_nav_item_menu').offset().left-($('#menu_manage_layout').width()/2);
    		mTop =($('#top_nav_item_menu').height()+$('#top_nav_item_menu').offset().top)+2;
    		$('#menu_manage_layout').css('left',mLeft).css('top',mTop);
    	}
    	$(function(){
    		//顯示主選單選取項目
    		$("#sys_btn > ul > li").eq(@yield('main_fun')).removeClass('btn-info').addClass('btn-warning');
    		$("#subsys_btn > ul").eq(@yield('main_fun')).show();
    		//調整選單管理位置
    		setMenuManagePosition();
    		$('#top_nav_item_menu').hover(function(){
    			$('#menu_manage_layout').slideDown(1000,'easeOutElastic');
    		});
    		$('#menu_manage_layout').hover(null,function(){
    			$('#menu_manage_layout').slideUp(1000,'easeInOutElastic');
    		});
    		//子選單亮按鈕 @yield('sub_fun')
    		$('#subsys_btn ul li').removeClass('btn-warning');
    		$("#hotel_subsys-@yield('sub_fun')").addClass('btn-warning');
    		@yield('custom_ready_script')
    	});
    </script>
</body>
</html>