<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//if(strrpos($_SERVER['HTTP_HOST'], "awugo.com")){
	//app('debugbar')->disable();
//}
Route::get('/', 'IndexController@main');
// 
// 
Route::group(['prefix'=>'/{country}/auth/manager'], function(){
	Route::group(['middleware'=>'auth.manager.login'], function(){
		// 儀表板(最新消息)
			Route::get('main', 'Auth\ManagerController@main');
		// 管理員與權限管理
			Route::get('authority_list', 'Auth\AuthorityController@main');
			// 
			Route::get('authority_add', 'Auth\AuthorityController@add');
			Route::post('authority_add', 'Auth\AuthorityController@addAuth');
			// 
			Route::get('authority_edit/{managerkey}', 'Auth\AuthorityController@edit');
			Route::post('authority_edit/{managerkey}', 'Auth\AuthorityController@editAuth');
			// 
			Route::post('authority_enable/{managerkey}', 'Auth\AuthorityController@enable');
		//
		//
			Route::get('area_list', 'Auth\AreaController@main');
			Route::post('area_get', 'Auth\AreaController@getSubArea');  //
			Route::post('area_get_zipcode', 'Auth\AreaController@getZipCode');  //
			Route::get('area_add', 'Auth\AreaController@add');
			Route::post('area_add', 'Auth\AreaController@addArea');
			Route::get('area_edit', 'Auth\AreaController@edit');
			Route::post('area_edit', 'Auth\AreaController@editArea');
			Route::post('area_edit/{areakey}', 'Auth\AreaController@editArea');
			Route::post('area_del', 'Auth\AreaController@delArea');
		//
			Route::get('hotel_list', 'Auth\HotelController@main');
			Route::post('hotel_list/{search_str}', 'Auth\HotelController@search');
			Route::get('hotel_add', 'Auth\HotelController@add');
			Route::post('hotel_add', 'Auth\HotelController@addPost');
			Route::get('hotel_edit/{hotelkey}', 'Auth\HotelController@edit');
			Route::post('hotel_edit/{hotelkey}', 'Auth\HotelController@editPost');
			Route::post('hotel_disable/{hotelkey}', 'Auth\HotelController@disableAjax'); //
			Route::get('hotel_browse/{hotelkey}', 'Auth\HotelController@browse');
			Route::get('hotel_site', 'Auth\HotelController@toManager');
			Route::post('hotel_comm_add/{hotelkey}', 'Auth\HotelController@addCommAjax'); //

		//
			Route::get('hotel_auth_list/{hotel_key}', 'Auth\HotelAuthController@main');
			Route::get('hotel_auth_add/{hotel_key}', 'Auth\HotelAuthController@add');
			Route::post('hotel_auth_add/{hotel_key}', 'Auth\HotelAuthController@addPost');
			Route::get('hotel_auth_edit/{hotel_key}/{mem_key}', 'Auth\HotelAuthController@edit'); 
			Route::post('hotel_auth_edit/{hotel_key}/{mem_key}', 'Auth\HotelAuthController@editPost'); 
			Route::post('hotel_auth_del/{hotel_key}/{mem_key}', 'Auth\HotelAuthController@delPost'); 

		//
			Route::get('service', 'Auth\ServiceController@main');
			Route::post('service_add', 'Auth\ServiceController@addPost'); 	//
			Route::post('service_edit', 'Auth\ServiceController@editPost'); //
			Route::post('service_del', 'Auth\ServiceController@delPost'); 	//

		//
			Route::get('room_installation', 'Auth\RoomInstallationController@main');
			Route::post('room_installation_add', 'Auth\RoomInstallationController@addPost'); 	//
			Route::post('room_installation_edit', 'Auth\RoomInstallationController@editPost'); //
			Route::post('room_installation_del', 'Auth\RoomInstallationController@delPost'); 	//
		//
			Route::get('room_name', 'Auth\RoomNameController@main');
			Route::post('room_name_add', 'Auth\RoomNameController@addPost'); 	//
			Route::post('room_name_edit', 'Auth\RoomNameController@editPost'); //
			Route::post('room_name_del', 'Auth\RoomNameController@delPost'); 	//
		//
			Route::get('bed_name', 'Auth\BedNameController@main');
			Route::post('bed_name_add', 'Auth\BedNameController@addPost'); 	//
			Route::post('bed_name_edit', 'Auth\BedNameController@editPost'); //
			Route::post('bed_name_del', 'Auth\BedNameController@delPost'); 	//

	});
});
Route::group(['prefix'=>'/{country}/auth'], function(){
	Route::post('login', 'SignController@login_post');
	Route::get('login', 'SignController@login')->name('login');
	Route::get('logout', 'SignController@logout');
});

//業者後台
Route::group(['prefix'=>'/{country}/auth'], function(){
	//
	Route::get('/', function(){
		return view('errors.404');
	});
	//
		Route::get('{hotel_id}/', 'HotelAuth\SignController@login');
		Route::post('{hotel_id}/', 'HotelAuth\SignController@login_post');
		// Route::post('{hotel_id}/login', 'HotelAuth\SignController@login_post');
		Route::get('{hotel_id}/logout', 'HotelAuth\SignController@logout');
	//
	Route::group(['middleware'=>'auth.hotel.login'], function(){

	// 
		Route::get('{hotel_id}/main', 'HotelAuth\ManagerController@main');
		Route::post('{hotel_id}/main', 'HotelAuth\ManagerController@mainPost');
	// 
		Route::get('{hotel_id}/photos', 'HotelAuth\PhotoController@main');
		Route::get('{hotel_id}/photos_plan', 'HotelAuth\PhotoController@plan');
		Route::post('{hotel_id}/photos', 'HotelAuth\PhotoController@mainPost');
		Route::post('{hotel_id}/photos_del', 'HotelAuth\PhotoController@delPic');
		Route::post('{hotel_id}/photos_edit', 'HotelAuth\PhotoController@editPic');
		Route::get('{hotel_id}/photos_editplan', 'HotelAuth\PhotoController@editPlan');
		Route::post('{hotel_id}/photos_cate', 'HotelAuth\PhotoController@changeCate');
	// 
		Route::get('{hotel_id}/service', 'HotelAuth\ServiceController@main');				//
		Route::post('{hotel_id}/service', 'HotelAuth\ServiceController@mainPost');			//
		//
		Route::get('{hotel_id}/service_photo/{service_id}', 'HotelAuth\ServiceController@photoPlan');
		Route::post('{hotel_id}/service_photo/{service_id}', 'HotelAuth\ServiceController@photoPlanPost');
		Route::post('{hotel_id}/service_photo/{service_id}/del', 'HotelAuth\ServiceController@photoPlanDel');
		//
		Route::post('{hotel_id}/service_photo_upload/{service_id}', 'HotelAuth\ServiceController@photoPlanUpload');
		
		Route::get('{hotel_id}/service_edit', 'HotelAuth\ServiceController@edit');			//
		Route::post('{hotel_id}/service_edit', 'HotelAuth\ServiceController@editPost');		//

	//客房設定
		Route::get('{hotel_id}/room_set', 'HotelAuth\RoomSetController@list');			//
		Route::get('{hotel_id}/room_del/{room_id}', 'HotelAuth\RoomSetController@delRoom');		//
		Route::get('{hotel_id}/room_set/{room_id}', 'HotelAuth\RoomSetController@main');			//
		Route::post('{hotel_id}/room_set/{room_id}', 'HotelAuth\RoomSetController@mainPost');	//
		//
		Route::post('{hotel_id}/room_set_upload/{room_id}', 'HotelAuth\RoomSetController@photoPlanUpload');
		Route::post('{hotel_id}/room_photo_edit', 'HotelAuth\RoomSetController@roomPhotoEdit');	
		Route::post('{hotel_id}/room_photo_del', 'HotelAuth\RoomSetController@roomPhotoDel');	

	//房價表
		Route::get('{hotel_id}/price', 'HotelAuth\PriceSetController@price');						//
		Route::get('{hotel_id}/price_normal', 'HotelAuth\PriceSetController@price_normal');			//
		Route::post('{hotel_id}/price_normal', 'HotelAuth\PriceSetController@price_normal_post');	//
		Route::post('{hotel_id}/price_normal_del', 'HotelAuth\PriceSetController@price_normal_del');
		Route::post('{hotel_id}/price_special_del', 'HotelAuth\PriceSetController@price_special_del');
		Route::post('{hotel_id}/dont_show_last_year', 'HotelAuth\PriceSetController@dont_show_last_year');
	});
});

//API
Route::group(['prefix'=>'/{country}/api'], function(){
	//
	Route::post('getArea1', 'Api\AreaApiController@getArea1');		
	//
	Route::post('getArea2/{in_country}', 'Api\AreaApiController@getArea2');	
	//
	Route::post('getArea3/{parent}', 'Api\AreaApiController@getArea3');	
	//		
	Route::post('getArea4/{parent}', 'Api\AreaApiController@getArea4');		
	//		
	Route::post('getZipCode/{area_key}', 'Api\AreaApiController@getZipCode');		

////////////////////////////////////////////////////////////////////////////////////////

	//
	Route::get('up', 'Api\UploadApiController@imageUploadView');
	Route::post('image', 'Api\UploadApiController@imageUpload');
	//
	Route::post('file', 'Api\UploadApiController@fileUpload');
	Route::get('tttest', 'Api\UploadApiController@test');
});


Route::get('/dt', function () {
    return date("YmdHis").'_512_'.explode(' ', microtime())[0]*100000000;
});
