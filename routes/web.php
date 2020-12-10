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

Route::get('/', [\App\Http\Controllers\LoginController::class,'show']);

Route::get('register',[\App\Http\Controllers\RegisterController::class,'register']);
Route::post('registerUser',[\App\Http\Controllers\RegisterController::class,'registerUser']);

Route::get('login',[\App\Http\Controllers\LoginController::class,'show'])->name('login');
Route::post('login',[\App\Http\Controllers\LoginController::class,'login']);
Route::post("saveData",[\App\Http\Controllers\SubmitController::class,'getData']);

Route::get('logout',[\App\Http\Controllers\LoginController::class,'logout'])->name('logout');

/*Route::name('home')->get('home',function (){
    return "{}";
})->name('home');*/


Route::middleware('auth')->group(function (){
    Route::get("home",[ \App\Http\Controllers\HomeController::class,'home' ])->middleware('auth');
    Route::get("uploadProducts",[ \App\Http\Controllers\HomeController::class,'uploadProducts' ]);
    Route::get("viewProducts",[ \App\Http\Controllers\HomeController::class,'viewProducts' ]);
    Route::post("editProductItem",[ \App\Http\Controllers\HomeController::class,'editProductItem']);
    Route::post("bulkProductItem",[ \App\Http\Controllers\HomeController::class,'bulkProductItem']);
    Route::get("viewCategory",[ \App\Http\Controllers\HomeController::class,'viewCategory']);
    Route::get("createCategory",[ \App\Http\Controllers\HomeController::class,'createCategory']);
    Route::get("getAllCategories",[ \App\Http\Controllers\HomeController::class,'getAllCategories']);
    Route::post("getProductsByCat",[ \App\Http\Controllers\HomeController::class,'getProductsByCat']);
    Route::post("deleteCat",[ \App\Http\Controllers\HomeController::class,'deleteCat']);
    Route::post("saveCategory",[ \App\Http\Controllers\HomeController::class,'saveCategory']);
    Route::post("searchProducts",[\App\Http\Controllers\HomeController::class,'searchProducts']);
    Route::post("uploadProductsPost",[ \App\Http\Controllers\HomeController::class,'postUploadProducts' ])
        ->name('uploadProductsPost')
        ->middleware(\App\Http\Middleware\ExcelImportProcessMiddleware::class);
});


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
    //Route::view('home','home');
});


