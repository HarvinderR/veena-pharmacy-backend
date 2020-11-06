<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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
Route::middleware('auth:api')->get('/in',function (Request $request){

});

Route::get("upload",function (){
   return view("UploadExcel");
});


Route::get('export', [\App\Http\Controllers\ImportExportController::class ,'export'])->name('export');
Route::get('importExportView', [\App\Http\Controllers\ImportExportController::class ,'importExportView']);
Route::post('import', [\App\Http\Controllers\ImportExportController::class ,'import'])->name('import');

Route::get('/', function () {
//    return "{}";
    return view('LoginScreen');
});

Route::get('register',[\App\Http\Controllers\RegisterController::class,'register']);
Route::post('registerUser',[\App\Http\Controllers\RegisterController::class,'registerUser']);

Route::post('login',[\App\Http\Controllers\LoginController::class,'login']);
Route::post("saveData",[\App\Http\Controllers\SubmitController::class,'getData']);

Route::name('home')->get('home',function (){
    return "{}";
})->name('home');

Route::get("home",[ 'as' => 'home', function (){
   return "Home";
}]);

Route::get("/ss/{name}",function ($name){
    if(DB::connection()->getDatabaseName())
    {
        echo "conncted sucessfully to database ".DB::connection()->getDatabaseName();
    }else{
        echo "Failed";
    }
    //return view('sser',["user"=>$name]);
});

Route::get("user/{id}",[UserController::class,'show']);


Route::group(['middleware' =>['protected-k'] ],function (){
    Route::view("s","first");
    Route::view('noaccess','noaccess');
    Route::view('home','home');
});


