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
	        <h5 class="modal-title" id="exampleModalLabel">新增完成</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        已新增一筆
	      </div>
	      <div class="modal-footer">
	        <a href="hotel_list" class="btn btn-secondary" data-dismiss="modal">返回列表</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!--  -->
	<script type="text/javascript">window.location.href='hotel_list';</script>
@endif

<form method="POST" role="form" action="/{{$Country}}/auth/manager/hotel_add" onsubmit="return valid(this);">
	{{ csrf_field() }}
	<div class="row">
		<div class="input-group input-group-sm col-md-6" id="name_wrap">
		  <div class="input-group-prepend">
		    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">飯店名稱</span>
		  </div>
		  <input id="name" name="name" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" style="color:red;" onkeyup="name2seo()">
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-3" style="max-width: 312px;" id="ver_wrap">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="inputGroup-sizing-sm">版本</span>
		  </div>
		  <select class="form-control" id="ver" name="ver" style="max-width: 200px;" onchange="chg_ver(this)">
		  	  <option value='-1'>選擇版本</option>
			  <option value='A'>A</option>
			  <option value='B'>B</option>
			  <option value='C'>C</option>
			  <option value='D'>D</option>
			  <option value='G'>G</option>
			  <option value='A,CA'>A,CA</option>
			  <option value='B,C'>B,C</option>
			  <option value='BG,G'>BG,G</option>
			  <option value='D,C'>D,C</option>
			  <option value='DG,G'>DG,G</option>
			  <option value='DA,CA'>DA,CA</option>
			  <option value='A,CA,DA'>A,CA,DA</option>
			  <option value='B,C,D'>B,C,D</option>
			  <option value='BG,G,DG'>BG,G,DG</option>
		  </select>
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-3">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="inputGroup-sizing-sm">狀態</span>
		  </div>
		  <div class="radio radio-inline">
		        <input type="radio" id="state0" value="0" name="state">
		        <label for="state0">上線</label>
		  </div>
		  <div class="radio radio-inline">
		        <input type="radio" id="state1" value="1" name="state" checked="checked">
		        <label for="state1">下線</label>
		  </div>
		  <div class="radio radio-inline">
		        <input type="radio" id="state2" value="2" name="state">
		        <label for="state2">關閉</label>
		  </div>
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<div class="input-group input-group-sm col-md-6">
		  <div class="input-group-prepend">
		    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">官方網站</span>
		  </div>
		  <input type="text" id="url" name="url" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="輸入完整網址">
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-3" style="max-width: 312px;">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="inputGroup-sizing-sm">訂金</span>
		  </div>
		  <input type="text" id="deposit" name="deposit" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" style="max-width: 200px;" value="0">%
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-3" id="control_wrap">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="inputGroup-sizing-sm">控管</span>
		  </div>
		  <div class="radio radio-inline">
		        <input type="radio" id="control1" value="0" name="control">
		        <label for="control1">立即訂房</label>
		  </div>
		  <div class="radio radio-inline">
		        <input type="radio" id="control2" value="1" name="control">
		        <label for="control2">客服訂房</label>
		  </div>
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<table width="100%">
		  <tr>
		    <th width="50%">
		    	<div class="input-group input-group-sm" id="address_wrap">
					  <div class="input-group-prepend">
					    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">飯店地址</span>
					  </div>
					  <select class="form-control" id="area_level1" name="area_level1" style="display:none">
						  <option value='1'>台灣</option>
					  </select>
					  <select class="form-control" id="area_level2" name="area_level2" onchange="chg_area(this,2)">
						  <option value='-1'>縣市</option>
						  @foreach($Areas_level2 as $key => $area2)
								<option value='{{$area2->nokey}}'>{{$area2->area_name}}</option>
						  @endforeach
					  </select>
					  <select class="form-control" id="area_level3" name="area_level3" onchange="chg_zip_code(this,'zip_code')">
						  <option value='-1'>區域</option>
					  </select><br/>
					  	<div class="input-group input-group-sm col-md-2"> 
						  <input id="zip_code" name="zip_code" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="郵遞區號">
						</div>
						<!-- ** -->
					  	<div class="input-group input-group-sm col-md-6">
						  <input id="address" name="address" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="請輸入地址">
						</div>
				</div>
		    </th>
		    <th rowspan="4" style="background-color: #c9fcb3;width: 5%;text-align: center;">手續費</th>
		    <td>
		    	<div class="row" style="padding-left: 15px;">
					<div class="input-group input-group-sm col-md-4">
					  <div class="input-group-prepend">
					    <span class="input-group-text" id="inputGroup-sizing-sm">C版</span>
					  </div>
					  <input id="fees_c" name="fees_c" type="text" class="form-control ver_chg" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="0">%
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-4" style="padding-left: 15px;">
					  <div class="input-group-prepend">
					    <span class="input-group-text" id="inputGroup-sizing-sm">紅利</span>
					  </div>
					  <input id="fees_c_bonus" name="fees_c_bonus" type="text" class="form-control ver_chg" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="0">%
					</div>
				</div>
		    </td>
		  </tr>
		  <tr>
		    <td>
		    	<div class="row" style="margin-right: 0px;margin-left:0px;" id="tel1_wrap">
			    	<div class="input-group input-group-sm col-md-6">
					  <div class="input-group-prepend">
					    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">飯店電話</span>
					  </div>
					  <input id="tel1" name="tel1" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="+886-">
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-6">
					  <div class="input-group-prepend">
					    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">備用電話</span>
					  </div>
					  <input id="tel2" name="tel2" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="+886-">
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
					  <input id="fees_ab" name="fees_ab" type="text" class="form-control ver_chg" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="0">%
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-4" style="padding-left: 15px;">
					  <div class="input-group-prepend">
					    <span class="input-group-text" id="inputGroup-sizing-sm">紅利</span>
					  </div>
					  <input id="fees_ab_bonus" name="fees_ab_bonus" type="text" class="form-control ver_chg" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="0">%
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
					  <input id="fax1" name="fax1" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="+886-">
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-6">
					  <div class="input-group-prepend">
					    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">備用傳真</span>
					  </div>
					  <input id="fax2" name="fax2" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="+886-">
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
					  <input id="fees_d" name="fees_d" type="text" class="form-control ver_chg" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="0">%
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-4" style="padding-left: 15px;">
					  <div class="input-group-prepend">
					    <span class="input-group-text" id="inputGroup-sizing-sm">紅利</span>
					  </div>
					  <input id="fees_d_bonus" name="fees_d_bonus" type="text" class="form-control ver_chg" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="0">%
					</div>
				</div>
				<!-- ** -->
		    </td>
		  </tr>
		  <tr>
		    <td>
		    	<!-- ** -->
		    	<div class="row" style="padding-left: 15px;">
		    		<div class="checkbox checkbox-primary">
	                    <input id="fees_sale_state" name="fees_sale_state" type="checkbox" value="1" onclick="toggleInput('fees_sale_bonus')">
	                    <label for="fees_sale_state">
	                    </label>
	                </div>
					<div class="input-group input-group-sm col-md-4">
					  <div class="input-group-prepend">
					    <span class="input-group-text" id="inputGroup-sizing-sm">經銷紅利</span>
					  </div>
					  <input id="fees_sale_bonus" name="fees_sale_bonus" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="0" disabled="">%
					</div>
					<!-- ** -->
					<div class="checkbox checkbox-primary">
	                    <input id="fees_roll_state" name="fees_roll_state" type="checkbox" value="1" onclick="toggleInput('fees_roll_bonus')">
	                    <label for="fees_roll_state">
	                    </label>
	                </div>
					<div class="input-group input-group-sm col-md-4" style="padding-left: 15px;">
					  <div class="input-group-prepend">
					    <span class="input-group-text" id="inputGroup-sizing-sm">住宿紅利</span>
					  </div>
					  <input id="fees_roll_bonus" name="fees_roll_bonus" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="0" disabled="">%
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
		  <div class="input-group-prepend">
		    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">主要信箱</span>
		  </div>
		  <input id="email1" name="email1" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-3">
		  <div class="input-group-prepend">
		    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">備用信箱</span>
		  </div>
		  <input id="email2" name="email2" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm">
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-2" id="cooperation_wrap">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="inputGroup-sizing-sm">合作種類</span>
		  </div>
		  <select class="form-control" id="cooperation" name="cooperation" style="max-width: 200px;">
		  	  <option value='-1'>選擇合作種類</option>
			  <option value='合約' selected="">合約</option>
			  <option value='住宿卷'>住宿卷</option>
			  <option value='約卷'>約卷</option>
		  </select>
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-4" id="cooperation_wrap">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="inputGroup-sizing-sm">連假房價</span>
		  </div>
		  <div class="radio radio-inline align-middle">
				<input type="radio" id="holiday0" value="0" name="holiday" checked="">
				<label for="holiday0">未設</label>
			</div>
			<div class="radio radio-inline align-middle">
				<input type="radio" id="holiday1" value="1" name="holiday">
				<label for="holiday1">比照週六房價</label>
			</div>
			<div class="radio radio-inline align-middle">
				<input type="radio" id="holiday2" value="2" name="holiday">
				<label for="holiday2">高於周六房價</label>
			</div>
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<div class="input-group input-group-sm col-md-3">
		  <div class="input-group-prepend">
		    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">通訊軟體</span>
		  </div>
		  <input id="app_line" name="app_line" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="Line">
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-3">
		  <input id="app_wechat" name="app_wechat" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="WeChat">
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-3" style="max-width: 312px;" id="checkout_wrap">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="inputGroup-sizing-sm">結帳方式</span>
		  </div>
		  <div class="radio radio-inline align-middle">
		        <input type="radio" id="checkout0" value="0" name="checkout">
		        <label for="checkout0">日結</label>
		  </div>
		  <div class="radio radio-inline align-middle">
		        <input type="radio" id="checkout1" value="1" name="checkout">
		        <label for="checkout1">月結</label>
		  </div>
		</div>
		<div class="input-group input-group-sm col-md-2">
			  <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">訂房起始日</span>
			  </div>
			  <input id="booking_day" name="booking_day" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="" value="0">日
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<div class="input-group input-group-sm col-md-6">
		  	<div class="input-group-prepend">
		    	<span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">相關證照</span>
		  	</div>
		  	<div class="checkbox checkbox-primary">
		        <input id="license_hotel" name="license_hotel" type="checkbox" value="1">
		        <label for="license_hotel">合法旅館
		        </label>
		  	</div>
		  	<div class="checkbox checkbox-primary">
		        <input id="license_homestay" name="license_homestay" type="checkbox" value="1">
		        <label for="license_homestay">合法民宿
		        </label>
		  	</div>
		  	<div class="checkbox checkbox-primary">
		        <input id="license_hospitable" name="license_hospitable" type="checkbox" value="1">
		        <label for="license_hospitable">好客民宿
		        </label>
		  	</div>
		  	<div class="checkbox checkbox-primary">
		        <input id="illegal_homestay" name="illegal_homestay" type="checkbox" value="1">
		        <label for="illegal_homestay">非法旅宿
		        </label>
		  	</div>
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-3" style="max-width: 312px;" id="invoice_type_wrap">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="inputGroup-sizing-sm">發票型態</span>
		  </div>
		  <div class="radio radio-inline align-middle">
		        <input type="radio" id="invoice_type0" value="0" name="invoice_type">
		        <label for="invoice_type0">甲</label>
		  </div>
		  <div class="radio radio-inline align-middle">
		        <input type="radio" id="invoice_type1" value="1" name="invoice_type">
		        <label for="invoice_type1">乙</label>
		  </div>
		  <div class="radio radio-inline align-middle">
		        <input type="radio" id="invoice_type2" value="2" name="invoice_type">
		        <label for="invoice_type2">丙</label>
		  </div>
		</div>
		<div class="input-group input-group-sm col-md-3">
			  <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">配合度</span>
			  </div>
			  <div class="radio radio-inline align-middle">
			        <input type="radio" id="coordinate1" value="0" name="coordinate">
			        <label for="coordinate1">佳</label>
			  </div>
			  <div class="radio radio-inline align-middle">
			        <input type="radio" id="coordinate2" value="1" name="coordinate" checked="">
			        <label for="coordinate2">普通</label>
			  </div>
			  <div class="radio radio-inline align-middle">
			        <input type="radio" id="coordinate3" value="2" name="coordinate">
			        <label for="coordinate3">差</label>
			  </div>
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<div class="input-group input-group-sm col-md-6" id="type_scale_wrap">
		  	<div class="input-group-prepend">
		    	<span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">飯店類型</span>
		  	</div>
		  	<select class="form-control col-md-5" id="type_scale" name="type_scale">
		  		<option value='-1'>選擇飯店類型</option>
			  	<option value='國際觀光飯店'>國際觀光飯店</option>
			  	<option value='商務休閒飯店'>商務休閒飯店</option>
			  	<option value='汽車旅館'>汽車旅館</option>
			  	<option value='民宿'>民宿</option>
			  	<option value='露營'>露營</option>
			  	<option value='國際觀光飯店／商務休閒飯店'>國際觀光飯店／商務休閒飯店</option>
			  	<option value='商務休閒飯店／汽車旅館'>商務休閒飯店／汽車旅館</option>
			  	<option value='民宿／露營'>民宿／露營</option>
		    </select>
		  	<div class="input-group-prepend">
		    	<span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">飯店星級</span>
		  	</div>
		  	<select class="form-control col-md-2" id="type_level" name="type_level">
			  	<option value='0'>☆</option>
			  	<option value='1'>★</option>
			  	<option value='2'>★★</option>
			  	<option value='3'>★★★</option>
			  	<option value='4'>★★★★</option>
			  	<option value='5'>★★★★★</option>
		    </select>
		    <div class="input-group-prepend">
			    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">房間總數</span>
			</div>
			<input id="type_room" name="type_room" type="text" class="form-control col-md-1" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="" value="1" onkeyup="room2sort()" >
			<div class="input-group-prepend">
			    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">排序</span>
			</div>
			<input id="sort" name="sort" type="text" class="form-control col-md-1" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="" value="0">
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="inputGroup-sizing-sm">追蹤管理</span>
		  </div>
		  <div class="radio radio-inline align-middle">
		        <input type="radio" id="track0" value="0" name="track" checked="">
		        <label for="track0">不追蹤</label>
		  </div>
		  <div class="radio radio-inline align-middle">
		        <input type="radio" id="track1" value="1" name="track">
		        <label for="track1">追蹤</label>
		  </div>
		  <input id="track_comm" name="track_comm" type="text" class="form-control col-md-6" placeholder="追蹤事由" style="margin-left: 10px;">
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<div class="input-group input-group-sm col-md-6" id="invoice_wrap">
		    <div class="input-group-prepend">
			    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">開立發票</span>
			</div>
			<div class="radio radio-inline align-middle">
			    <input type="radio" id="invoice0" value="0" name="invoice">
			    <label for="invoice0">可</label>
			</div>
			<div class="radio radio-inline align-middle">
			    <input type="radio" id="invoice1" value="1" name="invoice">
			    <label for="invoice1">僅開立收據</label>
			</div>
			<div class="radio radio-inline align-middle">
			    <input type="radio" id="invoice2" value="2" name="invoice">
			    <label for="invoice2">皆無</label>
			</div>
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="inputGroup-sizing-sm">警察單位</span>
		  </div>
		  <div class="radio radio-inline align-middle">
		        <input type="radio" id="local_police0" value="0" name="local_police" checked="">
		        <label for="local_police0">不顯示</label>
		  </div>
		  <div class="radio radio-inline align-middle">
		        <input type="radio" id="local_police1" value="1" name="local_police">
		        <label for="local_police1">顯示</label>
		  </div>
		  <input id="local_police_comm" name="local_police_comm" type="text" class="form-control col-md-6" placeholder="當地警察單位與聯繫方式" style="margin-left: 10px;">
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">立案名稱</span>
			</div>
			<input id="reg_name" name="reg_name" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="" value="">
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">SEO標題</span>
			  </div>
			  <input id="seo_title" name="seo_title" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="" value="">
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">統一編號</span>
			</div>
			<input id="reg_no" name="reg_no" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="" value="">
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">SEO描述</span>
			  </div>
			  <input id="seo_descript" name="seo_descript" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="" value="">
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<div class="input-group input-group-sm col-md-6" id="credit_card_wrap">
		    <div class="input-group-prepend">
			    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">現場刷卡</span>
			</div>
			<div class="radio radio-inline align-middle">
			    <input type="radio" id="credit_card0" value="0" name="credit_card">
			    <label for="credit_card0">可(一般刷卡)</label>
			</div>
			<div class="radio radio-inline align-middle">
			    <input type="radio" id="credit_card1" value="1" name="credit_card">
			    <label for="credit_card1">可(支援國民旅遊卡)</label>
			</div>
			<div class="radio radio-inline align-middle">
			    <input type="radio" id="credit_card2" value="2" name="credit_card">
			    <label for="credit_card2">皆無</label>
			</div>
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">SEO關鍵字</span>
			  </div>
			  <input id="seo_keyword" name="seo_keyword" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="" value="">
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">帳戶資訊</span>
			</div>
			<input id="bank_name" name="bank_name" type="text" class="form-control col-md-3" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="銀行名稱" value="">
			<input id="bank_code" name="bank_code" type="text" class="form-control col-md-2" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="代碼" value="">
			<input id="bank_account" name="bank_account" type="text" class="form-control col-md-4" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="帳號" value="">
			<input id="bank_account_name" name="bank_account_name" type="text" class="form-control col-md-3" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="戶名" value="">
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6" id="display_tel_wrap">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">前台電話</span>
			</div>
			<div class="radio radio-inline align-middle">
				<input type="radio" id="display_tel0" value="0" name="display_tel">
				<label for="display_tel0">不顯示</label>
			</div>
			<div class="radio radio-inline align-middle">
				<input type="radio" id="display_tel1" value="1" name="display_tel">
				<label for="display_tel1">顯示飯店電話</label>
			</div>
			<div class="radio radio-inline align-middle">
				<input type="radio" id="display_tel2" value="2" name="display_tel" checked="">
				<label for="display_tel2">顯示awugo電話</label>
			</div>
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<div class="input-group input-group-sm col-md-6">
			<div class="input-group-prepend">
			    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">飯店優點</span>
			</div>
			<input id="point" name="point" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="" value="">
		</div>
		
	</div>
	<!-- ** -->
	<div class="row" style="margin-top:30px;">
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
		  <tr id="contact_row">
		    <td style="height:45px;">
		    	<input type="text" class="form-control clone_contact" id="contact_name" name="contact_name" placeholder="請輸入姓名" value="" onkeyup="cloneTr(this)" onpaste="cloneTr(this)">
		    </td>
		    <td style="height:45px;">
		    	<input type="text" class="form-control clone_contact" id="contact_job" name="contact_job" placeholder="請輸入職稱" value="">
		    </td>
		    <td style="height:45px;">
		    	<input type="text" class="form-control clone_contact" id="contact_tel" name="contact_tel" placeholder="請輸入電話" value="+886-">
		    </td>
		    <td style="height:45px;">
		    	<input type="text" class="form-control clone_contact" id="contact_mobile" name="contact_mobile" placeholder="請輸入手機" value="+886-">
		    </td>
		    <td style="height:45px;">
		    	<input type="text" class="form-control clone_contact" id="contact_line" name="contact_line" placeholder="請輸入LineID" value="">
		    </td>
		    <td style="height:45px;">
		    	<input type="text" class="form-control clone_contact" id="contact_wechat" name="contact_wechat" placeholder="請輸入微信" value="">
		    </td>
		    <td style="height:45px;">
		    	<input type="text" class="form-control clone_contact" id="contact_email" name="contact_email" placeholder="請輸入信箱" value="">
		    </td>
		  </tr>
		</table>
		<textarea id="contact_text" name="contact_text" style="width: 500px;height: 600px;display:none;"></textarea>
	</div>
	<!-- ** -->
	<div class="row">
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">後台網址</span>
			</div>
			<input type="text" class="form-control" id="manage_url" name="manage_url" placeholder="" value="">
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">後台簡址</span>
			</div>
			<input type="text" class="form-control" id="manage_surl" name="manage_surl" placeholder="" value="">
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">C版網址</span>
			</div>
			<input type="text" class="form-control" id="c_url" name="c_url" placeholder="" value="">
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">C版簡址</span>
			</div>
			<input type="text" class="form-control" id="c_surl" name="c_surl" placeholder="" value="">
		</div>
	</div>
	<!-- ** -->
	<div class="row">
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">D版網址</span>
			</div>
			<div class="checkbox checkbox-primary">
	            <input id="d_enable" name="d_enable" type="checkbox" value="1">
	            <label for="d_enable">
	            	啟用
	            </label>
	        </div>
			<input type="text" class="form-control" id="d_url" name="d_url" placeholder="" value="">
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">D版簡址</span>
			</div>
			<input type="text" class="form-control" id="d_surl" name="d_surl" placeholder="" value="">
		</div>
		
	</div>
	<!-- ** -->
	<div class="row">
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">AB版網址</span>
			</div>
			<input type="text" class="form-control" id="ab_url" name="ab_url" placeholder="" value="">
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">D版顯示電話</span>
			</div>
			<div class="radio radio-inline align-middle">
				<input type="radio" id="d_display_tel0" value="0" name="d_display_tel" checked="">
				<label for="d_display_tel0">不顯示</label>
			</div>
			<div class="radio radio-inline align-middle">
				<input type="radio" id="d_display_tel1" value="1" name="d_display_tel">
				<label for="d_display_tel1">顯示飯店電話</label>
			</div>
			<div class="radio radio-inline align-middle">
				<input type="radio" id="d_display_tel2" value="2" name="d_display_tel">
				<label for="d_display_tel2">顯示awugo電話</label>
			</div>
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
						<input type="text" class="form-control" id="login_name" name="login_name" placeholder="" value="">
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-2">
					    <div class="input-group-prepend">
						    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">所屬公司</span>
						</div>
						<input type="text" class="form-control" id="login_com" name="login_com" placeholder="" value="">
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-2">
					    <div class="input-group-prepend">
						    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">部門或職稱</span>
						</div>
						<input type="text" class="form-control" id="login_job" name="login_job" placeholder="" value="">
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-5">
					    <div class="input-group-prepend">
						    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">公司地址</span>
						</div>
						<select class="form-control col-md-2" id="login_area_level1" name="login_area_level1" style="display:none">
						  	<option value='1'>台灣</option>
					  	</select>
					  	<select class="form-control col-md-2" id="login_area_level2" name="login_area_level2" onchange="login_chg_area(this,2)">
						  	<option value='-1'>縣市</option>
						  	@foreach($Areas_level2 as $key => $area2)
								<option value='{{$area2->nokey}}'>{{$area2->area_name}}</option>
						  	@endforeach
					  	</select>
					  	<select class="form-control col-md-2" id="login_area_level3" name="login_area_level3">
							<option value='-1'>區域</option>
						</select>
						<input type="text" class="form-control col-md-8" id="login_addr" name="login_addr" placeholder="請輸入地址" value="">
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
						<input type="text" class="form-control" id="login_tel" name="login_tel" placeholder="" value="+886-">
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-2">
					    <div class="input-group-prepend">
						    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">聯絡手機</span>
						</div>
						<input type="text" class="form-control" id="login_mobile" name="login_mobile" placeholder="" value="+886-">
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-2">
					    <div class="input-group-prepend">
						    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">信箱</span>
						</div>
						<input type="text" class="form-control" id="login_email" name="login_email" placeholder="" value="">
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-2">
					    <div class="input-group-prepend">
						    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">帳號</span>
						</div>
						<input type="text" class="form-control" id="login_id" name="login_id" placeholder="" value="">
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-2">
					    <div class="input-group-prepend">
						    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">密碼</span>
						</div>
						<input type="password" class="form-control" id="login_passwd" name="login_passwd" placeholder="" value="">
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
						<div class="radio radio-inline">
						    <input type="radio" id="login_is_group0" value="0" name="login_is_group" checked="">
						    <label for="login_is_group0">否</label>
						</div>
						<div class="radio radio-inline">
						    <input type="radio" id="login_is_group1" value="1" name="login_is_group">
						    <label for="login_is_group1">是</label>
						</div>
						<input type="text" class="form-control" id="login_group_name" name="login_group_name" placeholder="集團名稱" value="">與
						<input type="text" class="form-control" id="login_group_url" name="login_group_url" placeholder="輸入完整網址" value="">
					</div>
					<!-- ** -->
					<div class="input-group input-group-sm col-md-6">
					    <div class="input-group-prepend">
						    <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">申請合作家數</span>
						</div>
						<div class="radio radio-inline">
						    <input type="radio" id="login_group_count0" value="0" name="login_group_count" checked="">
						    <label for="login_group_count0">一家</label>
						</div>
						<div class="radio radio-inline">
						    <input type="radio" id="login_group_count1" value="1" name="login_group_count">
						    <label for="login_group_count1">多家</label>
						</div>
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
			<input type="text" class="form-control" id="expire" name="expire" placeholder="" value="">
		</div>
		<div class="input-group input-group-sm col-md-3" id="contract_no_wrap">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">合約編號</span>
			</div>
			<input type="text" class="form-control" id="contract_no" name="contract_no" placeholder="" value="">
		</div>
		<!-- ** -->
		<div class="input-group input-group-sm col-md-6">
		    <div class="input-group-prepend">
			    <span class="input-group-text" id="inputGroup-sizing-sm">瀏覽人數</span>
			</div>
			<span class="form-control">今日:0　昨日:0　前日:0　總計:0</span>
		</div>
	</div>
	<!-- ** -->
	<button type="submit" class="btn btn-secondary btn-lg btn-block" style="margin-top: 30px;">新增飯店</button>
</form>

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
		var valid_arr_id = new Array();
		var valid_arr_msg = new Array();
		
		$('.clone_contact').each(function(){
			contact_text +=$(this).val()+',';
			$('#contact_text').val(contact_text);
			//console.log(contact_text);
		});
		//
		if($('#name').val()==''){
			valid_arr_msg.push('飯店名稱未填寫');
			valid_arr_id.push('name_wrap');
		}
		if($('#area_level2 :selected').val()=='-1'){
			valid_arr_msg.push('飯店地址縣市未選擇');
			valid_arr_id.push('address_wrap');
		}
		if($('#area_level3 :selected').val()=='-1'){
			valid_arr_msg.push('飯店地址區域未選擇');
			valid_arr_id.push('address_wrap');
		}
		if($('#address').val()==''){
			valid_arr_msg.push('飯店地址未填寫');
			valid_arr_id.push('address_wrap');
		}
		if($('#type_scale').val()=='-1'){
			valid_arr_msg.push('飯店類型未選擇');
			valid_arr_id.push('type_scale_wrap');
		}
		if(!($('#invoice0').prop('checked') || $('#invoice1').prop('checked') || $('#invoice2').prop('checked'))){
			valid_arr_msg.push('開立發票未選擇');
			valid_arr_id.push('invoice_wrap');
		}
		if(!($('#credit_card0').prop('checked') || $('#credit_card1').prop('checked') || $('#credit_card2').prop('checked'))){
			valid_arr_msg.push('現場刷卡項目未選擇');
			valid_arr_id.push('credit_card_wrap');
		}
		if($('#ver').val()=='-1'){
			valid_arr_msg.push('版本類型未選擇');
			valid_arr_id.push('ver_wrap');
		}
		if(!($('#control1').prop('checked') || $('#control2').prop('checked'))){
			valid_arr_msg.push('控管方式未選擇');
			valid_arr_id.push('control_wrap');
		}
		if(!($('#checkout0').prop('checked') || $('#checkout1').prop('checked'))){
			valid_arr_msg.push('結帳方式未選擇');
			valid_arr_id.push('checkout_wrap');
		}
		if(!($('#invoice_type0').prop('checked') || $('#invoice_type1').prop('checked') || $('#invoice_type2').prop('checked'))){
			valid_arr_msg.push('發票型態未選擇');
			valid_arr_id.push('invoice_type_wrap');
		}
		if(!($('#display_tel0').prop('checked') || $('#display_tel1').prop('checked') || $('#display_tel2').prop('checked'))){
			valid_arr_msg.push('前台電話未選擇');
			valid_arr_id.push('display_tel_wrap');
		}
		if($('#cooperation').val()=='-1'){
			valid_arr_msg.push('合作種類未選擇');
			valid_arr_id.push('cooperation_wrap');
		}
		if($('#tel1').val()=='+886-'){
			valid_arr_msg.push('飯店電話未填寫');
			valid_arr_id.push('tel1_wrap');
		}
		if($('#contract_no').val()==''){
			valid_arr_msg.push('合約編號未填寫');
			valid_arr_id.push('contract_no_wrap');
		}

		//判斷是否有驗證錯誤訊息
		if((valid_arr_msg.length+valid_arr_id.length) >0){
			alert_msg ='';
			$.each(valid_arr_msg, function(key,val){
				alert_msg +=val+'\n'; 
			});
			alert(alert_msg);
			//
			$.each(valid_arr_id, function(key,val){
				$('#'+val).css('border', '2px solid red');
			});
			$('html,body').animate({ scrollTop: 0 }, 2000, 'easeOutExpo');
			return false;
		}
		if(confirm('確定要新增嗎？')){
			return true;
		}else{
			return false;
		}
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
		<!-- alert(1); -->
	}
	//開關輸入項
	function toggleInput(objID){
		if($('#'+objID).prop('disabled')){
			$('#'+objID).prop('disabled',false);
			//C版開關
			if(objID =='fees_sale_bonus'){
				$('#fees_c_bonus').val('0').prop('disabled',true);
				$('#fees_c').val('0').prop('disabled',true);
			}
		}else{
			$('#'+objID).prop('disabled',true);
			//C版開關
			if(objID =='fees_sale_bonus'){
				$('#fees_c_bonus').val('0').prop('disabled',false);
				$('#fees_c').val('0').prop('disabled',false);
			}
		}
	}
	//無限增加聯絡人
	function cloneTr(obj){
		objClone =$(obj).parent().parent().clone();
		objClone.find('input').val("");
		objClone.children().find('#contact_tel').val('+886-');
		objClone.children().find('#contact_mobile').val('+886-');
		objClone.appendTo('.tg');
		$(obj).removeAttr('onkeyup');
		$(obj).removeAttr('onpaste');
	}
	//切換三級選單取得郵遞區號
	function chg_zip_code(obj,target){
		$('#'+target).prop('disabled', true);
		$.ajax({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        },
	        type: "POST",
	        url: 'area_get_zipcode',
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
	        url: 'area_get',
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
	        url: 'area_get',
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
			//$("#login_area_level"+(level+1)+" option[value!='-1']").remove();
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
@endsection
<!-- jQuery ready 狀態內閉包內插 -->
@section('custom_ready_script')
	//綁定貼上 fix IE11滑鼠貼上無效問題
	$('#name').bind('paste',function(){
		setTimeout(function(){ name2seo(); }, 300);
		//setTimeout(alert(1), 4);
	});
	//預設將版本傭金項目關閉
	ver_close();
	//拉天花板
	$("body").css("margin-top",$("nav").height()+20);
	//停用完成跳出確認
	@if(!is_null(session()->get('controll_back_msg')))
		$('#okAlert').modal("toggle");
	@endif
@endsection