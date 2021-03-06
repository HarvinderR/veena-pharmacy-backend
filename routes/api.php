<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth.api:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth.api:api')->group(function (){
    Route::get('/show_user',[\App\Http\Controllers\ApiController::class,'show_user']);
});
Route::get('fetch_category',[\App\Http\Controllers\ApiController::class,'fetch_category']);

Route::get('deleteCartItem',[\App\Http\Controllers\ApiController::class,'deleteCartItem']);
Route::get('deleteCart',[\App\Http\Controllers\ApiController::class,'deleteCart']);
Route::get('createCartItem',[\App\Http\Controllers\ApiController::class,'createCartItem']);
Route::get('createCart',[\App\Http\Controllers\ApiController::class,'createCart']);

Route::post('saveCustomer',[\App\Http\Controllers\ApiController::class,'createUser']);
Route::get('login',[\App\Http\Controllers\ApiController::class,'login']);

Route::get('apilogin',function (){
    $obj = ['data'=>'','response'=>'200','error'=>'login required'];
    return response($obj,201);
})->name('apilogin');

Route::post('uploadFile',[ \App\Http\Controllers\FileUploadController::class,'fileUploadPost' ]);

Route::get('fetchItems',[ \App\Http\Controllers\ApiController::class,'fetchItems']);

Route::get('test',function(Request $request){
    return $request -> all();
});

Route::post('test',function(Request $request){
    return $request -> all();
});


Route::get('/',function (){
    return response(array());
});

Route::post('/user_login',function(Request $request){
    if($request->username == 'harvinder' && $request->password == '123'){
        $a = [];
        $a['response'] = 'success';
        $a['msg'] = '';
        $a['data'] = array('name'=>'Harvinder Singh','gender'=>'male','phone'=>'8750240789');
        return $a;
    }
    $a =[];
    $a['response'] = 'fail';
    $a['msg'] = 'fail';
    $a['data'] = null;

    return $a;
});
