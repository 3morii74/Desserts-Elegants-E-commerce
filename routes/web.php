<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminStaticPageController;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CartController;

use App\Http\Controllers\NotificationSubscriptionController;




Route::get('/', [WelcomeController::class, 'index'])->name('Home'); //done
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index'); //done
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/items', [ItemController::class, 'index'])->name('items.index'); //done

Route::get('/thankyou', [WelcomeController::class, 'thankyou'])->name('thankyou');
Route::get('/create', [RegisterController::class, 'create'])->name('register.create');
Route::post('/register11', [RegisterController::class, 'store'])->name('register.store');
Route::get('/loginUser', [LoginController::class, 'index'])->name('contact.login');
Route::post('/check', [LoginController::class, 'check'])->name('login.check');


Route::middleware(['auth'])->post('/addItem', [CartController::class, 'addToCart'])->name('item.add');
Route::middleware(['auth'])->get('/cartItem', [CartController::class, 'showCart'])->name('item.show');
Route::middleware(['auth'])->delete('/deleteItem/{item}', [CartController::class, 'removeFromCart'])->name('item.delete');
Route::middleware(['auth'])->post('/checkOut', [CartController::class, 'showCheckOut'])->name('item.checkOut');
//Route::middleware(['auth'])->post('/updateCartItem/{id}', [CartController::class, 'updateCartItem'])->name('item.update');
Route::middleware(['auth'])->post('/placeOrder', [CartController::class, 'store'])->name('order.store');
Route::middleware(['auth'])->post('/decrementItem/{item}', [CartController::class, 'decrementItem'])->name('item.decrement');
Route::middleware(['auth'])->post('/incrementItem/{item}', [CartController::class, 'incrementItem'])->name('item.increment');


//Route::middleware(['auth'])->patch('/updateCartItem/{itemName}', [CartController::class, 'updateCartItem'])->name('cart.update');
//Route::middleware(['auth'])->delete('/cart/remove/{item}', [CartController::class, 'removeFromCart'])->name('cart.remove');
//Route::post('/checkout', [CartController::class, 'showCheckOut'])->name('checkout');



Route::middleware(['auth'])->get('/myorder', [OrderController::class, 'index'])->name('order.indexClint');
Route::middleware(['auth'])->delete('/myorder/{order}', [OrderController::class, 'destory'])->name('order.destoryClint');

Route::middleware(['auth'])->get('/subscribe', [NotificationSubscriptionController::class, 'subscribe'])->name('subscribe');
Route::middleware(['auth', 'admin'])->get('/notify/{item}', [NotificationSubscriptionController::class, 'notify'])->name('notify');
Route::middleware(['auth'])->get('/unsubscribe', [NotificationSubscriptionController::class, 'unsubscribe'])->name('unsubscribe');
Route::middleware(['auth', 'admin'])->get('/admin', [AdminController::class, 'index'])->name('admin.index');

Route::middleware(['auth', 'admin'])->get('/admin/categories', [CategoryController::class, 'indexAdmin'])->name('admin.categories.index');
Route::middleware(['auth', 'admin'])->get('/admin/categories/create', [CategoryController::class, 'createAdmin'])->name('admin.categories.create');
Route::middleware(['auth', 'admin'])->post('/admin/categories/store', [CategoryController::class, 'storeAdmin'])->name('admin.categories.store');
Route::middleware(['auth', 'admin'])->get('/admin/categories/edit', [CategoryController::class, 'editAdmin'])->name('admin.categories.edit');
Route::middleware(['auth', 'admin'])->delete('/admin/categories/destroy', [CategoryController::class, 'destroyAdmin'])->name('admin.categories.destroy');
Route::middleware(['auth', 'admin'])->put('/admin/categories/update', [CategoryController::class, 'updateAdmin'])->name('admin.categories.update');

Route::middleware(['auth', 'admin'])->get('/admin/items', [ItemController::class, 'indexAdmin'])->name('admin.items.index');
Route::middleware(['auth', 'admin'])->get('/admin/items/create', [ItemController::class, 'createAdmin'])->name('admin.items.create');
Route::middleware(['auth', 'admin'])->post('/admin/items/store', [ItemController::class, 'storeAdmin'])->name('admin.items.store');
Route::middleware(['auth', 'admin'])->get('/admin/items/edit', [ItemController::class, 'editAdmin'])->name('admin.items.edit');
Route::middleware(['auth', 'admin'])->delete('/admin/items/destroy', [ItemController::class, 'destroyAdmin'])->name('admin.items.destroy');
Route::middleware(['auth', 'admin'])->put('/admin/items/update', [ItemController::class, 'updateAdmin'])->name('admin.items.update');

Route::middleware(['auth', 'admin'])->get('/admin/statistics', [AdminStaticPageController::class, 'index'])->name('admin.statistics.index');

Route::middleware(['auth', 'admin'])->get('/admin/orders', [OrderController::class, 'indexAdmin'])->name('admin.orders.index');
Route::middleware(['auth', 'admin'])->get('/admin/orders/create', [OrderController::class, 'createAdmin'])->name('admin.orders.create');
Route::middleware(['auth', 'admin'])->delete('/admin/orders/destroy', [OrderController::class, 'destroyAdmin'])->name('admin.orders.destroy');
Route::middleware(['auth', 'admin'])->post('/admin/orders/done', [OrderController::class, 'done'])->name('admin.orders.done');
Route::middleware(['auth', 'admin'])->post('/admin/orders/store', [OrderController::class, 'storeAdmin'])->name('admin.orders.store');





require __DIR__ . '/auth.php';
