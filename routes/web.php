<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Foundation\Auth\EmailVerificationRequest;

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\EnsureHasVendor;

use App\Http\Controllers\ProcessPayment;

use App\Livewire\Auth\Login;
use App\Http\Controllers\SocialAuthController;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\VerifyEmail;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\PasswordReset;

use App\Livewire\Landing\UnsubscribeUser;

use App\Livewire\Landing\HomePage;
use App\Livewire\Landing\Shop;
use App\Livewire\Landing\PrivacyPolicy;
use App\Livewire\Landing\TermsConaditions;

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

use App\Livewire\Landing\WishList;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\User;

use App\Http\Controllers\FbController;
use App\Livewire\Auth\FbConfirmation;

Route::get('test', function(){
    $item = OrderItem::find(3);
    $order = Order::find(1);
    $user = user::find(2);
    $unsubscribe_link = '';

    $order_data = "<table class='table-bodered' style='width: 100%'>";
    $order_data .= "<thead><tr style='background-color: #e6e6e6;'><th colspan='2' style='text-align: center;'>AB-ORD-".str_pad($order->id, 4, '0', STR_PAD_LEFT)."</th></tr></thead>";
    $order_data .= "<tbody>";
    $order_data .= "<tr>";
    if($item->product->images->count() > 0){
        $order_data .= "<td><img style='height: 100px' src='".url('storage/'.$item->product->images->first()->image_url)."'></td>";
    }
    else{
        $order_data .= "<td></td>";
    }
    $order_data .= "<td>";
    $order_data .= "<table style='width: 100%; border:none; border-collapse:collapse;' border='0' cellpadding='5' cellspacing='0'>";
    $order_data .= "<tr><td style='border:none;'>Order Date:</td><td>".date('Y-m-d', strtotime($item->created_at))."</td></tr>";
    $order_data .= "<tr><td>Item Name:</td><td>".$item->product->item_name."</td></tr>";
    $order_data .= "<tr><td>Quantity:</td><td>".$item->quantity."</td></tr>";
    $order_data .= "<tr><td>Listed Price:</td><td>R ".number_format($item->product->item_price,2)."</td></tr>";
    $order_data .= "<tr><td>Sold Price:</td><td>R ".number_format($item->price,2)."</td></tr>";
    $order_data .= "<tr><td>Discount Applied:</td><td>".$item->discount."</td></tr>";
    $order_data .= "<tr><td>Delivery Type:</td><td>".$item->shipping_method."</td></tr>";
    $order_data .= "</table>";
    $order_data .= "</td>";
    $order_data .= "</tr>";
    $order_data .= "</table>";
    $body = "Looks like you have just <b>LEVELED UP!</b><br /><br />
    Great news! Your purchase has been confirmed, and your payment is now securely held in escrow. We've notified the seller to prepare your items for shipment.<br />
    ".$order_data;

    $after = "<b>What Happens Next?</b><br /><br />
    <b>Seller prepares your order</b><br />
    The seller has been notified and will prepare your items for delivery.<br /><br />
    <b>Track your shipment</b><br />
    The seller can add the tracking number to the purchase. Alternatively, send them a message to confirm.<br /><br />
    <b>Confirm receipt</b><br />
    When your order arrives, go to the \"My Purchases\" tab in your account and confirm receipt. This releases payment to the seller.";

    $data = [
        'to' => $user->email,
        'name' => $user->name,
        'subject' => 'Purchase Confirmation',
        'title' => "Congratulations on your purchase",
        'message_body' => $body,
        'cta' => true,
        'cta_text' => 'View Purchase',
        'cta_url' => url('my-purchases'),
        'after_cta_body' => $after,
        'unsubscribe_link' => '',
    ];
    return view('mail.comm', $data);
});

Route::get('/', HomePage::class);
Route::get('support', Support::class);
Route::get('how-it-works', HowItWorks::class);
Route::get('privacy-policy', PrivacyPolicy::class);
Route::get('terms-and-conditions', TermsConaditions::class);
Route::get('unsubscribe/{token}', UnsubscribeUser::class);

Route::get('shop', Shop::class)->name('shop');
Route::get('shop/product/{id}', ProductDetail::class);
Route::get('cart', CartList::class);

Route::get('auth/login', Login::class)->name('login');
Route::get('auth/social-login/{social}', [SocialAuthController::class, 'socialLogin'])->where('social','facebook|google');
Route::get('auth/social-login/{social}/callback', [SocialAuthController::class, 'handleProviderCallback'])->where('social','facebook|google');
Route::get('auth/logout', [SocialAuthController::class, 'logout'])->name('logout');
Route::get('auth/register', Register::class);
Route::get('auth/forgot-password', ForgotPassword::class);
Route::get('password-reset', PasswordReset::class)->name('password.reset');

Route::post('/keep-alive', function () {
    return response()->json(['status' => 'alive']);
})->name('keep-alive')->middleware('auth');

Route::get('/email/verify', VerifyEmail::class)->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('pf-notify-payment/{id}', [ProcessPayment::class, 'pfPayment']);
Route::post('pf-notify-payment-promo/{id}', [ProcessPayment::class, 'pfPromoPayment']);
Route::get('approve-withdrawal/{id}', [ProcessPayment::class, 'approveWithDrawal']);

Route::post('fb/delete', [FbController::class, 'delete']);
Route::get('fb-status/{token}', FbConfirmation::class);

Route::middleware(['auth', 'verified'])->group(function (){
	Route::get('my-armoury/edit', EditMyArmoury::class);
    Route::middleware([EnsureHasVendor::class])->group(function (){
        Route::get('dashboard', Dashboard::class)->name('dashboard');
        Route::get('list-item', ProductForm::class);
        Route::get('list-item/{id}', ProductForm::class);
        Route::get('wishlist', WishList::class);
        
        Route::get('my-armoury', MyArmoury::class);

        Route::get('my-orders', Orders::class);
        Route::get('my-purchases', Purchases::class);
        Route::get('my-vault', Vault::class);
        Route::get('messages', Messages::class);
        Route::get('messages/{id}', Messages::class);
        Route::get('messages/item', MessageDetail::class);
        Route::get('profile', Profile::class);
        Route::get('my-promo-codes', MyPromoCodes::class);
        Route::get('pf-payment-promo/{id}/{status}', MyPromoCodes::class);

        Route::get('cart/{id}', Checkout::class);
        Route::get('cart/{id}/{order_id}', Checkout::class);
        Route::get('pf-payment/{id}/{status}', PaymentNotice::class);
    });

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