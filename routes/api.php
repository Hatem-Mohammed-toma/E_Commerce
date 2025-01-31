<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ApiCategoryController;
use App\Http\Controllers\ApiCountryController;
use App\Http\Controllers\ApiPostController;
use App\Http\Controllers\ApiProductController;
use App\Http\Controllers\CategoryController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/category', function ()) ;

// crud
// read
Route::middleware('api_localization')->get('/user',function(User $user) {
return __('message.Add product') ;
});

Route::controller(ApiProductController::class)->group(function(){
    Route::get("products","all");
     Route::get("products/{id}","show");

     Route::get("products/check-by-name/{name}","checkProductByName");

  Route::middleware('api_auth')->group(function(){
            // Route::get("products","all");
            // Route::get("products/{id}","show");

            // create
            Route::post("products","store");

            // update
            Route::put("products/{id}","update");

            // delete
            Route::delete("products/{id}","delete");
 });
});

Route::post('/categories', [ApiCategoryController::class, 'store'])->middleware('api_auth');
Route::get('/categories/{id}', [ApiCategoryController::class, 'show']); // Show category
Route::put('/categories/{id}', [ApiCategoryController::class, 'update']); // Update category
Route::delete('/categories/{id}', [ApiCategoryController::class, 'destroy']); // Delete category

Route::controller(ApiAuthController::class)->group(function(){
    // register
    Route::post("register","register");

    Route::post("login","login");

    Route::post("update_passord","updatePassword");

    Route::post("logout","logout");
});

















Route::controller(ApiCountryController::class)->group(function(){
            Route::get('countries','all') ;
            Route::post('location_data', 'getLocationData');
});

// Route::controller(ApiPostController::class)->group(function(){
//     Route::get('posts', 'all')->middleware('api_auth'); // admin status pending
//     Route::put('posts/{status}/{id}',  'update')->middleware('api_auth'); // midlleware api_auth // دي من غير canceled

//     Route::delete('posts/{id}',  'delete'); // midlleware api_auth

//     Route::delete('posts/{id}','delete_user');

//     Route::get('posts/users', 'postuser'); // all user    status accepted

//     Route::post('posts', 'store'); // add post with acces_token ;
// });

// migration , mode , controller
// controller