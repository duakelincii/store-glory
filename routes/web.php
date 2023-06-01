<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Master\BallController;
use App\Http\Controllers\Admin\Master\BannerController;
use App\Http\Controllers\Admin\Master\FieldController;
use App\Http\Controllers\Admin\Master\PaymentTypeController;
use App\Http\Controllers\Admin\Master\ProductController;
use App\Http\Controllers\Admin\Master\UserController;
use App\Http\Controllers\Admin\Order\IncomeController;
use App\Http\Controllers\Admin\Order\SummaryController;
use App\Http\Controllers\Admin\Order\TransactionController as OrderTransactionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\TransactionController;
use App\Models\PaymentType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [UserDashboardController::class, 'index'])->name('app');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'authLogin'])->name('login');

Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'authRegister']);

Route::get('detail/{field}', [OrderController::class, 'detail']);
Route::post('order/booking/{field}', [OrderController::class, 'booking'])
    ->middleware('auth')
    ->name('booking');
Route::get('order/{field}', [OrderController::class, 'order']);
Route::post('api/check-schedule/{field:id}', [OrderController::class, 'checkSchedule'])->name('check-schedule');
Route::get('app/profile', [ProfileController::class, 'index'])->name('app.profile');
Route::get('app/profile/edit', [ProfileController::class, 'edit'])->name('app.profile.edit');
Route::patch('app/profile/edit', [ProfileController::class, 'update']);
Route::get('app/profile/password', [ProfileController::class, 'password'])->name('app.profile.password');
Route::patch('app/profile/password', [ProfileController::class, 'updatePassword']);
// Transaction
Route::middleware(['auth'])->group(function () {
    Route::post('order/booking/{field}', [OrderController::class, 'booking'])
        ->middleware('auth')
        ->name('booking');
    Route::get('order/{field}', [OrderController::class, 'order']);
    Route::post('api/check-schedule/{field:id}', [OrderController::class, 'checkSchedule'])->name('check-schedule');
    Route::get('app/profile', [ProfileController::class, 'index'])->name('app.profile');
    Route::get('app/profile/edit', [ProfileController::class, 'edit'])->name('app.profile.edit');
    Route::get('app/profile/password', [ProfileController::class, 'password'])->name('app.profile.password');

    Route::get('transaction', [TransactionController::class, 'index'])->name('app.transaction');
    Route::get('cart', [CartController::class, 'index'])->name('app.cart');
    // Route::get('transaction/history', [TransactionController::class, 'history'])->name('app.transaction.history');
    Route::get('transaction/order/{order}', [TransactionController::class, 'order']);
    Route::post('transaction/pay/{transaction}', [TransactionController::class, 'pay'])->name('app.transaction.pay');
    // Route::get('transaction/repayment/{order}', [TransactionController::class, 'pay']);
    Route::get('transaction/{transaction}', [TransactionController::class, 'detail'])->name('app.transaction.detail');

    Route::get('/cart/tambah/keranjang/{id}',[CartController::class,'modal'])->name('cart.tambah');
    Route::post('cart/simpan/{id}',[CartController::class,'update'])->name('cart.simpan');
    Route::get('cart/qty',[CartController::class,'quantity'])->name('checkout.qty');
    Route::delete('cart/hapus/{id}',[CartController::class,'delete'])->name('delete.cart');
});


Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('logout', [LoginController::class, 'logout']);
Route::prefix('admin')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [LoginController::class, 'login']);
});
Route::group(['middleware' => 'auth.admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('home');
    // Master
    Route::group(['prefix' => 'master', 'name' => 'master.'], function () {
        // Pengguna Route | customer
        Route::get('users', [UserController::class, 'index'])->name('user.index');
        Route::prefix('user')->group(function () {
            Route::post('/', [UserController::class, 'store'])->name('user.store');
            Route::get('create', [UserController::class, 'create'])->name('user.create');
            Route::patch('update/{user}', [UserController::class, 'update']);
            Route::delete('delete/{user}', [UserController::class, 'destroy']);
        });

        Route::get('settings', [SettingController::class,'index'])->name('settings.index');
        Route::post('settings', [SettingController::class,'post'])->name('settings.post');

        // Kategori Route
        // Route: /admin/master/kategori
        Route::resource('kategori', KategoriController::class);
        // Produk
        // Route: /admin/master/products
        Route::get('products', [ProductController::class, 'index'])->name('product.index');
        Route::prefix('product')->group(function () {
            Route::post('/', [ProductController::class, 'store'])->name('product.store');
            Route::get('create', [ProductController::class, 'create'])->name('product.create');
            Route::get('edit/{product}', [ProductController::class, 'edit']);
            Route::patch('update/{product}', [ProductController::class, 'update']);
            Route::delete('delete/{product}', [ProductController::class, 'destroy']);
        });
        // Route: /admin/master/banner
        Route::get('banners', [BannerController::class, 'index'])->name('banner.index');
        Route::prefix('banner')->group(function () {
            Route::post('/', [BannerController::class, 'store'])->name('banner.store');
            Route::get('create', [BannerController::class, 'create'])->name('banner.create');
            Route::get('edit/{banner}', [BannerController::class, 'edit']);
            Route::patch('update/{banner}', [BannerController::class, 'update']);
            Route::delete('delete/{banner}', [BannerController::class, 'destroy']);
        });

        // Lapangan Route | paymentType
        Route::get('payment-types', [PaymentTypeController::class, 'index'])->name('paymentType.index');
        Route::prefix('payment-type')->group(function () {
            Route::post('/', [PaymentTypeController::class, 'store'])->name('paymentType.store');
            Route::get('create', [PaymentTypeController::class, 'create'])->name('paymentType.create');
            Route::get('edit/{payment}', [PaymentTypeController::class, 'edit']);
            Route::patch('update/{payment}', [PaymentTypeController::class, 'update']);
            Route::delete('delete/{payment}', [PaymentTypeController::class, 'destroy']);
        });
    });
    // Order
    Route::prefix('order')->group(function () {
        // Rekap Orderan
        Route::get('sumaries', [SummaryController::class, 'index'])->name('summary.index');
        Route::prefix('summary')->group(function () {
            Route::post('/', [SummaryController::class, 'store'])->name('summary.store');
            Route::get('create', [SummaryController::class, 'create'])->name('summary.create');
            Route::get('edit/{order}', [SummaryController::class, 'edit']);
            Route::patch('edit/{order}', [SummaryController::class, 'update']);
            Route::get('{order}', [SummaryController::class, 'show']);
        });

        // Pendapatan
        Route::get('incomes', [IncomeController::class, 'index'])->name('income.index');
        Route::prefix('income')->group(function () {
            Route::post('/', [IncomeController::class, 'store'])->name('income.store');
            Route::get('create', [IncomeController::class, 'create'])->name('income.create');
            Route::get('edit/{income}', [IncomeController::class, 'edit']);
            Route::patch('edit/{income}', [IncomeController::class, 'update']);
        });
    });
    Route::patch('transaction/update/{transaction}', [OrderTransactionController::class, 'update'])->name('transaction.update');


    Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
});
Route::group(['middleware' => 'auth.admin', 'prefix' => 'api', 'as' => 'api.'], function () {
    //JSON
    Route::get('json/ball/{ball}', [BallController::class, 'json'])->name('json.ball');
    Route::get('json/payment-type/{payment}', [PaymentTypeController::class, 'json'])->name('json.payment');
    Route::get('json/transaction/{transaction}', [OrderTransactionController::class, 'json'])->name('json.transaction');
    Route::get('json/user/{user}', [UserController::class, 'json'])->name('json.user');
    Route::get('json/kategori/{kategori}', [KategoriController::class, 'json'])->name('json.kategori');
    Route::get('json/product/{product}', [ProductController::class, 'json'])->name('json.product');

    // Datatable
    Route::get('datatable/orders', [SummaryController::class, 'datatable'])->name('orders');
});
