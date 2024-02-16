<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[\App\Http\Controllers\GeneralPageController::class,'welcome'])->name('welcome');
//Регистрация
Route::get('/registration',[\App\Http\Controllers\GeneralPageController::class,'registrationPage'])->name('registrationPage');
Route::post('/registration/save',[\App\Http\Controllers\UserController::class,'registration'])->name('registration');
//Авторизация
Route::get('/authorization',[\App\Http\Controllers\GeneralPageController::class,'authorization'])->name('login');
Route::post('/login',[\App\Http\Controllers\UserController::class,'Auth'])->name('Auth');

//Страница пользователя
Route::get('/user/index',[\App\Http\Controllers\UserController::class, 'index_user'])->name('index_user');

//Выход
Route::get('/exit',[\App\Http\Controllers\UserController::class,'exit'])->name('exit');

// Главная страница
// Продукты
Route::get('/user/products/get',[\App\Http\Controllers\ProductController::class,'get_products'])->name('get_products');
Route::get('/user/products/top/get',[\App\Http\Controllers\ProductController::class,'get_top_products'])->name('get_top_products');

//информация о продукте
Route::get('/user/product/info/{id?}',[\App\Http\Controllers\GeneralPageController::class,'info_product_page'])->name('info_product_page');
Route::post('/user/product/review',[\App\Http\Controllers\ProductController::class,'add_reviews'])->name('add_reviews');
Route::post('/user/product/review/get',[\App\Http\Controllers\ReviewController::class,'show'])->name('get_reviews');
Route::post('/user/product/favorite',[\App\Http\Controllers\FavoriteController::class,'store'])->name('add_favorite');

// Каталог
Route::get('/user/catalog/page',[\App\Http\Controllers\GeneralPageController::class,'catalog_page'])->name('catalog_page');
Route::post('/user/catalog/product/get',[\App\Http\Controllers\ProductController::class,'get_need_product'])->name('get_need_product');

//Корзина
Route::get('/user/product/cart/page',[\App\Http\Controllers\GeneralPageController::class,'cart_page'])->name('cart_page');
Route::post('/user/product/cart/add',[\App\Http\Controllers\CartController::class,'store'])->name('add_to_cart');
Route::post('/user/product/cart/minus',[\App\Http\Controllers\CartController::class,'minus_product'])->name('minus_product');
Route::post('/user/product/cart/delete',[\App\Http\Controllers\CartController::class,'delete_cart'])->name('delete_cart');
Route::get('/user/product/cart/product/get',[\App\Http\Controllers\CartController::class,'get_products_cart'])->name('get_products_cart');

//Заказ
Route::get('/user/order/get',[\App\Http\Controllers\GeneralPageController::class,'order_page_user'])->name('order_page_user');
Route::get('/user/order/orders/get',[\App\Http\Controllers\OrderController::class,'show'])->name('get_orders_user');
Route::post('/user/order/sent',[\App\Http\Controllers\OrderController::class,'store'])->name('user_sent_order');
Route::get('/user/order/sent/close',[\App\Http\Controllers\OrderController::class,'edit'])->name('order_sent_close');

// Филиал
Route::get('/user/filiial/get',[\App\Http\Controllers\FilialController::class,'get_filials'])->name('get_filials');


//Характеристики get
Route::get('/categories/type/get',[\App\Http\Controllers\TypeController::class,'show'])->name('get_type');
Route::get('/categories/subtype/get',[\App\Http\Controllers\SubtypeController::class,'show'])->name('get_subtype');
Route::get('/categories/material/get',[\App\Http\Controllers\MaterialController::class,'show'])->name('get_material');
Route::get('/categories/stone/get',[\App\Http\Controllers\StoneController::class,'show'])->name('get_stone');
Route::get('/categories/whom/get',[\App\Http\Controllers\WhomeController::class,'show'])->name('get_whom');
Route::get('/categories/sample/get',[\App\Http\Controllers\SampleController::class,'show'])->name('get_sample');
Route::get('/categories/cutting/get',[\App\Http\Controllers\CuttingController::class,'show'])->name('get_cutting');
Route::get('/categories/brand/get',[\App\Http\Controllers\BrandController::class,'show'])->name('get_brand');
Route::get('/product/filial/size/show',[\App\Http\Controllers\ProductFilialSizeController::class,'show'])->name('get_filial_sizes');
Route::get('/filials/get',[\App\Http\Controllers\FilialController::class,'show'])->name('get_filial');

//Ограничения доступа к страницам администратоа
Route::group(['middleware'=>['auth','admin'],'prefix'=>'admin'],function (){
    Route::get('admin/menu',[\App\Http\Controllers\AdminPageController::class,'menu_page_admin'])->name('menu_page_admin');

    Route::get('/admin/index',[\App\Http\Controllers\AdminPageController::class,'index_admin'])->name('index_admin');
    Route::get('/categories',[\App\Http\Controllers\AdminPageController::class,'categories'])->name('categories');
    Route::get('/admin/filials',[\App\Http\Controllers\AdminPageController::class,'filials'])->name('filials');

    Route::post('/categories/type/save',[\App\Http\Controllers\TypeController::class,'store'])->name('type_save');
    Route::post('/categories/material/save',[\App\Http\Controllers\MaterialController::class,'store'])->name('material_save');
    Route::post('/categories/stone/save',[\App\Http\Controllers\StoneController::class,'store'])->name('stone_save');
    Route::post('/categories/whom/save',[\App\Http\Controllers\WhomeController::class,'store'])->name('whom_save');
    Route::post('/categories/sample/save',[\App\Http\Controllers\SampleController::class,'store'])->name('sample_save');
    Route::post('/categories/cutting/save',[\App\Http\Controllers\CuttingController::class,'store'])->name('cutting_save');
    Route::post('/categories/brand/save',[\App\Http\Controllers\BrandController::class,'store'])->name('brand_save');


    Route::post('/categories/subtype/edit',[\App\Http\Controllers\SubtypeController::class,'edit'])->name('edit_subtype');
    Route::post('/categories/sizes/edit',[\App\Http\Controllers\SizeController::class,'edit'])->name('edit_sizes');

    Route::post('/categories/subtype/delete',[\App\Http\Controllers\SubtypeController::class,'destroy'])->name('destroy_subtypes');
    Route::post('/categories/sizes/delete',[\App\Http\Controllers\SizeController::class,'destroy'])->name('destroy_sizes');

    Route::post('/categories/subtype/save',[\App\Http\Controllers\SubtypeController::class,'create'])->name('save_subtypes');
    Route::post('/categories/sizes/save',[\App\Http\Controllers\SizeController::class,'create'])->name('save_sizes');

    Route::get('/categories/type/delete/{id?}/{type?}',[\App\Http\Controllers\TypeController::class,'destroy'])->name('delete_type');
    Route::post('/categories/type/update',[\App\Http\Controllers\TypeController::class,'update'])->name('update_char');

//    Filials
    Route::post('/filials/save',[\App\Http\Controllers\FilialController::class,'store'])->name('save_filial');

    Route::get('/filials/delete/{id?}',[\App\Http\Controllers\FilialController::class,'destroy'])->name('delete_filial');
    Route::post('/filials/edit',[\App\Http\Controllers\FilialController::class,'edit'])->name('edit_filial');

//    Products
    Route::get('/product/index',[\App\Http\Controllers\AdminPageController::class,'product_index'])->name('product_index');
    Route::get('/product/delete/{id?}',[\App\Http\Controllers\ProductController::class,'destroy'])->name('delete_product');
    Route::post('/product/save',[\App\Http\Controllers\ProductController::class,'store'])->name('store_product');
    Route::post('/product/filial/size/save',[\App\Http\Controllers\ProductFilialSizeController::class,'store'])->name('saveNewPFS');

//Orders
    Route::get('/orders/page',[\App\Http\Controllers\AdminPageController::class,'orders_page'])->name('orders_page');
    Route::get('/orders/get',[\App\Http\Controllers\OrderController::class,'get_all_orders'])->name('get_all_orders');
});


