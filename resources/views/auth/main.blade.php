@extends('auth.main_layout')

<!-- 標題 -->
@section('title', $Title)

<!-- 導航按鈕按下狀態編號 -->
@section('nav_id', $Nav_ID)
<!-- 內容 -->
@section('content')
<div class="row">
  <div class="col-sm-6">
    <div class="card">
	  <div class="card-header">
	    最新訂單
	  </div>
	  <div class="card-body">
	    <p class="card-text">...</p>
	    <a href="#" class="btn btn-secondary btn-sm float-right">完整內容</a>
	  </div>
	</div>
  </div>
  <div class="col-sm-6">
    <div class="card">
	  <div class="card-header">
	    最新留言
	  </div>
	  <div class="card-body">
	    <p class="card-text">...</p>
	    <a href="#" class="btn btn-secondary btn-sm float-right">完整內容</a>
	  </div>
	</div>
  </div>
</div>

<div class="row" style="margin-top: 10px;">
  <div class="col-sm-6">
    <div class="card">
	  <div class="card-header">
	    最新訂單
	  </div>
	  <div class="card-body">
	    <p class="card-text">...</p>
	    <a href="#" class="btn btn-secondary btn-sm float-right">完整內容</a>
	  </div>
	</div>
  </div>
  <div class="col-sm-6">
    <div class="card">
	  <div class="card-header">
	    最新留言
	  </div>
	  <div class="card-body">
	    <p class="card-text">...</p>
	    <a href="#" class="btn btn-secondary btn-sm float-right">完整內容</a>
	  </div>
	</div>
  </div>
</div>

<div class="row" style="margin-top: 10px;">
  <div class="col-sm-6">
    <div class="card">
	  <div class="card-header">
	    最新訂單
	  </div>
	  <div class="card-body">
	    <p class="card-text">...</p>
	    <a href="#" class="btn btn-secondary btn-sm float-right">完整內容</a>
	  </div>
	</div>
  </div>
  <div class="col-sm-6">
    <div class="card">
	  <div class="card-header">
	    最新留言
	  </div>
	  <div class="card-body">
	    <p class="card-text">...</p>
	    <a href="#" class="btn btn-secondary btn-sm float-right">完整內容</a>
	  </div>
	</div>
  </div>
</div>
@endsection