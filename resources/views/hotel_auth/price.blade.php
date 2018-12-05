@extends('hotel_auth.main_layout')

<!-- 標題 -->
@section('title', $Title)
<!-- 飯店名稱 -->
@section('hotel_name', $Hotel->name)
@section('hotel_id', $Hotel->nokey)
@section('main_fun', 1)
@section('sub_fun', 'price')

@section('content')
@if(!is_null(session()->get('controll_back_msg')))
<!-- 隱藏區塊 -->
@endif

<div style="text-align: center;font-weight: bolder;">
	<span>下面勾選項目，設定為 客滿</span> 
</div>

<div class="row" style="width: 98%;margin: auto;">
	<table class="header" style="width: 100%;text-align: center;">
    	<thead><th class="hd_tit"> <a href=""><<</a>  <a href=""><上個月</a><span class="hd_mon">  {{ substr($Period,4,2) }}月  </span><a href="">下個月></a>  <a href="">>></a> </th></thead>
    </table>
</div>
<div class="row" style="width: 98%;margin: auto;">
	<div class="scrolltable">
        <div class="body">
            <table width="100%">
                <tbody>
                <tr>
                	<td>房型</td><td>定價</td><td>人數</td>
                    @for ($i = 0; $i < $MonthDay[3+1]; $i++)
                        <td>{{$i+1}} <br/> (一) </td>
                    @endfor
                </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- main -->

@endsection

@section('instyle')
.scrolltable {
    overflow-x: scroll;
    height: 100%;
    display: flex;
    display: -webkit-flex;
    flex-direction: column;
    -webkit-flex-direction: column;
}
.scrolltable > .body {
    /*noinspection CssInvalidPropertyValue*/
    width: -webkit-fit-content;
    overflow-y: scroll;
    flex: 1;
    -webkit-flex: 1;
}
table {
    border-collapse: collapse;
}
th, td {
  border: 1px solid #bbb;
  min-width: 100px;
  padding: 8px 10px;
  text-align: center;
}
th {
    background-color: lightgrey;
    border-width: 1px;
}
td {
    border-width: 1px;
}
tr:first-child td {
    border-top-width: 0;
}
tr:nth-child(even) {
    background-color: #eee;
}
.hd_mon{
    width: 250px;
    display: inline-block;
}
.hd_tit a{
    margin: 5px;
}
@endsection

<!-- js獨立區塊腳本 -->
@section('custom_script')



@endsection

<!-- jQuery ready 狀態內閉包內插 -->
@section('custom_ready_script')



@endsection