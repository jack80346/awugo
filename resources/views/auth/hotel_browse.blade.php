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
	        <h5 class="modal-title" id="exampleModalLabel">編輯完成</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        已編輯成功
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">OK！</button>
	      </div>
	    </div>
	  </div>
	</div>
@endif

<form method="POST" role="form" action="/{{$Country}}/auth/manager/hotel_edit/{{$Hotel->nokey}}" onsubmit="return valid(this);">
	{{ csrf_field() }}
	<div class="row">
		<div class="input-group input-group-sm col-md-6">
		  <div class="input-group-prepend">
		    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">飯店名稱</span>
		  </div>
		  <span class="form-control" style="border: 0px;color:red;">@if($Hotel->name !='') {{$Hotel->name}} @endif</span>
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-3" style="max-width: 312px;">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="inputGroup-sizing-sm">版本</span>
		  </div>
		  <span class="form-control" style="border: 0px;">@if($Hotel->version !='-1') {{$Hotel->version}} @endif</span>
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-3">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="inputGroup-sizing-sm">狀態</span>
		  </div>
		  <span class="form-control" style="border: 0px;">
		  	@if($Hotel->state =='0') 上線 
			@elseif($Hotel->state =='1') 下線
			關閉
		  	@endif
		  </span>
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<div class="input-group input-group-sm col-md-6">
		  <div class="input-group-prepend" style="@if($Hotel->url =='') display:none; @endif">
		    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">官方網站</span>
		  </div>
		  <span class="form-control" style="border: 0px;"><a href="{{$Hotel->url}}" target="_blank">{{$Hotel->url}}</a></span>
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-3" style="max-width: 312px;">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="inputGroup-sizing-sm">訂金</span>
		  </div>
		   <span class="form-control" style="border: 0px;"> {{$Hotel->deposit}} %</span>
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-3">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="inputGroup-sizing-sm">控管</span>
		  </div>
		  <span class="form-control" style="border: 0px;"> 
		  	@if($Hotel->control==0)
		  		立即訂房
		  	@else
				客服訂房
		  	@endif
		  </span>
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<table width="100%">
		  <tr>
		    <td width="50%">
		    	<div class="input-group input-group-sm">
					  <div class="input-group-prepend">
					    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">飯店地址</span>
					  </div>
					  <select class="form-control" id="area_level1" name="area_level1" style="display:none">
						  <option value='1'>台灣</option>
					  </select>
					  <select class="form-control" id="area_level2" name="area_level2" onchange="chg_area(this,2)" style="display:none;">
						  <option value='-1'>縣市</option>
						  @foreach($Areas_level2 as $key => $area2)
								<option value='{{$area2->nokey}}'@if($Hotel->area_level2==$area2->nokey) selected="" @endif>{{$area2->area_name}}</option>
						  @endforeach
					  </select>
					  <div id="area2_text" style="margin-left: 5px;margin-right: 5px;color: #495057;font-size: 16px;"></div>
					  <select class="form-control" id="area_level3" name="area_level3" onchange="chg_zip_code(this,'zip_code')" style="display:none;">
						  <option value='-1'>區域</option>
						  @foreach($Addr_level3 as $key => $addr3)
							<option value='{{$addr3->nokey}}'@if($Hotel->area_level3==$addr3->nokey) selected="" @endif>{{$addr3->area_name}}</option>
						  @endforeach
					  </select>
					  <div id="area3_text" style="color: #495057;"></div>
					  <br/>
					  	<div class="input-group input-group-sm col-md-1" style="color: #495057;"> 
						  {{$Hotel->zip_code}}
						</div>
						<!-- ** -->
					  	<div class="input-group input-group-sm col-md-6" style="color: #495057;">
						  {{$Hotel->address}}
						</div>
				</div>
		    </td>
		    <th rowspan="4" style="background-color: #c9fcb3;width: 5%;text-align: center;">手續費</th>
		    <td>
		    	<div class="row" style="padding-left: 15px;">
					<div class="input-group input-group-sm col-md-4">
					  <div class="input-group-prepend">
					    <span class="input-group-text" id="inputGroup-sizing-sm">C版</span>
					  </div>
					  <span class="form-control" style="border: 0px;">{{$Hotel->fees_c}}%</span>
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-4" style="padding-left: 15px;">
					  <div class="input-group-prepend">
					    <span class="input-group-text" id="inputGroup-sizing-sm">紅利</span>
					  </div>
					  <span class="form-control" style="border: 0px;">{{$Hotel->fees_c_bonus}}%</span>
					</div>
				</div>
		    </td>
		  </tr>
		  <tr>
		    <td>
		    	<div class="row" style="margin-right: 0px;margin-left:0px;">
			    	<div class="input-group input-group-sm col-md-6">
					  <div class="input-group-prepend">
					    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">飯店電話</span>
					  </div>
					  <span class="form-control" style="border: 0px;">{{$Hotel->tel1}}</span>
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-6"@if($Hotel->tel2=='+886-') style="display:none" @endif>
					  <div class="input-group-prepend">
					    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">備用電話</span>
					  </div>
					  <span class="form-control" style="border: 0px;">{{$Hotel->tel2}}</span>
					</div>
				</div>
		    </td>
		    <td>
		    	<!-- ** -->
		    	<div class="row" style="padding-left: 15px;">
					<div class="input-group input-group-sm col-md-4">
					  <div class="input-group-prepend">
					    <span class="input-group-text" id="inputGroup-sizing-sm">AB版</span>
					  </div>
					  <span class="form-control" style="border: 0px;">{{$Hotel->fees_ab}}%</span>
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-4" style="padding-left: 15px;">
					  <div class="input-group-prepend">
					    <span class="input-group-text" id="inputGroup-sizing-sm">紅利</span>
					  </div>
					  <span class="form-control" style="border: 0px;">{{$Hotel->fees_ab_bonus}}%</span>
					</div>
				</div>
				<!-- ** -->
		    </td>
		  </tr>
		  <tr>
		    <td rowspan="2">
		    	<div class="row" style="margin-right: 0px;margin-left:0px;">
			    	<div class="input-group input-group-sm col-md-6">
					  <div class="input-group-prepend">
					    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">飯店傳真</span>
					  </div>
					  <span class="form-control" style="border: 0px;">{{$Hotel->fax1}}</span>
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-6"@if($Hotel->fax2=='+886-') style="display:none" @endif>
					  <div class="input-group-prepend">
					    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">備用傳真</span>
					  </div>
					  <span class="form-control" style="border: 0px;">{{$Hotel->fax2}}</span>
					</div>
				</div>
		    </td>
		    <td>
		    	<!-- ** -->
		    	<div class="row" style="padding-left: 15px;">
					<div class="input-group input-group-sm col-md-4">
					  <div class="input-group-prepend">
					    <span class="input-group-text" id="inputGroup-sizing-sm">D版</span>
					  </div>
					  <span class="form-control" style="border: 0px;">{{$Hotel->fees_d}}%</span>
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-4" style="padding-left: 15px;">
					  <div class="input-group-prepend">
					    <span class="input-group-text" id="inputGroup-sizing-sm">紅利</span>
					  </div>
					  <span class="form-control" style="border: 0px;">{{$Hotel->fees_d_bonus}}%</span>
					</div>
				</div>
				<!-- ** -->
		    </td>
		  </tr>
		  <tr>
		    <td>
		    	<!-- ** -->
		    	<div class="row" style="padding-left: 15px;">
					<div class="input-group input-group-sm col-md-4">
					  <div class="input-group-prepend">
					    <span class="input-group-text" id="inputGroup-sizing-sm">經銷紅利</span>
					  </div>
					  <span class="form-control" style="border: 0px;">{{$Hotel->fees_sale_bonus}}%</span>
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-4" style="padding-left: 15px;">
					  <div class="input-group-prepend">
					    <span class="input-group-text" id="inputGroup-sizing-sm">住宿紅利</span>
					  </div>
					  <span class="form-control" style="border: 0px;">{{$Hotel->fees_roll_bonus}}%</span>
					</div>
				</div>
				<!-- ** -->
		    </td>
		  </tr>
		</table>
	</div>
	<!-- ** -->
	<div class="row">
		<div class="input-group input-group-sm col-md-3">
		  <div class="input-group-prepend"@if($Hotel->email1=='') style="display:none" @endif>
		    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">主要信箱</span>
		  </div>
		  <span class="form-control" style="border: 0px;">{{$Hotel->email1}}</span>
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-3">
		  <div class="input-group-prepend"@if($Hotel->email2=='') style="display:none" @endif>
		    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">備用信箱</span>
		  </div>
		  <span class="form-control" style="border: 0px;">{{$Hotel->email2}}</span>
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-3">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="inputGroup-sizing-sm">合作種類</span>
		  </div>
		  <span class="form-control col-md-3" style="border: 0px;">
			{{$Hotel->cooperation}}
		  </span>
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-3">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="inputGroup-sizing-sm">連假房價</span>
		  </div>
		  <span class="form-control col-md-3" style="border: 0px;">
		  	@if($Hotel->holday ==0)
				未設
		  	@elseif($Hotel->holday ==1)
				比照周六房價
		  	@else
				高於周六房價
		  	@endif
		  </span>
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<div class="input-group input-group-sm col-md-3">
		  <div class="input-group-prepend" style="@if($Hotel->app_line=='')display:none;@endif">
		    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">通訊軟體</span>
		  </div>
		  <span class="form-control" style="border: 0px;">{{$Hotel->app_line}}</span>
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-3">
		  <span class="form-control" style="border: 0px;">{{$Hotel->app_wechat}}</span>
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-3" style="max-width: 312px;">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="inputGroup-sizing-sm">結帳方式</span>
		  </div>
		  <span class="form-control" style="border: 0px;">
		  	@if($Hotel->checkout ==0)
	  			日結
	  		@else
	  			月結
	  		@endif
		  </span>
		</div>
		<div class="input-group input-group-sm col-md-2">
			  <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">訂房起始日</span>
			  </div>
			  <span class="form-control" style="border: 0px;">{{$Hotel->booking_day}}日</span>
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<div class="input-group input-group-sm col-md-6">
		  	<div class="input-group-prepend">
		    	<span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">相關證照</span>
		  	</div>
		  	
		        @if($Hotel->license_hotel==1)
			        <span class="form-control" style="border: 0px;">合法旅館
			        </span>
		        @endif
		  	
		  	
		        @if($Hotel->license_homestay==1)
			        <span class="form-control" style="border: 0px;">合法民宿
			        </span>
		        @endif
		  	
		  	
		        @if($Hotel->license_hospitable==1)
			        <span class="form-control" style="border: 0px;">好客民宿
			        </span>
		        @endif

		        @if($Hotel->illegal_homestay==1)
			        <span class="form-control" style="border: 0px;">非法旅宿
			        </span>
		        @endif
		  	
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-3" style="max-width: 312px;">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="inputGroup-sizing-sm">發票型態</span>
		  </div>
		  <span class="form-control" style="border: 0px;">
		  @if($Hotel->invoice_type==0)
			甲
		  @elseif($Hotel->invoice_type==1)
			乙
		  @else
			丙
		  @endif
		  </span>
		</div>
		<div class="input-group input-group-sm col-md-3">
			  <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">配合度</span>
			  </div>
			  <span class="form-control" style="border: 0px;">
			  @if($Hotel->coordinate==0)
				佳
			  @elseif($Hotel->coordinate==1)
				普通
			  @else
				差
			  @endif
			  </span>
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<div class="input-group input-group-sm col-md-6">
		  	<div class="input-group-prepend">
		    	<span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">飯店類型</span>
		  	</div>
		  	<span class="form-control col-md-5" style="border: 0px;">
		  		{{$Hotel->type_scale}}
		  	</span>
		  	<div class="input-group-prepend">
		    	<span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">飯店星級</span>
		  	</div>
		  	<span class="form-control col-md-2" style="border: 0px;">
		  		@if($Hotel->type_level==0) ☆ @endif
		  		@if($Hotel->type_level==1) ★ @endif
		  		@if($Hotel->type_level==2) ★★ @endif
		  		@if($Hotel->type_level==3) ★★★ @endif
		  		@if($Hotel->type_level==4) ★★★★ @endif
		  		@if($Hotel->type_level==5) ★★★★★ @endif
		  	</span>
		    <div class="input-group-prepend">
			    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">房間總數</span>
			  </div>
			  <span class="form-control col-md-2" style="border: 0px;">{{$Hotel->type_room}}</span>
			<div class="input-group-prepend">
			    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">排序</span>
			</div>
			<span class="form-control col-md-1" style="border: 0px;">
				{{$Hotel->sort}}
			</span>
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="inputGroup-sizing-sm">追蹤管理</span>
		  </div>
		  <span class="form-control" style="border: 0px;">
			@if($Hotel->track=='0')
				不追蹤
			@else
				追蹤／{{$Hotel->track_comm}}
			@endif
		  </span>
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">開立發票</span>
			</div>
			<span class="form-control col-md-6" style="border: 0px;">
				@if($Hotel->invoice==0)
					可
				@elseif($Hotel->invoice==1)
					僅開立收據
				@else
					皆無
				@endif
			</span>
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="inputGroup-sizing-sm">警察單位</span>
		  </div>
		  <span class="form-control col-md-6" style="border: 0px;">
		  @if($Hotel->local_police==0)
		  	不顯示 
		  @else
		  	顯示
		  	／{{ $Hotel->local_police_comm }}
		  @endif
		  </span>
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend" style="@if($Hotel->reg_name=='') display:none; @endif">
			    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">立案名稱</span>
			</div>
			<span class="form-control col-md-6" style="border: 0px;">
				{{$Hotel->reg_name}}
			</span>
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">SEO標題</span>
			  </div>
			  <span class="form-control col-md-6" style="border: 0px;">{{$Hotel->seo_title}}</span>
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend" style="@if($Hotel->reg_no=='') display:none; @endif">
			    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">統一編號</span>
			</div>
			<span class="form-control col-md-6" style="border: 0px;">
			  	{{$Hotel->reg_no}}
			</span>
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">SEO描述</span>
			  </div>
			  <span class="form-control col-md-6" style="border: 0px;">
			  	{{$Hotel->seo_descript}}
			  </span>
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">現場刷卡</span>
			</div>
			<span class="form-control col-md-6" style="border: 0px;">
				@if($Hotel->credit_card==0)
					可(一般刷卡)
				@elseif($Hotel->credit_card==1)
					可(支援國民旅遊卡)
				@else
					皆無
				@endif
			</span>
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">SEO關鍵字</span>
			  </div>
			  <span class="form-control col-md-6" style="border: 0px;">
				  	{{$Hotel->seo_keyword}}
			  </span>
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend" style="border: 0px;@if($Hotel->bank_code=='')display:none;@endif">
			    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">帳戶資訊</span>
			</div>
			<span class="form-control col-md-6" style="border: 0px;@if($Hotel->bank_code=='')display:none;@endif">
				{{$Hotel->bank_name}}-{{$Hotel->bank_code}}-{{$Hotel->bank_account}}-{{$Hotel->bank_account_name}}
			</span>
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">前台電話</span>
			</div>
			<span class="form-control col-md-6" style="border: 0px;">
				@if($Hotel->display_tel==0)
					不顯示
				@elseif($Hotel->display_tel==1)
					顯示飯店電話
				@else
					顯示awugo電話
				@endif
			</span>
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<div class="input-group input-group-sm col-md-12">
			<div class="input-group-prepend" style="border: 0px;@if($Hotel->point=='')display:none;@endif">
			    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">飯店優點</span>
			</div>
			<span class="form-control col-md-12" style="border: 0px;">
				{{$Hotel->point}}
			  </span>
		</div>
	</div>
	<!-- ** -->
	<div class="row" style="margin-top:30px;">
		@if(count($Contact)>0)
		<table class="tg" style="width: 100%">
		  <tr>
		    <th style="background-color: #c9fcb3;height:45px;text-align: center;width:10%;">姓名</th>
		    <th style="background-color: #c9fcb3;height:45px;text-align: center;width:10%;">職稱</th>
		    <th style="background-color: #c9fcb3;height:45px;text-align: center;width:10%;">電話</th>
		    <th style="background-color: #c9fcb3;height:45px;text-align: center;width:15%;">手機</th>
		    <th style="background-color: #c9fcb3;height:45px;text-align: center;width:10%;">Line</th>
		    <th style="background-color: #c9fcb3;height:45px;text-align: center;width:10%;">微信</th>
		    <th style="background-color: #c9fcb3;height:45px;text-align: center;width:35%;">信箱</th>
		  </tr>
		  @foreach($Contact as $key => $contact_item)
		  <tr>
		    <td style="height:45px;">
		    	{{ $contact_item[0] }}
		    </td>
		    <td style="height:45px;">
		    	{{ $contact_item[1] }}
		    </td>
		    <td style="height:45px;">
		    	{{ $contact_item[2] }}
		    </td>
		    <td style="height:45px;">
		    	{{ $contact_item[3] }}
		    </td>
		    <td style="height:45px;">
		    	{{ $contact_item[4] }}
		    </td>
		    <td style="height:45px;">
		    	{{ $contact_item[5] }}
		    </td>
		    <td style="height:45px;">
		    	{{ $contact_item[6] }}
		    </td>
		  </tr>
		  @endforeach
		  
		  
		</table>
		@endif
		<textarea id="contact_text" name="contact_text" style="width: 500px;height: 600px;display:none;"></textarea>
	</div>
	<!-- ** -->
	<div class="row">
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">後台網址</span>
			</div>
			<span class="form-control" style="border: 0px;">
				<a href='http://www.awugo.com/tw/auth/h{{$Hotel->nokey}}/' target='_blank'>http://www.awugo.com/tw/auth/h{{$Hotel->nokey}}/</a>
			</span>
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">後台簡址</span>
			</div>
			<span class="form-control" style="border: 0px;">
				{{$Hotel->manage_surl}}
			</span>
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">C版網址</span>
			</div>
			<span class="form-control" style="border: 0px;">
				{{$Hotel->c_url}}
			</span>
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">C版簡址</span>
			</div>
			<span class="form-control" style="border: 0px;">
				{{$Hotel->c_surl}}
			</span>
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">D版網址</span>
			</div>
			<span class="form-control" style="border: 0px;">
				{{$Hotel->d_url}}
			</span>
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">D版簡址</span>
			</div>
			<span class="form-control" style="border: 0px;">
				{{$Hotel->d_surl}}
			</span>
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">AB版網址</span>
			</div>
			<span class="form-control" style="border: 0px;">
				{{$Hotel->ab_url}}
			</span>
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">D版顯示電話</span>
			</div>
			<span class="form-control" style="border: 0px;">
				@if($Hotel->d_display_tel==0)
					不顯示
				@elseif($Hotel->d_display_tel==1)
					顯示飯店電話
				@else
					顯示awugo電話
				@endif
			</span>
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<table width="100%">
		  <tr>
		    <th style="background-color: #fff3c6;width: 85px;height: 100px;text-align: center;" rowspan="3">登錄者</th>
		    <td colspan="6">
		    	<div class="row col-md-12">
		    		<div class="input-group input-group-sm col-md-2">
					    <div class="input-group-prepend">
						    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">姓名</span>
						</div>
						<span class="form-control" style="border: 0px;">
							{{$Hotel->login_name}}
						</span>
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-2">
					    <div class="input-group-prepend">
						    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">所屬公司</span>
						</div>
						<span class="form-control" style="border: 0px;">
							{{$Hotel->login_com}}
						</span>
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-2">
					    <div class="input-group-prepend">
						    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">部門或職稱</span>
						</div>
						<span class="form-control" style="border: 0px;">
							{{$Hotel->login_job}}
						</span>
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-5">
					    <div class="input-group-prepend">
						    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">公司地址</span>
						</div>
						<span class="form-control" style="border: 0px;" id="login_addr_span">
							{{$Hotel->login_addr}}
						</span>
						<select class="form-control col-md-2" id="login_area_level1" name="login_area_level1" style="display:none">
						  	<option value='1'>台灣</option>
					  	</select>
					  	<select class="form-control col-md-2" id="login_area_level2" name="login_area_level2" onchange="login_chg_area(this,2)" style="display:none;">
						  	<option value='-1'>縣市</option>
						  	@foreach($Areas_level2 as $key => $area2)
								<option value='{{$area2->nokey}}'@if($Hotel->login_addr_level2==$area2->nokey) selected="" @endif>{{$area2->area_name}}</option>
						  	@endforeach
					  	</select>
					  	<select class="form-control col-md-2" id="login_area_level3" name="login_area_level3" onchange="chg_zip_code()" style="display:none;">
							<option value='-1'>區域</option>
							@foreach($Login_addr_level3 as $key => $addr3)
								<option value='{{$addr3->nokey}}'@if($Hotel->login_addr_level3==$addr3->nokey) selected="" @endif>{{$addr3->area_name}}</option>
						  	@endforeach
						</select>
						<input type="text" class="form-control col-md-8" id="login_addr" name="login_addr" placeholder="請輸入地址" value="{{$Hotel->login_addr}}" style="display:none;">
					</div>
		    	</div>
		    </td>
		  </tr>
		  <tr>
		    <td colspan="6">
		    	<div class="row col-md-12">
		    		<div class="input-group input-group-sm col-md-2">
					    <div class="input-group-prepend">
						    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">公司電話</span>
						</div>
						<span class="form-control" style="border: 0px;">
							{{$Hotel->login_tel}}
						</span>
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-2">
					    <div class="input-group-prepend">
						    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">聯絡手機</span>
						</div>
						<span class="form-control" style="border: 0px;">
							{{$Hotel->login_mobile}}
						</span>
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-2">
					    <div class="input-group-prepend">
						    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">信箱</span>
						</div>
						<span class="form-control" style="border: 0px;">
							{{$Hotel->login_email}}
						</span>
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-4">
					    <div class="input-group-prepend">
						    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">帳號</span>
						</div>
						<span class="form-control" style="border: 0px;">
							{{$Hotel->login_id}}
						</span>
					</div>
		    	</div>
		    </td>
		  </tr>
		  <tr>
		    <td colspan="6">
				<div class="row col-md-12">
		    		<div class="input-group input-group-sm col-md-6">
					    <div class="input-group-prepend">
						    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">集團或連鎖</span>
						</div>
						<!-- ** -->
						<span class="form-control" style="border: 0px;">
							@if($Hotel->login_is_group==0)
								否
							@else
								是
							@endif
						</span>
						<span class="form-control" style="border: 0px;@if($Hotel->login_is_group==0)display:none;@endif">
							@if($Hotel->login_group_url !='')
								<a href="{{$Hotel->login_group_url}}" target="_blank">{{$Hotel->login_group_name}}</a>
							@else
								{{$Hotel->login_group_name}}
							@endif
						</span>
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-6">
					    <div class="input-group-prepend">
						    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">申請合作家數</span>
						</div>
						<span class="form-control" style="border: 0px;">
							@if($Hotel->login_group_count==0) 
								一家
							@else
								多家
							@endif
						</span>
					</div>
		    	</div>
		    </td>
		  </tr>
		</table>
	</div>
	<!-- ** -->
	<div class="row">
		<!-- ** -->
		<div class="input-group input-group-sm col-md-3">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">合約到期日</span>
			</div>
			<span class="form-control" style="border: 0px;">
				{{$Hotel->expire}}
			</span>
		</div>
		<div class="input-group input-group-sm col-md-3" id="contract_no_wrap">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">合約編號</span>
			</div>
			<span class="form-control" style="border: 0px;">
				{{$Hotel->contract_no}}
			</span>
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">瀏覽人數</span>
			</div>
			<span class="form-control" style="border: 0px;">今日:88　昨日:77　前日:88　總計:6500</span>
		</div>
	</div>
	<!-- ** -->
	<div class="row" style="margin-top: 30px;">
		<a href="javascript:window.history.go(-1);" class="btn btn-primary col-md-2" style="margin-left:10px;margin-right:5px;max-width:16%;">上一頁</a>
		<a href="../hotel_edit/{{$Hotel->nokey}}" class="btn btn-primary col-md-2" style="margin-right:5px;max-width:16%;">修改資料</a>
		<a href="../hotel_auth_list/{{$Hotel->nokey}}" class="btn btn-primary col-md-2" style="margin-right:5px;max-width:16%;">權限</a>
		<a href="#" class="btn btn-primary col-md-2" style="margin-right:5px;max-width:16%;">比價表</a>
		<a href="#" class="btn btn-primary col-md-2" style="margin-right:5px;max-width:16%;">合約書</a>
		<a href="#" class="btn btn-primary col-md-2" style="">awugo＜-＞飯店留言</a>
	</div>
	
</form>
<!-- 清單內容 -->
<div class="row" id="hotel_comm" style="display: none;">
	<div class="col-md-11">
		<textarea id="hotel_comm_text" name="hotel_comm_text" class="form-control" style="width: 100%;height: 60px;"></textarea>
	</div>
	<div class="col-md-1">
		<a href="javascript:addHotelComm()" class="btn btn-sm btn-outline-primary">新增紀錄</a>
	</div>
</div>
<table class="table table-hover" style="margin-top:10px;">
  <thead class="thead-light">
    <tr>
	      <th scope="col" style="width:10%">登載日期</th>
	      <th scope="col" style="width:10%">登載人員</th>
	      <th scope="col" style="width:80%;"><span style="position: relative;top: 7px;">協調事項</span>
				<a href="javascript:open_hotel_comm()" class="btn btn-sm btn-outline-primary pull-right" style="margin:0px;float:right !important;">新增協調紀錄</a>
	      </th>
    </tr>
  </thead>
  <tbody>
  	@foreach($Hotel_Comm as $key => $comm)
  	<tr>
  		  <th>{{$comm->updated_at->format('Y-m-d')}}</th>
  		  <td>{{$comm->write_name}}</td>
  		  <td>{{$comm->comm}}</td>
  	</tr>
  	@endforeach
	  </tbody>
</table>


@endsection
<!-- style內置區塊 -->
@section('instyle')
.input-group-text{
	background-color:#c9fcb3;
}
.input-group-custom{
	background-color:#fff3c6;
}
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
.input-group{
	padding-left: 5px;
    padding-right: 5px;
}
.row{
	margin-top: 10px;
}
@endsection
<!-- js獨立區塊腳本 -->
@section('custom_script')
//打開協調輸入欄
function open_hotel_comm(){
	$('#hotel_comm').slideToggle();
}
//新增協調紀錄
function addHotelComm(){
	$.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: '../hotel_comm_add/{{$Hotel->nokey}}',
        data: {comm:$('#hotel_comm_text').val()},
        success: function(data) {
        	sessionStorage.setItem("scroll", window.pageYOffset);
        	window.location.reload();
    	}
    });
}
//現存級別
var level_global=1;
	//版本切換
	function chg_ver(obj){
		if($(obj).val() !='-1'){
			ver_close();
			switch($(obj).val()){
				case 'A':
					$('#fees_ab').prop('disabled',false);
					$('#fees_ab_bonus').prop('disabled',false);
					break;
				case 'B':
					$('#fees_ab').prop('disabled',false);
					$('#fees_ab_bonus').prop('disabled',false);
					break;
				case 'C':
					$('#fees_c').prop('disabled',false);
					$('#fees_c_bonus').prop('disabled',false);
					break;
				case 'D':
					$('#fees_d').prop('disabled',false);
					$('#fees_d_bonus').prop('disabled',false);
					break;
				case 'G':
					$('#fees_c').prop('disabled',false);
					$('#fees_c_bonus').prop('disabled',false);
					break;
				case 'A,CA':
					$('#fees_c').prop('disabled',false);
					$('#fees_c_bonus').prop('disabled',false);
					$('#fees_ab').prop('disabled',false);
					$('#fees_ab_bonus').prop('disabled',false);
					break;
				case 'B,C':
					$('#fees_c').prop('disabled',false);
					$('#fees_c_bonus').prop('disabled',false);
					$('#fees_ab').prop('disabled',false);
					$('#fees_ab_bonus').prop('disabled',false);
					break;
				case 'BG,G':
					$('#fees_c').prop('disabled',false);
					$('#fees_c_bonus').prop('disabled',false);
					$('#fees_ab').prop('disabled',false);
					$('#fees_ab_bonus').prop('disabled',false);
					break;
				case 'D,C':
					$('#fees_c').prop('disabled',false);
					$('#fees_c_bonus').prop('disabled',false);
					$('#fees_d').prop('disabled',false);
					$('#fees_d_bonus').prop('disabled',false);
					break;
				case 'DG,G':
					$('#fees_c').prop('disabled',false);
					$('#fees_c_bonus').prop('disabled',false);
					$('#fees_d').prop('disabled',false);
					$('#fees_d_bonus').prop('disabled',false);
					break;
				case 'DA,CA':
				case 'A,CA,DA':
				case 'B,C,D':
				case 'BG,G,DG':
					$('#fees_c').prop('disabled',false);
					$('#fees_c_bonus').prop('disabled',false);
					$('#fees_d').prop('disabled',false);
					$('#fees_d_bonus').prop('disabled',false);
					$('#fees_ab').prop('disabled',false);
					$('#fees_ab_bonus').prop('disabled',false);
					break;
			}
		}else{
			ver_close();
		}
	}
	function ver_close(){
		 $('.ver_chg').prop('disabled',true);
	}
	//送出驗證
	function valid(form) {
		var contact_text='';
		
		$('.clone_contact').each(function(){
			contact_text +=$(this).val()+',';
			$('#contact_text').val(contact_text);
			//console.log(contact_text);
		});
		//
		if($('#type_scale').val()=='-1'){
			alert('飯店類型未選擇');
			return false;
		}
		if(!($('#invoice0').prop('checked') || $('#invoice1').prop('checked') || $('#invoice2').prop('checked'))){
			alert('開立發票未選擇');
			return false;
		}
		if(!($('#credit_card0').prop('checked') || $('#credit_card1').prop('checked') || $('#credit_card2').prop('checked'))){
			alert('現場刷卡項目未選擇');
			return false;
		}
		if($('#ver').val()=='-1'){
			alert('版本類型未選擇');
			return false;
		}
		if(!($('#control1').prop('checked') || $('#control2').prop('checked'))){
			alert('控管方式未選擇');
			return false;
		}
		if(!($('#checkout0').prop('checked') || $('#checkout1').prop('checked'))){
			alert('結帳方式未選擇');
			return false;
		}
		if(!($('#invoice_type0').prop('checked') || $('#invoice_type1').prop('checked') || $('#invoice_type2').prop('checked'))){
			alert('發票型態未選擇');
			return false;
		}
		if($('#cooperation').val()=='-1'){
			alert('合作種類未選擇');
			return false;
		}
		if($('#tel1').val()=='+886-'){
			alert('飯店電話未填寫');
			return false;
		}
		return true;
	}
	//飯店房間數量同步乘以10到排序值
	function room2sort(){
		count=parseInt($('#type_room').val())*10;
		$('#sort').val(count);
	}
	//飯店名稱同步SEO選項
	function name2seo(){
		seo_text=$('#name').val();
		$('#seo_title').empty().val(seo_text);
		$('#seo_keyword').empty().val(seo_text);
		$('#seo_descript').empty().val(seo_text);
	}
	//開關輸入項
	function toggleInput(objID){
		if($('#'+objID).prop('disabled')){
			$('#'+objID).prop('disabled',false);
		}else{
			$('#'+objID).prop('disabled',true);
		}
	}
	//無限增加聯絡人
	function cloneTr(obj){
		objClone =$(obj).parent().parent().clone();
		$(obj).removeAttr('onkeyup');
		objClone.find('input').val("");
		objClone.appendTo('.tg');
	}
	//切換三級選單取得郵遞區號
	function chg_zip_code(obj,target){
		$('#'+target).prop('disabled', true);
		$.ajax({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        type: "POST",
	        url: '../area_get_zipcode',
	        data: {nokey:$(obj).val()},
	        success: function(data) {
	        	$('#'+target).val("");
	        	$('#'+target).val(data[0]['zip_code']);
	        	$('#'+target).prop('disabled', false);
	    	}
	    });
	}
	// 切換選項時，level為該選項之級別值
	function chg_area(sel_obj, level){
		$("#area_level"+(level+1)).prop('disabled', true);
		$("#area_level"+(level+1)+" option").remove();
		sel_val =$(sel_obj).val();

		if(sel_val == '-1'){
			sel_val =$("#area_level"+(level-1)).val()
		}
		$.ajax({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        type: "POST",
	        url: '../area_get',
	        data: {level:sel_val},
	        success: function(data) {
	        	//填入下一級選項
	        	fill_area(data,level);
	    	}
	    });
	}
	
	//填入下級選項
	function fill_area(data, level){
		if(level <=4){
			$("#area_level"+(level+1)+" option[value!='-1']").remove();
			$("#area_level"+(level+1)).append($('<option>', {
			    value: -1,
			    text: '區域'
			}));
			if($("#area_level"+level).val() !='-1'){
				for(i=0; i< data.length; i++){
					$("#area_level"+(level+1)).append($('<option>', {
					    value: data[i]['nokey'],
					    text: data[i]['area_name']
					}));
				}
			}
			$("#area_level"+(level+1)).prop('disabled', false);
			//alert(data['1']['area_name']);
			//$("#area_level"+level+" option[value!='-1']").remove();
		}
	}
	//登錄者用
	// 切換選項時，level為該選項之級別值
	function login_chg_area(sel_obj, level){
		$("#login_area_level"+(level+1)).prop('disabled', true);
		$("#login_area_level"+(level+1)+" option").remove();
		sel_val =$(sel_obj).val();

		if(sel_val == '-1'){
			sel_val =$("#contact_area_level"+(level-1)).val()
		}
		$.ajax({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        type: "POST",
	        url: '../area_get',
	        data: {level:sel_val},
	        success: function(data) {
	        	//填入下一級選項
	        	login_fill_area(data,level);
	    	}
	    });
	}
	
	//填入下級選項
	function login_fill_area(data, level){
		if(level <=4){
			$("#login_area_level"+(level+1)+" option[value!='-1']").remove();
			$("#login_area_level"+(level+1)).append($('<option>', {
				    value: -1,
				    text: '區域'
				}));
			if($("#login_area_level"+level).val() !='-1'){
				for(i=0; i< data.length; i++){
					$("#login_area_level"+(level+1)).append($('<option>', {
					    value: data[i]['nokey'],
					    text: data[i]['area_name']
					}));
				}
			}
			$("#login_area_level"+(level+1)).prop('disabled', false);
			//alert(data['1']['area_name']);
			//$("#area_level"+level+" option[value!='-1']").remove();
		}
	}
$(window).resize(function(){
	$("body").css("margin-top",$("nav").height()+20);
});
$(window).on('load', function(){
	topObj =(window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
	//回到卷軸原本位置
	const scrollBy = sessionStorage.getItem("scroll");    
	if (scrollBy != null) {
	 //window.scrollTo(scrollBy,0);
	 topObj.scrollTop(scrollBy);
	}
});
@endsection
<!-- jQuery ready 狀態內閉包內插 -->
@section('custom_ready_script')
	//讀取登錄者地區縣市字樣
	$('#login_addr_span').html($('#login_area_level2 :checked').text()+$('#login_area_level3 :checked').text()+$('#login_addr').val());
	//讀取地區縣市字樣
	$('#area2_text').html($('#area_level2 :checked').text());
	$('#area3_text').html($('#area_level3 :checked').text());
	//預設將版本傭金項目關閉
	ver_close();
	$('#ver').change();
	//拉天花板
	$("body").css("margin-top",$("nav").height()+20);
	//停用完成跳出確認
	@if(!is_null(session()->get('controll_back_msg')))
		$('#okAlert').modal("toggle");
	@endif
@endsection