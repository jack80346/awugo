@extends('hotel_auth.main_layout')

<!-- 標題 -->
@section('title', $Title)
<!-- 飯店名稱 -->
@section('hotel_name', $Hotel->name)
@section('hotel_id', $Hotel->nokey)
@section('main_fun', 0)
@section('sub_fun', 'main')

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
<form id="hotelForm" method="POST" role="form" action="/{{$Country}}/auth/h{{$Hotel->nokey}}/main">
    {{ csrf_field() }}
<div class="row">
    <div class="col-md-6">
        <div class="input-group input-group">
            <div class="input-group-prepend">
                <span class="input-group-text input-group-custom">飯店名稱</span>
            </div>
            <input id="name" name="name" type="text" value="{{$Hotel->name}}" class="form-control" style="color: red;">
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group input-group">
            <div class="input-group-prepend">
                <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">相關證照</span>
            </div>
            <div class="checkbox checkbox-primary" style="padding-top:5px;">
                <input id="license_hotel" name="license_hotel" type="checkbox" value="1"@if($Hotel->license_hotel==1) checked="checked" @endif>
                <label for="license_hotel">合法旅館
                </label>
            </div>
            <div class="checkbox checkbox-primary" style="padding-top:5px;">
                <input id="license_homestay" name="license_homestay" type="checkbox" value="1"@if($Hotel->license_homestay==1) checked="checked" @endif>
                <label for="license_homestay">合法民宿
                </label>
            </div>
            <div class="checkbox checkbox-primary" style="padding-top:5px;">
                <input id="license_hospitable" name="license_hospitable" type="checkbox" value="1"@if($Hotel->license_hospitable==1) checked="checked" @endif>
                <label for="license_hospitable">好客民宿
                </label>
            </div>
        </div>
    </div>
</div>
<!-- ** -->
<div class="row" style="margin-top:10px;">
    <div class="col-md-6">
        <div class="input-group input-group">
          <div class="input-group-prepend">
            <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">官方網站</span>
          </div>
          <input type="text" id="url" name="url" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{$Hotel->url}}" placeholder="輸入完整網址">
        </div>
    </div>
    <div class="input-group input-group col-md-6">
        <div class="input-group-prepend">
            <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">飯店類型</span>
        </div>
        <select class="form-control col-md-5" id="type_scale" name="type_scale">
            <option value='國際觀光飯店'@if($Hotel->type_scale=='國際觀光飯店') selected="" @endif>國際觀光飯店</option>
            <option value='商務休閒飯店'@if($Hotel->type_scale=='商務休閒飯店') selected="" @endif>商務休閒飯店</option>
            <option value='汽車旅館'@if($Hotel->type_scale=='汽車旅館') selected="" @endif>汽車旅館</option>
            <option value='民宿'@if($Hotel->type_scale=='民宿') selected="" @endif>民宿</option>
            <option value='露營'@if($Hotel->type_scale=='露營') selected="" @endif>露營</option>
            <option value='國際觀光飯店／商務休閒飯店'@if($Hotel->type_scale=='國際觀光飯店／商務休閒飯店') selected="" @endif>國際觀光飯店／商務休閒飯店</option>
            <option value='商務休閒飯店／汽車旅館'@if($Hotel->type_scale=='商務休閒飯店／汽車旅館') selected="" @endif>商務休閒飯店／汽車旅館</option>
            <option value='民宿／露營'@if($Hotel->type_scale=='民宿／露營') selected="" @endif>民宿／露營</option>
        </select>
        <div class="input-group-prepend">
            <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">飯店星級</span>
        </div>
        <select class="form-control col-md-2" id="type_level" name="type_level">
            <option value='0'@if($Hotel->type_level==0) selected="" @endif>☆</option>
            <option value='1'@if($Hotel->type_level==1) selected="" @endif>★</option>
            <option value='2'@if($Hotel->type_level==2) selected="" @endif>★★</option>
            <option value='3'@if($Hotel->type_level==3) selected="" @endif>★★★</option>
            <option value='4'@if($Hotel->type_level==4) selected="" @endif>★★★★</option>
            <option value='5'@if($Hotel->type_level==5) selected="" @endif>★★★★★</option>
        </select>
        <div class="input-group-prepend">
            <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">房間總數</span>
          </div>
          <input id="type_room" name="type_room" type="text" class="form-control col-md-1" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="" value="{{$Hotel->type_room}}">
    </div>
</div>
<!-- ** -->
<div class="row" style="margin-top:10px;">
    <div class="col-md-6">
        <div class="input-group input-group">
          <div class="input-group-prepend">
            <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">飯店地址</span>
          </div>
          <select class="form-control" id="area_level1" name="area_level1" style="display:none">
              <option value='1'>台灣</option>
          </select>
          <select class="form-control col-md-2" id="area_level2" name="area_level2" onchange="chg_area(this,2)">
              <option value='-1'>縣市</option>
              @foreach($Areas_level2 as $key => $area2)
                    <option value='{{$area2->nokey}}'@if($Hotel->area_level2==$area2->nokey) selected="" @endif>{{$area2->area_name}}</option>
              @endforeach
          </select>
          <select class="form-control col-md-2" id="area_level3" name="area_level3" onchange="chg_zip_code(this,'zip_code')">
              <option value='-1'>區域</option>
              @foreach($Addr_level3 as $key => $addr3)
                <option value='{{$addr3->nokey}}'@if($Hotel->area_level3==$addr3->nokey) selected="" @endif>{{$addr3->area_name}}</option>
              @endforeach
          </select><br/>
            <div class="input-group input-group-sm col-md-2" style="padding:0;max-width:60px;"> 
              <input id="zip_code" name="zip_code" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="郵遞區號" value="{{$Hotel->zip_code}}">
            </div>
            <!-- ** -->
            <div class="input-group input-group col-md-6" style="padding:0;">
              <input id="address" name="address" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="請輸入地址" value="{{$Hotel->address}}" onkeyup="initialize(1);" onblur="initialize(1);">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group input-group">
            <div class="input-group-prepend">
                <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">開立發票</span>
            </div>
            <div class="radio radio-inline align-middle" style="padding-top: 5px">
                <input type="radio" id="invoice0" value="0" name="invoice"@if($Hotel->invoice==0) checked="checked" @endif>
                <label for="invoice0">可</label>
            </div>
            <div class="radio radio-inline align-middle" style="padding-top: 5px">
                <input type="radio" id="invoice1" value="1" name="invoice"@if($Hotel->invoice==1) checked="checked" @endif>
                <label for="invoice1">僅開立收據</label>
            </div>
            <div class="radio radio-inline align-middle" style="padding-top: 5px">
                <input type="radio" id="invoice2" value="2" name="invoice"@if($Hotel->invoice==2) checked="checked" @endif>
                <label for="invoice2">皆無</label>
            </div>
        </div>
    </div>
</div>
<!-- ** -->
<div class="row" style="margin-top:10px;">
    <div class="col-md-6">
        <div class="input-group input-group">
          <div class="input-group-prepend">
            <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">飯店電話</span>
          </div>
          <input type="text" id="tel1" name="tel1" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{$Hotel->tel1}}" placeholder="主要電話">
          <input type="text" id="tel2" name="tel2" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{$Hotel->tel2}}" placeholder="備用電話">
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group input-group">
          <div class="input-group-prepend">
            <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">立案名稱</span>
          </div>
          <input type="text" id="reg_name" name="reg_name" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{$Hotel->reg_name}}" placeholder="立案名稱">
        </div>
    </div>
</div>
<!-- ** -->
<div class="row" style="margin-top:10px;">
    <div class="col-md-6">
        <div class="input-group input-group">
          <div class="input-group-prepend">
            <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">飯店傳真</span>
          </div>
          <input type="text" id="fax1" name="fax1" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{$Hotel->fax1}}" placeholder="主要傳真">
          <input type="text" id="fax2" name="fax2" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{$Hotel->fax2}}" placeholder="備用傳真">
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-group input-group">
          <div class="input-group-prepend">
            <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">統編或證號</span>
          </div>
          <input type="text" id="reg_no" name="reg_no" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{$Hotel->reg_no}}" placeholder="統一編號或證照號碼">
        </div>
    </div>
</div>
<!-- ** -->
<div class="row" style="margin-top:10px;">
    <div class="col-md-6">
        <div class="input-group input-group">
          <div class="input-group-prepend">
            <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">飯店信箱</span>
          </div>
          <input type="text" id="email1" name="email1" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{$Hotel->email1}}" placeholder="主要信箱">
          <input type="text" id="email2" name="email2" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" value="{{$Hotel->email2}}" placeholder="備用信箱">
        </div>
    </div>
    <div class="input-group input-group col-md-6">
        <div class="input-group-prepend">
            <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">現場刷卡</span>
        </div>
        <div class="radio radio-inline align-middle" style="padding-top: 5px">
            <input type="radio" id="credit_card0" value="0" name="credit_card"@if($Hotel->credit_card==0) checked="checked" @endif>
            <label for="credit_card0">可(一般刷卡)</label>
        </div>
        <div class="radio radio-inline align-middle" style="padding-top: 5px">
            <input type="radio" id="credit_card1" value="1" name="credit_card"@if($Hotel->credit_card==1) checked="checked" @endif>
            <label for="credit_card1">可(支援國民旅遊卡)</label>
        </div>
        <div class="radio radio-inline align-middle" style="padding-top: 5px">
            <input type="radio" id="credit_card2" value="2" name="credit_card"@if($Hotel->credit_card==2) checked="checked" @endif>
            <label for="credit_card2">皆無</label>
        </div>
    </div>
</div>
<!-- ** -->
<div class="row" style="margin-top:10px;">
    <div class="input-group input-group col-md-3" style="padding-right:0;">
      <div class="input-group-prepend">
        <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">通訊軟體</span>
      </div>
      <input id="app_line" name="app_line" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="Line" value="{{$Hotel->app_line}}">
    </div>
    <!-- ** -->
    <div class="input-group input-group-sm col-md-3">
      <input id="app_wechat" name="app_wechat" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="WeChat" value="{{$Hotel->app_wechat}}">
    </div>
    <div class="input-group input-group-sm col-md-6">
        <div class="input-group-prepend">
            <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">帳戶資訊</span>
        </div>
        <input id="bank_name" name="bank_name" type="text" class="form-control col-md-3" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="銀行名稱" value="{{$Hotel->bank_name}}">
        <input id="bank_code" name="bank_code" type="text" class="form-control col-md-2" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="代碼" value="{{$Hotel->bank_code}}">
        <input id="bank_account" name="bank_account" type="text" class="form-control col-md-4" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="帳號" value="{{$Hotel->bank_account}}">
        <input id="bank_account_name" name="bank_account_name" type="text" class="form-control col-md-3" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="戶名" value="{{$Hotel->bank_account_name}}">
    </div>
</div>
<!-- ** -->
<div class="row" style="margin-top:10px;">
    <div class="input-group input-group col-md-12">
        <div class="input-group-prepend">
            <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">飯店優點</span>
        </div>
        <input id="point" name="point" type="text" class="form-control" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="請盡量簡述扼要保持在20字內，用於協助飯店行銷文字" value="{{$Hotel->point}}">
    </div>
</div>
<!-- ** -->
<div class="row" style="margin-top:10px;">
    <div class="input-group input-group col-md-12">
        <div class="input-group-prepend">
            <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">飯店簡介</span>
        </div>
        <textarea class="form-control" id="introduction" placeholder="飯店完整介紹文案，用於協助飯店行銷文字" name="introduction" style="height: 100px;">{{$Hotel->introduction}}</textarea>
    </div>
</div>
<!-- ** -->
<div class="row" style="margin-top:10px;">
    <div class="input-group input-group col-md-12">
        <div class="input-group-prepend">
            <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">訂房須知</span>
        </div>
        <textarea class="form-control" id="notice" placeholder="" name="notice" style="height: 300px;">{{$Hotel->notice}}</textarea>
    </div>
</div>
<!-- ** -->
<div class="row" style="margin-top:10px;">
    <div class="input-group input-group col-md-12">
        <div class="input-group-prepend">
            <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">設定飯店所在位置</span>
        </div>
        <span class="form-control">請用滑鼠拖曳圖標至正確精準位置，將用於周邊資訊及房客導航</span>
        經度：<input type="text" id="mapy" name="mapy" value="{{$Hotel->mapy}}" />
        緯度：<input type="text" id="mapx" name="mapx" value="{{$Hotel->mapx}}" />
    </div>
</div>
<!-- ** -->
<div class="row" style="margin-top:10px;">
    <div id="map" style="width:98%; height:500px;margin:auto"></div>
</div>
<!-- ** -->
<div class="row" style="margin-top:10px;">
    <div class="input-group input-group col-md-12">
        <div class="input-group-prepend">
            <span class="input-group-text input-group-custom" id="inputGroup-sizing-sm">交通資訊</span>
        </div>
        <textarea class="form-control" id="traffic_info" placeholder="提供搭公共運輸交通工具之資訊.無則免填" name="traffic_info" style="height: 100px;">{{$Hotel->traffic_info}}</textarea>
    </div>
</div>
<!-- ** -->
    <button type="submit" class="btn btn-primary btn-lg btn-block" style="margin-top: 30px;">確定修改</button>
</form>
<!-- ** -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDixIeGc4BlnfXin0URu6MPkMTrnP-l33M&language=zh-TW"></script> 
@endsection

@section('instyle')

@endsection

<!-- js獨立區塊腳本 -->
@section('custom_script')

//地圖
  var map; //地图
  var markerTip ; //图标
  var markerArr = [] ;//图标展示数组
  var zoom = 17; //地图初始化缩放大小
  var markerJson = []; //marker的json对象
  var geocoder;
  var searchMarker; //搜索图标
  @if($Hotel->mapx =='')
    var sLng =0;
    var sLat =0;
  @else
    var sLng ={{$Hotel->mapx}};
    var sLat ={{$Hotel->mapy}};
  @endif
  
  function initialize(if_refresh) {
   newAddr=$("#area_level2 :selected").text()+$("#area_level3 :selected").text()+$("#address").val()+' '+$("#name").val();
   var mapCenter = new google.maps.Geocoder();
   mapCenter.geocode( { 'address': newAddr}, function(results, status) {
    if (status == 'OK') {
      if((sLng+sLat)>0 && if_refresh==null){
          map.setCenter(new google.maps.LatLng(sLat,sLng));
          sPosition ={lat:sLat, lng:sLng};
      }else{
          map.setCenter(results[0].geometry.location);
          sPosition =results[0].geometry.location;
      }
      
      var marker = new google.maps.Marker({
          map: map,
          icon: '/pic/hotel_point2.png',
          position: sPosition,     
          draggable : true,  //可拖动标记
      });
      var locat = marker.getPosition();
      document.getElementById("mapx").value =locat.lng().toFixed(6);
      document.getElementById("mapy").value =locat.lat().toFixed(6);
    }
    google.maps.event.addListener(marker, "dragend", function(event) {
      marker_change_Location(marker);
     });
  });
   var mapOptions = {
    zoom: zoom,
    center: mapCenter,
    fullscreenControl: false,
    mapTypeId: google.maps.MapTypeId.ROADMAP,
   }
   map = new google.maps.Map(document.getElementById("map"), mapOptions);
   
   geocoder = new google.maps.Geocoder();
   
   wind = new google.maps.InfoWindow({
    maxWidth: 460
   });

   return true;
  }
  
  //重新标记新的位置
  function marker_change_Location(marker){
   var locat = marker.getPosition();
   document.getElementById("mapx").value =locat.lng().toFixed(6);
   document.getElementById("mapy").value =locat.lat().toFixed(6);
   geocoder.geocode({'location' : locat},
    function(results, status) {
     if (status == google.maps.GeocoderStatus.OK) {//表示地图解析成功！
       var address = results[0].formatted_address;//邮政地址
       var idsval = results[0].geometry.location;//比较准确的地址
       //showSelectedItem(marker);//消息框
     }
    }
   );
  }
 
$(window).on('load',initialize);

//切換三級選單取得郵遞區號
function chg_zip_code(obj,target){
    $('#'+target).prop('disabled', true);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        dataType: "json",
        url: '/tw/api/getZipCode/'+$(obj).val(),
        success: function(data) {
            $('#'+target).val("");
            $('#'+target).val(data[0]['zip_code']);
            $('#'+target).prop('disabled', false);
            initialize(1);
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
        dataType: "json",
        url: '/tw/api/getArea3/'+sel_val,
        //data: {nokey:$(obj).val()},
        success: function(data) {
            //填入下一級選項
            fill_area(data,level);
            initialize(1);
            //alert(data);
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
@endsection

<!-- jQuery ready 狀態內閉包內插 -->
@section('custom_ready_script')
  $('#address').on('change', function() {
    initialize(1);
  });
//停用完成跳出確認
    @if(!is_null(session()->get('controll_back_msg')))
        $('#okAlert').modal("toggle");
    @endif
@endsection