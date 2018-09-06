@extends('hotel_auth.main_layout')

<!-- 標題 -->
@section('title', $Title)
@section('sub_fun', 'room_set')
@section('main_fun', 0)
<!-- 飯店名稱 -->
@section('hotel_name', $Hotel->name)
@section('hotel_id', $Hotel->nokey)

@section('content')

    <div class="modal fade" id="okAlert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">套用下列範例名稱</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <ul>
                @foreach($RoomNames as $key => $name)
                  <li><a href="javascript:apply_name('{{$name->name}}')">{{$name->name}}</a></li>
                @endforeach
              </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">OK！</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="people_sel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">選擇優惠人次</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <ul id="sale_people_ckb">
                
              </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">OK！</button>
          </div>
        </div>
      </div>
    </div>



	<table width="98%" style="margin: auto;">
		<tr>
			<td width="60%" style="">
        <form action="{{$RoomSet->nokey}}" method="POST" style="width:800px;" onsubmit="return valid(this);">
          {{ csrf_field() }}
          <div class="field_div"><span class="field_title">房型名稱：</span><input type="text" value="@if($RoomSet!=null){{$RoomSet->name}}@endif" style="width:350px;color: red;" id="name" name="name">
            <a href="javascript:toggle_name()">套用</a>
            <span class="field_title" style="margin-left: 15px;">類型：</span>
            <select name="room_type" id="room_type" style="width:150px;">
              <option value="-1">請選擇類型</option>
              <option value="0"@if($RoomSet->room_type==0)selected=""@endif>客房</option>
              <option value="1"@if($RoomSet->room_type==1)selected=""@endif>背包客</option>
              <option value="2"@if($RoomSet->room_type==2)selected=""@endif>包棟</option>
              <option value="3"@if($RoomSet->room_type==3)selected=""@endif>包層</option>
              <option value="4"@if($RoomSet->room_type==4)selected=""@endif>露營</option>
            </select>
          </div>   
          <div class="field_div"><div class="field_title" style="width: 80px;
    float: left;">床型選擇：</div><div id="beds_select_clone"><select name="beds[]" id="beds" style="width:350px;">
            @foreach($Beds as $key => $bed)
              <option value="{{$bed->nokey}}">{{$bed->name}}</option>
            @endforeach
            </select>
            <span class="field_title">數量：</span>
              <select name="count[]" id="count" style="width:50px;" class="count_item">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
              </select>
          </div>
            
          </div>
          <div class="field_div" style="margin-left: 80px;">
                <ul id="bed_select" style="padding-left: 0px;">
                  
                </ul>
                <a id="addBedType" href="javascript:add_bed()" style="position:absolute;">增加床型</a>
          </div>
          <div class="field_div"><span class="field_title">標準住宿：</span><input type="text" class="num_column" onblur="chg_room_people(this)" id="min_people" name="min_people" value="@if($RoomSet!=null){{$RoomSet->min_people}}@endif">人<!--／最多<input type="text"  style="width:150px;" id="max_people" name="max_people" value="@if($RoomSet!=null){{$RoomSet->max_people}}@endif">人-->
            <div id="people_div" class="checkbox checkbox-primary" style="padding-top:5px;display: inline-block;margin-left: -10px;">
              <input type="checkbox" class="checkbox" value="1" id="sale" name="sale" style="display: none;" onchange="chg_sale(this)" @if($RoomSet->sale) checked @endif>
              <label for="sale">低於標準住宿人數<span id="room_people" style="display:none;">{{$RoomSet->min_people}}</span>.可按住宿人數遞減提供優惠價格<a id="people_sel_link" href="javascript:people_sel()" style="margin-left: 10px;">按此勾選優惠人次</a></label>
            </div>
          </div>  
          <div class="field_div" id="sale_div" style="max-height: 30px;overflow: hidden;display: none;">
            <span class="field_title">優惠人次：</span>
            <ul id="sale_people" style="list-style: none;position: relative;top: -24px;">
            </ul>
            <input type="text" name="sale_people_csv" id="sale_people_csv" style="">
          </div> 
          <div class="field_div">
            <span class="field_title">總房間數：</span><input type="text" class="num_column" id="room_count" name="room_count" value="@if($RoomSet!=null){{$RoomSet->room_count}}@endif">
            <span class="field_title">開放間數：</span><input type="text" class="num_column" id="room_open_count" name="room_open_count" value="@if($RoomSet!=null){{$RoomSet->room_open_count}}@endif">
            <span class="field_title">面積：</span><input type="text" class="num_column" id="room_area" name="room_area" value="@if($RoomSet!=null){{$RoomSet->room_area}}@endif">坪
          </div>
          <div class="field_div"><span class="field_title">房間特色：</span><input type="text" style="width:90%;color: red;" id="room_feature" name="room_feature" value="@if($RoomSet!=null){{$RoomSet->room_feature}}@endif"></div>
          <!-- 勾選 -->
          @foreach($DeviceGroup as $key => $group)
            <div class="service_item" style="margin:0px;">
              <span class="field_title" style="width: 100%;">{{$group->service_name}}：</span>
              <div class="row" style="padding-left: 100px;">
                @foreach($DeviceItem as $j => $item)
                @if($item->parent == $group->nokey)
                <div class="col-md-3 service_item" style="padding:0px;">
                  <div class="input-group">
                    <div class="checkbox checkbox-primary" style="padding-top:5px;">
                      <input onchange="check_service(this)" type="checkbox" class="checkbox" value="{{$item->nokey}}" id="service{{$item->nokey}}" name="service[]" style="display: none;" @if(in_array($item->nokey,$RoomDevice)) checked="" @endif>
                      <label for="service{{$item->nokey}}">{{$item->service_name}}</label>
                    </div>
                  </div>
                </div>
                @endif
                @endforeach
              </div>
            </div>
          @endforeach
          <!-- 勾選 -->
          <button class="btn btn-lg btn-primary btn-block" type="submit" style="width: 900px;margin: auto;position: relative;
    left: 300px;">儲存設定</button>
          </form>
      </td>
			<td width="40%" valign="top" style="">
        <div id="photo_big" name="photo_big">
          <div id="photo_focus" name="photo_focus" style="overflow: hidden;background-color: #dadada;width: 650px;height: 487px;">
            <img id="photp_view" width="650" height="487" src="/photos/room/800/@if($RoomPhotos==null){{$RoomPhotos[0]->photo}}@endif" alt="">
          </div>
          <div id="photo_opt" name="photo_opt" style="height:50px;margin-top:10px;">
            排序：<input id="photo_opt_sort" class="num_column" name="photo_opt_sort" type="text" value="@if($RoomPhotos==null){{$RoomPhotos[0]->sort}}@endif" onblur="edit_sort(this)">
            <input id="photo_opt_nokey" name="photo_opt_nokey" type="text" value="@if($RoomPhotos==null){{$RoomPhotos[0]->nokey}}@endif" style="display:none;">
            <a href="javascript:void(0)" onclick="del_photo()" style="float:right;margin-left:30px;">刪除照片</a>
            <form id="photo_form" name="photo_form" method="post" enctype="multipart/form-data" action="../room_set_upload/{{$RoomID}}" style="display: inline-block;
    float: right;">
              {{ csrf_field() }}
              <input id="photo_browser" type="file" name="room_photo" onchange="autoUpload()" style="display:none">
              <input type="button" value="上傳照片" style="margin-bottom: 10px;" onclick="openBrowser()">
            </form>
          </div>
        </div>
        <div id="photo_list" name="photo_list">
          <ul>
            @foreach($RoomPhotos as $key => $photo)
            <li><img src="/photos/room/100/{{$photo->photo}}" data-sort='{{$photo->sort}}' data-name='{{$photo->photo}}' data-id='{{$photo->nokey}}' onclick="chg_photo_info(this)" width="100" height="75"></li>
            @endforeach
          </ul>
        </div>
        <div id="photo_btn" name="photo_btn" style="text-align: right;">
          
        </div>
      </td>
		</tr>
	</table>
	
<!-- main -->

@endsection

@section('instyle')
#people_div label::before{
  display:none;
}
.num_column{
  width:40px;
}
#photo_list >ul{
  padding:0px;
}
#photo_list > ul >li{
  list-style-type: none;
  display: inline-block;
  width:85px;
  height:85px;
  overflow:hidden;
  margin: 2px;
  cursor:pointer;
}
#photo_big{
  width:650px;
}
#sale_people{
  margin-left: 40px;
}
#sale_people >li{
  list-style-type: none;
  display: inline-block;
}
#bed_select > li{
  list-style-type: none;
  margin-bottom: 5px;
}

.field_div{
  margin-bottom:10px;
}
.field_title{
  color:green;
  font-weight:bold;
}
.service_group{
	font-weight:bold;
	padding:10px;
}
.service_item{
	/*margin-left:65px;*/
}
.service_select {
	color:#E5670D;
}
@endsection

<!-- js獨立區塊腳本 -->
@section('custom_script')
//$('.checkbox :checked').parent().addClass("service_select");

//驗證表單送出
function valid(form){
  var valid_str ='';
  if($('#name').val()==''){
    valid_str +='房型名稱未填\n';
    $('#name').css('border', '2px solid red');
  }
  if($('#room_type').val()=='-1'){
    valid_str +='房型類型未選\n';
    $('#room_type').css('border', '2px solid red');
  }
  if($('#min_people').val()=='0'){
    valid_str +='標準住宿人數未輸入\n';
    $('#min_people').css('border', '2px solid red');
  }
  if($('#room_count').val()=='0'){
    valid_str +='總房間數不能為0\n';
    $('#room_count').css('border', '2px solid red');
  }
  if($('#room_open_count').val()=='0'){
    valid_str +='開放間數不能為零\n';
    $('#room_open_count').css('border', '2px solid red');
  }
  if(valid_str !=''){
    alert(valid_str);
    $('html,body').animate({ scrollTop: 0 }, 2000, 'easeOutExpo');
    return false;
  }
  if($('#sale_people_csv').val().indexOf($('#min_people').val())==-1){
    $('#sale_people_csv').val($('#sale_people_csv').val()+$('#min_people').val()+',');
  }
  //alert($('#sale_people_csv').val());
  //return false;
  return true;
}

//刪除照片
function del_photo(){
  if(confirm('確定要刪除此照片？')){
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "POST",
        url: '../room_photo_del',
        data: {nokey:$('#photo_opt_nokey').val()},
        success: function(data) {
          window.location.href='{{$RoomSet->nokey}}';
      }
    });
  }
}

//修改排序
function edit_sort(obj){
  $.ajax({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: "POST",
      url: '../room_photo_edit',
      data: {nokey:$('#photo_opt_nokey').val(),sort:$('#photo_opt_sort').val()},
      success: function(data) {
        window.location.href='{{$RoomSet->nokey}}';
    }
  });
}

//切換資訊
function chg_photo_info(obj){
  sort =$(obj).data('sort');
  nokey =$(obj).data('id');
  name =$(obj).data('name');
  $("#photo_opt_sort").val(sort);
  $("#photo_opt_nokey").val(nokey);
  $("#photp_view").attr('src','/photos/room/800/'+name);
}

//開啟上傳視窗
function openBrowser(){
  $('#photo_browser').click();
}
//自動提交上傳
function autoUpload(){
  //document.getElementById("photo_form").submit();
  $('#photo_form').submit();
}

//新增選擇床型
function add_bed(){
  $("#bed_select").append("<li>"+$("#beds_select_clone").html()+"<img src='/pic/del.png' width='16' style='cursor:pointer;' onclick='del_bed(this)'></li>");
  moveAddBed();
}

//刪除已選擇床型
function del_bed(obj){
  $(obj).parent().remove();
  /*del_val =$(obj).parent().find('input').val()+',';
  replace_text =$("#bed_csv").val().replace(del_val, '');
  $("#bed_csv").val(replace_text);*/
  moveAddBed();
}

//變化已填入人數
function chg_room_people(obj){
  $("#sale").prop("checked",false);
  $("#sale_people > li").remove();
  $("#room_people").empty().text($(obj).val());
  //
  opt_count =parseInt($("#min_people").val())-1;
  $("#sale_people_ckb").empty();
  for(;opt_count>0;opt_count--){
    $("#sale_people_ckb").append("<li><input class='ckb' onchange=\"chg_sale_people_ul(this)\" type=\"checkbox\" value=\""+ opt_count +"\">"+ opt_count +"人</li>");
  }  
}

//勾選紐切換
function chg_sale(obj){
  if($(obj).prop('checked')){
    //$("#people_sel_link").show();
    //$("#sale_div").show();
  }else{
    //$("#people_sel_link").hide();
    //$("#sale_div").hide();
  }
}

//勾選優惠人次視窗
function people_sel(){
  $('#people_sel').modal("toggle");
  opt_count =parseInt($("#min_people").val())-1;
  $("#sale_people_ckb").empty();
  for(;opt_count>0;opt_count--){
    $("#sale_people_ckb").append("<li><input class='ckb' onchange=\"chg_sale_people_ul(this)\" type=\"checkbox\" value=\""+ opt_count +"\">"+ opt_count +"人</li>");
  }  
  //還原勾選優惠人數
  @if($RoomSet->sale)
    restore_sale();
  @endif
}

//反應勾選人次sale_people_csv
function chg_sale_people_ul(obj){
  $("#sale_people").empty();
  $("#sale_people_csv").val('');
  sel_str='';
  $("#sale_people_ckb > li :checked").each(function(){
    $("#sale_people").append("<li>"+ $(this).val() +"人｜</li>");
    sel_str +=$(this).val()+',';
  });
  $("#sale_people_csv").val(sel_str);
  //
  $("#sale").prop("checked",true);
  if($(obj).prop("checked")){
    $(obj).parent().css('color','red').css('font-weight','bold');
  }else{
    $(obj).parent().css('color','black').css('font-weight','normal');
  }
  //
  if($("#sale_people_ckb > li :checked").length==0){
    $("#sale_div").hide();
  }else{
    $("#sale_div").show();
  }
}

//套用名稱(執行後關閉視窗)
function apply_name(name){
  $('#name').empty().val(name);
  $("#okAlert .close").click();
}

//打開切換名稱視窗
function toggle_name(){
  $('#okAlert').modal("toggle");
}

//判斷是否勾選，勾選變藍字
function check_service(obj){
	if($(obj).prop("checked")){
		$(obj).parent().addClass("service_select").find("span").show();
	}else{
		$(obj).parent().removeClass("service_select").find("span").hide();
	}
}

//還原勾選優惠人數
function restore_sale(){
  if(init==0){
    sale_csv ="{{substr($RoomSet->sale_people,0,-1)}}";
    sale_array =sale_csv.split(',');
    for(i=0; i<sale_array.length;i++){
    $("#sale_people_ckb > li > input").each(function(){
        if($(this).val() ==sale_array[i]){
          $(this).prop("checked",true);
          $(this).trigger("change");
        }
      });
    }
    init ++;
  }
}

//移動新增床型元素至最後一個
function moveAddBed(){
  addBedLeft =$(".count_item:last").offset().left+($("#count").width()+30);
  addBedTop =$(".count_item:last").offset().top;
  $("#addBedType").css('left',addBedLeft).css('top',addBedTop);
}

@endsection

<!-- jQuery ready 狀態內閉包內插 -->
@section('custom_ready_script')

init =0;  //初始標記

//新增床型預設位置
addBedLeft =$("#count").offset().left+($("#count").width()+25);
addBedTop =$("#count").offset().top;
$("#addBedType").css('left',addBedLeft).css('top',addBedTop);

//修正連結位置
$("#photo_list > ul > li").eq(0).find('img').click();
$('#hotel_subsys-room_set > a').attr('href','../room_set');
$('#hotel_subsys-service > a').attr('href','../service');
$('#hotel_subsys-photos > a').attr('href','../photos');
$('#hotel_subsys-main > a').attr('href','../main');
$('#logout_btn').attr('href','/tw/auth/h{{$Hotel->nokey}}');
$('#hotel_profile > a').attr('href','../main');
$('#room_price > a').attr('href','../price');

//還原勾選優惠人數
@if($RoomSet->sale)
  sale_csv ="{{substr($RoomSet->sale_people,0,-1)}}";
  sale_array =sale_csv.split(',');
  $("#people_sel_link").show();
  $("#sale_div").show();
  for(i=0; i<sale_array.length;i++){
    if(sale_array[i] != $("#min_people").val()){
      $("#sale_people").append("<li>"+ sale_array[i] +"人｜</li>");
    }
  }
  $("#sale_people_csv").val(sale_csv+',');
@endif
//還原選擇床型
@foreach($Beds_Type as $key => $bed)
  @if($key !=0)
$("#bed_select").append("<li>"+$("#beds_select_clone").html()+"<img src='/pic/del.png' width='16' style='cursor:pointer;' onclick='del_bed(this)'></li>");
  @endif
@endforeach
//移動新增床型位置
moveAddBed();
@foreach($Beds_Type as $key => $bed)
//還原設定值
$("#bed_select li").eq({{$key-1}}).find('select option[value={{$bed->bed_id}}]').attr('selected','selected');
$("#bed_select li").eq({{$key-1}}).find('#count option[value={{$bed->count}}]').attr('selected','selected');
@endforeach
//還原第一組床型
$("#beds_select_clone").find('select option[value={{$Beds_Type[0]->bed_id}}]').attr('selected','selected');
$("#beds_select_clone").find('#count option[value={{$Beds_Type[0]->count}}]').attr('selected','selected');


//將已勾選的設施服務加上藍字
$(".service_item > .input-group > .checkbox > input:checkbox:checked").parent().addClass("service_select").find("span").show();


//啟動lightbox效果
$(".fancybox").fancybox({
	'width': 850,
    'height': 250,
    'transitionIn': 'elastic', // this option is for v1.3.4
    'transitionOut': 'elastic', // this option is for v1.3.4
    // if using v2.x AND set class fancybox.iframe, you may not need this
    'type': 'iframe',
    // if you want your iframe always will be 600x250 regardless the viewport size
    'fitToView' : false,  // use autoScale for v1.3.4
    afterClose  : function() { 
    	//關閉後自動重整
        //window.location.reload();
    }
});
//停用完成跳出確認
    @if(!is_null(session()->get('controll_back_msg')))
        $('#okAlert').modal("toggle");
    @endif
@endsection