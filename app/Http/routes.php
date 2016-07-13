<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/testPost',function(){
//    $csrf_token = csrf_token();
//    $form = <<<FORM
//        <form action="/hello" method="POST">
//            <input type="hidden" name="_token" value="{$csrf_token}">
//            <input type="submit" value="Test"/>
//        </form>
//FORM;
//    return $form;
//});

//Route::post('/hello',function(){
//    return "Hello Laravel[POST]!";
//});
//
//Route::match(['get'], '/hello', function(){
//	return 'match Route';
//});
//
//Route::any('/hello', function(){
//	return 'any Route';
//});

//Route::get('/hello/{name}', function($name){
//	return 'get '.$name;
//});

//Route::get('/hello/{name}/by/{user}',function($name,$user){
//    return "Hello {$name} by {$user}!";
//});
//
//Route::get('/hello/{name}/by/{user?}',function($name,$user = 'Jun'){
//    return "Hello {$name} by {$user}!";
//});

//Route::get('/hello/{name?}', function($name = 'Jun'){
//	return "Hello {$name}";
//})->where('name', '[A-Za-z1-9]+');


//路由命名 as关键字
//Route::get('/hello/laravelacademy', ['as' => 'academy', function(){
//	return 'hello laravelacademy';
//}]);
//Route::get('/testacademy', function(){
//	//echo route('academy');
//	return redirect()->route('academy');
//});
//
//Route::get('/hello/laravelacademy/{id}', ['as' => 'academy1', function($id){
//	return 'hello laravelacademy'.$id;
//}]);
//
//Route::get('/testacademy1/{id}', function($id){
//	//echo route('academy1', ['id' => $id]);
//	return redirect()->route('academy1', ['id' => $id]);
//});
//
//
////路由分组+中间件
//Route::group(['middleware'=>'test'], function(){
//	Route::get('/write', function(){
//		echo 'write';
//	});
//	
//	Route::get('/update', function(){
//		echo 'update';
//	});
//});
//
//Route::get('/age/refuse',['as'=>'refuse',function(){
//    return "未成年人禁止入内！";
//}]);
//
////命名空间
//Route::group(['namespace' => 'Laravelnamespace'], function(){
//	// 控制器在 "App\Http\Controllers\Laravelnamespace" 命名空间下
//	
//	Route::group(['namespace' => 'Test'], function(){
//		// 控制器在 "App\Http\Controllers\Laravelnamespace\Test" 命名空间下
//	});
//});
//
//
////子域名
//Route::group(['domain' => '{service}.deploy.com'], function(){
//	Route::get('/write/laravelacademy', function($service){
//		return 'domain '.$service;
//	});
//});
//
////路由前缀
//Route::group(['prefix' => 'laravelacademy'], function(){
//	Route::get('/write', function(){
//		return 'prefix：laravelacademy/write';
//	});
//	
//	Route::get('/update', function(){
//		return 'prefix：laravelacademy/update';
//	});
//});

//
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});

Route::group(['middleware' => 'web'], function () {
    Route::get('/', 'HomeController@index');
	Route::get('/test', 'UserController@demo');
	//注册
	Route::get('/register', 'User\RegisterController@Index');
	Route::post('/postReg', 'User\RegisterController@Register');
	Route::get('/user/activateemail', 'User\RegisterController@Activation');
	
	//登录
	Route::get('/login', 'User\LoginController@Index');
	Route::post('/toLogin', 'User\LoginController@Login');
	Route::get('/logout', 'User\LoginController@logout');
	
	//找回密码
	Route::get('/FindPass/Index', 'User\PasswordController@Index');
	Route::post('/FindPass/Send', 'User\PasswordController@ResetAndEmail');
	Route::get('/FindPass/ResetPassword', 'User\PasswordController@ResetPassword');
	Route::post('/FindPass/Check', 'User\PasswordController@CheckResetPassword');
});
