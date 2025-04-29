<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\orderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth as FacadesAuth;


   //Route::get('/', function () {
    //return view('welcome');
//});

//add_to_cart

Route::get('/cart',[CartController::class,'index'])->name('cart.index');
Route::post('/add/cart/{product}',[CartController::class,'addProductToCart'])->name('add.cart')->middleware('auth');;
Route::delete('/remove/{product}/cart', [CartController::class,'removeProductFromCart'])->name('remove.cart');
Route::put('/update/{product}/cart', [CartController::class,'updateProductOnCart'])->name('update.cart');

Route::get('/', [\App\Http\Controllers\StoreController::class, 'index'])->name( 'store.index');
Route::get('/store/{product}', [\App\Http\Controllers\StoreController::class, 'show'])->name( 'store.show');

Route::get('/showuser',[ProductController::class,'showuser'])->name('showuser');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (FacadesAuth::user()->role == 'admin') {
            return redirect()->route('pannel');  // Admin route
        } else {
            return redirect()->route('store.index');  // User route
        }
    })->name('dashboard');
});



Route::get('/pannel',[ProductController::class,'pannel'])->name('pannel')->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('products',ProductController::class)->middleware('AdminAuthenticated');
    Route::resource('categories',CategoryController::class)->middleware('AdminAuthenticated');
});

//orders
Route::get('orders/index',[orderController::class,'index'])->name('orders.index')->middleware(['AdminAuthenticated','auth']);
Route::post('/order', [cartController::class,'getOrder'])->name('getOrder')->middleware('auth');
Route::put('/updateD/{order}', [orderController::class,'updateDelivered'])->name('orders.updateD');
Route::put('/updateP/{order}', [orderController::class,'updatePaid'])->name('orders.updateP');
Route::delete('/delete/{order}', [orderController::class,'destroy'])->name('orders.destroy');

require __DIR__.'/auth.php';
