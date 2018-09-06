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

<div class="row" style="width: 98%;margin: auto;">
	test
</div>
<!-- main -->

@endsection

@section('instyle')


@endsection

<!-- js獨立區塊腳本 -->
@section('custom_script')



@endsection

<!-- jQuery ready 狀態內閉包內插 -->
@section('custom_ready_script')



@endsection