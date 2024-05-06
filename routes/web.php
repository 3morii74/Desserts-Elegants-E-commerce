<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\AdminStaticPageController;

use App\Http\Controllers\Frontend\CategoryController as FrontendCategoryController;
use App\Http\Controllers\Frontend\ItemController as FrontendItemController;
use App\Http\Controllers\Frontend\ReservationController as FrontendReservationController;
use App\Http\Controllers\Frontend\WelcomeController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;


Route::get('/', [WelcomeController::class, 'index'])->name('Home');
Route::get('/categories', [FrontendCategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [FrontendCategoryController::class, 'show'])->name('categories.show');
Route::get('/items', [FrontendItemController::class, 'index'])->name('menus.index');
// Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');


Route::get('/reservation/step-one', [FrontendReservationController::class, 'stepOne'])->name('reservations.step.one');
Route::post('/reservation/step-one', [FrontendReservationController::class, 'storeStepOne'])->name('reservations.store.step.one');
Route::get('/reservation/step-two', [FrontendReservationController::class, 'stepTwo'])->name('reservations.step.two');
Route::post('/reservation/step-two', [FrontendReservationController::class, 'storeStepTwo'])->name('reservations.store.step.two');
Route::get('/thankyou', [WelcomeController::class, 'thankyou'])->name('thankyou');
Route::get('/create', [RegisterController::class, 'create'])->name('register.create');
Route::post('/register11', [RegisterController::class, 'store'])->name('register.store');
Route::get('/loginUser', [LoginController::class, 'index'])->name('contact.login');
Route::post('/check', [LoginController::class, 'check'])->name('login.check');

Route::middleware(['auth'])->get('/myorder', [OrderController::class, 'indexClint'])->name('order.indexClint');
Route::middleware(['auth'])->delete('/myorder/{order}', [OrderController::class, 'destoryClint'])->name('order.destoryClint');
Route::middleware(['auth','admin'])->post('/orders/admin', [OrderController::class, 'done'])->name('order.done');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::resource('/categories', CategoryController::class);
    Route::resource('/menus', ItemController::class);
    Route::resource('/tables', AdminStaticPageController::class);
    // Route::post('/admin/orders/done', [OrderController::class, 'done'])->name('admin.orders.done');
    Route::resource('/orders', OrderController::class);

    // Route::resource('/static-pages', AdminStaticPageController::class);
});

require __DIR__ . '/auth.php';
