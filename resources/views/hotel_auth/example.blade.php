@extends('hotel_auth.main_layout')

<!-- 標題 -->
@section('title', $Title)
@section('sub_fun', 'service')
@section('main_fun', 0)
<!-- 飯店名稱 -->
@section('hotel_name', $Hotel->name)

@section('content')
@if(!is_null(session()->get('controll_back_msg')))
<!-- 隱藏區塊 -->
@endif

123
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