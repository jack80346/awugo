<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Awugo總管理後台 - @yield('title')</title>
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
			.container_width{
				width:98%;
			}
			.container{
				min-width: 1440px;
			}
			.btn-no-border{
				border-color:#FFF;
			}
			.nav{
    			margin: auto;
			}
			#nav_logout{
				position: relative;
				top: 50%;
				float: right;
				transform: translateY(30%);
			}
			#nav_item{
				background: #FFF;
			}
			.nav_item_new_active{
				color: #ED1A23;background-color: #ffffff;border-color: #ffffff;
			}
			#top{
				width:100%;
				height:65px;
				background: #C2E1EC;
			}
			#top_container{
				margin: auto;
			}
			#top_container_title{
				width: 300px;
			    font-size: 20pt;
			    box-sizing: content-box;
			    	-webkit-box-sizing: content-box;
			    	-moz-box-sizing: content-box;
			    padding: 10px;
			}
			.btn-outline-secondary{
				color:#000000;
			}
			.containet{
				max-width: 98%;
			}
			#top_container_system{
				float: left;
			    height: 60px;
			    padding: 16px;
			}
			#top_container_system > ul >li{
				float:left;
				width: 60px;
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
			@yield('instyle')
		</style>
        
    </head>
<body style="margin-top:150px;color: #000;">
	<header>
		<nav class="navbar navbar-default fixed-top" style="padding:0;box-shadow: 0 6px 6px -2px #cacaca;background-color: white;min-width: 1440px;">
			<div id="top">
				<div id="top_container" class="container_width">
					<div id="top_container_logo" style="float:left;"><img src="/pic/auth_layout_logo.png" alt=""></div>
					<div id="top_container_title" style="float:left;">訂房總管理系統>台灣</div>
					<div id="top_container_system" style="float:left;" class="text-center">
						<ul class="list-inline">
							<li><span style="color:#ED1A23;">訂房</span></li>
							<li>景點</li>
							<li style="width:85px;">活動資訊</li>
							<li>旅遊</li>
							<li>租車</li>
							<li>美食</li>
						</ul>
					</div>
					<div id="nav_logout" class="align-middle">
						<span class="align-middle" role="button" aria-pressed="true" id="top-nav-36" href="#"> {{ session()->get('manager_name') }} 您好！</span>
						<a id="logout" class="btn btn-outline-secondary btn-no-border btn-smalign-middle" role="button" aria-pressed="true" id="top-nav-36">登出</a>
					</div>
				</div>
			</div>
			<div id="nav_item" class="nav container_width" style="margin-bottom: 5px;">
			  	<a data-nokey='1' href="/{{$Country}}/auth/manager/hotel_list" class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-1" href="#">飯店管理</a>
			  	<a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-2" href="#">費用管理</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-3" href="#">訂房成功</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-4" href="#">訂房查詢</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-5" href="#">訂單留言</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-6" href="#">會員管理</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-7" href="#">飯店留言</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-8" href="#">通知飯店</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-9" href="#">聯絡我們</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-10" href="./main">最新資料</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-11" href="#">公司發票</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-12" href="#">飯店發票</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-13" href="#">紅利點數</a>
			    <a data-nokey='36' class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-14" href="/{{$Country}}/auth/manager/attraction_list">景點設定</a>
			    <a data-nokey='43' class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-43" href="/{{$Country}}/auth/manager/area_list">地區管理</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-15" href="#">電子報　</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-16" href="#">熱門地點</a>
			    <a data-nokey='44' class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-44" href="/{{$Country}}/auth/manager/service">設施服務</a>
			    <a data-nokey='48' class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-48" href="/{{$Country}}/auth/manager/room_installation">客房設施</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-19" href="#">傳真紀錄</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-20" href="#">住宿評鑑</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-21" href="#">住宿用卷</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-22" href="#">追蹤管理</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-23" href="#">飯店加盟</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-24" href="#">電話訂單</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-25" href="#">比價列表</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-26" href="#">待辦事項</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-27" href="#">合約管理</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-28" href="#">系統設定</a>
			    <a data-nokey='33' class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-29" href="/{{$Country}}/auth/manager/authority_list">權限管理</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-30" href="#">廣告刊登</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-31" href="#">團體預約</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-32" href="#">流量分析</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-33" href="#">買貴回報</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-34" href="#">網站編輯</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-35" href="#">網站後台</a>
			    <a class="btn btn-outline-secondary btn-no-border btn-sm" role="button" aria-pressed="true" id="top-nav-36" href="#">網站前台</a>
			</div>
		</nav>
	</header>
	<div class="container" style="max-width: 98%">
		<!-- 錯誤訊息 -->
		@include('error_msg')

		@yield('content')
	</div>
		<footer>
				<div id="top_count" style="float:right;width: 340px;height: 45px;transform: translateY(30%);clear: both;">
					<span class="align-middle" role="button" aria-pressed="true" id="top-nav-36" href="#">今日:88　昨日:77　前日:88　總計:6500</span>
				</div>
			<p class="mt-5 mb-3 text-center text-muted" style="clear: both;">© 2017-2018 長龍科技股份有限公司　v0.2.1</p>
		</footer>
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
    		$("#top-nav-@yield('nav_id')").addClass("active").css("color","#ED1A23").css("background-color","#FFF").css("border-color","#FFF");
    		// 浮動確認視窗
    		$('#logout').click(function () {
  				$('#logoutAlert').modal("toggle");
			});
			//隱藏無權限按鈕
			var auth_str = "{{implode(",",$Auths)}}";
			var auth_array = auth_str.split(",");
			// alert(auth_str);
			$("a[data-nokey]").each(function(){
				// alert(jQuery.inArray('33', auth_array ));
				if(auth_array.indexOf($(this).data('nokey')+'') <0){
					$(this).css('visibility','hidden');
					// alert($(this).data('nokey'));
				}
			});
			
    	});
    </script>
</body>
</html>