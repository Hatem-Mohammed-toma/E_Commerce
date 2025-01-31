<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
})->name("welcome");

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::get('redirect',[HomeController::class,'redirect']);

Route::controller(ProductController::class)->group(function(){
// جزء الادمن
    Route::middleware(IsAdmin::class)->group(function () {

        Route::get('products',"allProducts");
        Route::get('products/show/{id}',"show");

        // create
        Route::get('products/create',"create");
        Route::post('products',"store")->name("store");


        Route::get('products/edit{id}',"edit");
        Route::put('products/{id}',"update");

        Route::delete('products/{id}',"delete");

    });
    });

Route::get("change/{lang}",function($lang){
    // ar session
    if($lang == "ar"){
    session()->put("lang","ar");
    }else{
    session()->put("lang","en");
    }
    // en
    return redirect()->back();
});

Route::controller(UserController::class)->group(function(){
    Route::get("","all");
    Route::get("products/{id}", "show")->name('user.products.show');  // Optional: Named route
    Route::get("search","search"); 

    Route::get("mycart","mycart")->middleware('auth');

    //makeOrder
    Route::post("addToCart/{id}","addToCart");
    Route::post("makeOrder","makeOrder");

});
