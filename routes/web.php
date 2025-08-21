<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Foundation\Auth\EmailVerificationRequest;

use App\Http\Middleware\AdminMiddleware;

use App\Http\Controllers\ProcessPayment;

use App\Livewire\Auth\Login;
use App\Http\Controllers\SocialAuthController;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\VerifyEmail;

use App\Livewire\Landing\HomePage;
use App\Livewire\Landing\Shop;

use App\Livewire\Landing\CartList;
use App\Livewire\Landing\Checkout;
use App\Livewire\Landing\PaymentNotice;

use App\Livewire\Landing\ProductDetail;
use App\Livewire\Landing\VendorDetail;
use App\Livewire\Landing\Support;
use App\Livewire\Landing\HowItWorks;
use App\Livewire\Account\Dashboard;

use App\Livewire\Account\Admin\Settings;
use App\Livewire\Account\Admin\Dealers\ListDealers;
use App\Livewire\Account\Admin\Dealers\DealerForm;
use App\Livewire\Account\Admin\Dealers\ViewDealer;
use App\Livewire\Account\Admin\Categories\ListCategories;
use App\Livewire\Account\Admin\Brands;
use App\Livewire\Account\Admin\Products\AdminPoductsList;
use App\Livewire\Account\Admin\Products\AdminPoductsView;
use App\Livewire\Account\Admin\Vendors\ListVendors;
use App\Livewire\Account\Admin\Vendors\ViewVendor;
use App\Livewire\Account\Admin\ListUsers;
use App\Livewire\Account\Admin\Withdrawals;

use App\Livewire\Account\Products\ProductForm;
use App\Livewire\Account\MyArmoury\MyArmoury;
use App\Livewire\Account\MyArmoury\EditMyArmoury;
use App\Livewire\Account\Orders;
use App\Livewire\Account\Purchases;
use App\Livewire\Account\Vault;
use App\Livewire\Account\Messages;
use App\Livewire\Account\MessageDetail;
use App\Livewire\Account\Profile;
use App\Livewire\Account\MyPromoCodes;

Route::get('/', HomePage::class);
Route::get('support', Support::class);
Route::get('how-it-works', HowItWorks::class);

Route::get('shop', Shop::class);
Route::get('shop/product/{id}', ProductDetail::class);
Route::get('cart', CartList::class);

Route::get('auth/login', Login::class)->name('login');
Route::get('auth/social-login/{social}', [SocialAuthController::class, 'socialLogin'])->where('social','facebook|google');
Route::get('auth/social-login/{social}/callback', [SocialAuthController::class, 'handleProviderCallback'])->where('social','facebook|google');
Route::get('auth/logout', [SocialAuthController::class, 'logout']);
Route::get('auth/register', Register::class);

Route::get('/email/verify', VerifyEmail::class)->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('pf-notify-payment/{id}', [ProcessPayment::class, 'pfPayment']);
Route::get('approve-withdrawal/{id}', [ProcessPayment::class, 'approveWithDrawal']);

Route::middleware(['auth', 'verified'])->group(function (){
	Route::get('dashboard', Dashboard::class)->name('dashboard');
    Route::get('add-product', ProductForm::class);
    
    Route::get('my-armoury', MyArmoury::class);
    Route::get('my-armoury/edit', EditMyArmoury::class);

    Route::get('my-orders', Orders::class);
    Route::get('my-purchases', Purchases::class);
    Route::get('my-vault', Vault::class);
    Route::get('messages', Messages::class);
    Route::get('messages/{id}', MessageDetail::class);
    Route::get('profile', Profile::class);
    Route::get('my-promo-codes', MyPromoCodes::class);

    Route::get('cart/{id}', Checkout::class);
    Route::get('cart/{id}/{order_id}', Checkout::class);
    Route::get('pf-payment/{id}/{status}', PaymentNotice::class);

    Route::middleware([AdminMiddleware::class])->group(function (){
        Route::get('settings', Settings::class);
        Route::get('admin/dealers', ListDealers::class);
        Route::get('admin/dealers/create', DealerForm::class);
        Route::get('admin/dealers/view/{id}', ViewDealer::class);

        Route::get('admin/categories', ListCategories::class);
        Route::get('admin/brands', Brands::class);

        Route::get('admin/products', AdminPoductsList::class);
        Route::get('admin/products/{id}', AdminPoductsView::class);

        Route::get('admin/vendors', ListVendors::class);
        Route::get('admin/vendors/{id}', ViewVendor::class);

        Route::get('admin/users', ListUsers::class);

        Route::get('admin/withdrawals', Withdrawals::class);
    });
});
Route::get('/{url_name}', VendorDetail::class);