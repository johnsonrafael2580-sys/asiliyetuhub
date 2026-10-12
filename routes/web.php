<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArtisanController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\FulfillmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WhatsAppIntegrationController;
use App\Http\Controllers\WithdrawalController;
use App\Models\Product;
use App\Models\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/language/{locale}', function (string $locale) {
    abort_unless(in_array($locale, ['en', 'sw'], true), 404);

    session(['locale' => $locale]);

    return back();
})->name('language.switch');

Route::get('/products/{product}', function (Product $product) {
    $artisanProducts = Product::where('user_id', $product->user_id)
        ->where('id', '!=', $product->id)
        ->latest()
        ->take(8)
        ->get();

    $galleryImages = $product->galleryImages ?? collect();

    return view(
        'products.show',
        compact('product', 'artisanProducts', 'galleryImages')
    );
})->name('products.show');

Route::post('/reviews', [ReviewController::class, 'store'])
    ->name('reviews.store');

Route::get('/products/{product}/reviews', [
    ReviewController::class,
    'fetchReviews',
])->name('reviews.fetch');

Route::post('/products/{product}/request', [
    ProductRequestController::class,
    'store',
])->name('product.request');




Route::view('/shipping-and-delivery', 'pages.shipping')
    ->name('shipping');

Route::view('/authenticity-guarantee', 'pages.authenticity')
    ->name('authenticity');

Route::view('/privacy-policy', 'pages.privacy')
    ->name('privacy');

Route::view('/terms-of-service', 'pages.terms')
    ->name('terms');




Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');

Route::post('/cart/add/{id}', [CartController::class, 'add'])
    ->name('cart.add');

Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])
    ->name('cart.remove');

Route::delete('/cart/empty', [CartController::class, 'emptyCart'])
    ->name('cart.empty');

Route::get('/checkout', [CheckoutController::class, 'index'])
    ->name('checkout.index');

Route::post('/cart/checkout', [CartController::class, 'checkout'])
    ->name('cart.checkout');

Route::get('/order/{order}/confirmation', [
    CartController::class,
    'confirmation',
])->name('order.confirmation');



Route::get('/payments/pesapal/callback', [
    PaymentController::class,
    'handleCallback',
])->name('payment.callback');

Route::get('/payments/pesapal/ipn', [
    PaymentController::class,
    'handleIpnNotification',
])->name('payment.ipn');

Route::get('/payments/pesapal/cancel', [
    PaymentController::class,
    'handleCancel',
])->name('payment.cancel');



Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->role === 'artisan') {
            return redirect()->route('artisan.dashboard');
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin.payments.index');
        }

        return redirect()->route('customer.dashboard');
    })->name('dashboard');

    Route::get('/customer/dashboard', [
        CustomerDashboardController::class,
        'index',
    ])->name('customer.dashboard');

});



Route::middleware(['auth'])->group(function () {


    Route::match(
        ['get', 'post'],
        '/logout',
        [AuthenticatedSessionController::class, 'destroy']
    )->name('logout');


   

    Route::get('/orders/{order}', [
        OrderController::class,
        'show',
    ])->name('orders.show');

    Route::get('/orders/{order}/payment', [
        PaymentController::class,
        'show',
    ])->name('orders.payment');

    Route::get('/orders/{order}/payment-status', [
        PaymentController::class,
        'status',
    ])->name('orders.payment.status');

    Route::post('/payments/pesapal/initiate', [
        PaymentController::class,
        'initiatePayment',
    ])->name('payment.initiate');

    Route::post('/orders/{order}/payment/submit', [
        PaymentController::class,
        'initiate',
    ])->name('orders.payment.submit');


   

    Route::post('/orders/{order}/mark-delivered', [
        OrderController::class,
        'markDelivered',
    ])->name('orders.mark-delivered');

    Route::get('/orders/{order}/settlement', [
        OrderController::class,
        'getSettlement',
    ])->name('orders.settlement');

    Route::post('/orders/{order}/cancel', [
        OrderController::class,
        'cancel',
    ])->name('orders.cancel');

    Route::patch('/orders/{order}/hide', [
        OrderController::class,
        'hide',
    ])->name('orders.hide');

    Route::patch('/orders/{order}/restore', [
        OrderController::class,
        'restore',
    ])->name('orders.restore');



    Route::get('/admin/pending-users', [
        AdminController::class,
        'pendingUsers',
    ])->name('admin.pending.users');

    Route::patch('/admin/users/{id}/approve', [
        AdminController::class,
        'approveUser',
    ])->name('admin.users.approve');

    Route::delete('/admin/users/{id}/reject', [
        AdminController::class,
        'rejectUser',
    ])->name('admin.users.reject');

    Route::get('/admin/payments', [
        PaymentController::class,
        'adminIndex',
    ])->name('admin.payments.index');

    Route::post('/admin/payments/{payment}/verify', [
        PaymentController::class,
        'verify',
    ])->name('admin.payments.verify');

    Route::post('/admin/payments/{payment}/reject', [
        PaymentController::class,
        'reject',
    ])->name('admin.payments.reject');



    Route::middleware(['artisan', 'verified'])->group(function () {

        Route::get('/commissions', [
            CommissionController::class,
            'index',
        ])->name('commissions.index');

        Route::get('/commissions/{commission}', [
            CommissionController::class,
            'show',
        ])->name('commissions.show');

        Route::post('/commissions/{commission}/mark-completed', [
            CommissionController::class,
            'markCompleted',
        ])->name('commissions.mark-completed');

    });


   

    Route::get('/fulfillments', [
        FulfillmentController::class,
        'index',
    ])->name('fulfillments.index');

    Route::get('/fulfillments/{fulfillment}', [
        FulfillmentController::class,
        'show',
    ])->name('fulfillments.show');

    Route::get(
        '/product-requests/{productRequest}/fulfillments/create',
        [FulfillmentController::class, 'create']
    )->name('fulfillments.create');

    Route::post('/fulfillments', [
        FulfillmentController::class,
        'store',
    ])->name('fulfillments.store');

    Route::patch('/fulfillments/{fulfillment}/status', [
        FulfillmentController::class,
        'updateStatus',
    ])->name('fulfillments.update-status');

    Route::post('/fulfillments/{fulfillment}/mark-delivered', [
        FulfillmentController::class,
        'markDelivered',
    ])->name('fulfillments.mark-delivered');


    

    Route::post('/product-requests/{productRequest}/complete', [
        ProductRequestController::class,
        'markCompleted',
    ])->name('product-requests.complete');


    
    Route::middleware(['artisan', 'verified'])->group(function () {

        Route::get('/artisan/dashboard', [
            ArtisanController::class,
            'index',
        ])->name('artisan.dashboard');

        Route::post('/artisan/products', [
            ArtisanController::class,
            'storeProduct',
        ])->name('artisan.products.store');

        Route::delete('/artisan/products/{product}', [
            ArtisanController::class,
            'destroyProduct',
        ])->name('artisan.products.destroy');

        Route::patch('/artisan/orders/{order}/status', [
            ArtisanController::class,
            'updateOrderStatus',
        ])->name('artisan.orders.updateStatus');

        Route::post('/artisan/test-request', function (Request $request) {

            $product = Product::where(
                'user_id',
                $request->user()->id
            )->first();

            abort_unless($product, 404, 'No product found.');

            $productRequest = ProductRequest::create([
                'product_id' => $product->id,
                'user_id' => null,
                'customer_name' => 'Automated Test Customer',
                'customer_phone' => '255700000000',
                'message' => 'Temporary test request.',
                'status' => 'pending',
            ]);

            return back()->with(
                'success',
                'Test request created: #' . $productRequest->id
            );

        })->name('artisan.test-request');

    });



    Route::middleware(['artisan', 'verified'])->group(function () {

        Route::get('/whatsapp/configure', [
            WhatsAppIntegrationController::class,
            'configure',
        ])->name('whatsapp.configure');

        Route::post('/whatsapp/settings', [
            WhatsAppIntegrationController::class,
            'storeSettings',
        ])->name('whatsapp.settings.store');

        Route::post('/products/{product}/send-whatsapp-alert', [
            WhatsAppIntegrationController::class,
            'sendProductAlert',
        ])->name('whatsapp.send-product-alert');

    });

    Route::post('/whatsapp/webhook', [
        WhatsAppIntegrationController::class,
        'handleIncomingMessage',
    ])->name('whatsapp.webhook');


    

    Route::get('/profile', [
        ProfileController::class,
        'edit',
    ])->name('profile.edit');

    Route::patch('/profile', [
        ProfileController::class,
        'update',
    ])->name('profile.update');

    Route::delete('/profile', [
        ProfileController::class,
        'destroy',
    ])->name('profile.destroy');


    
    Route::post('/notifications/mark-all-read', [
        NotificationController::class,
        'markAllRead',
    ])->name('notifications.mark-all-read');

    Route::post('/notifications/{id}/mark-read', [
        NotificationController::class,
        'markAsRead',
    ])->name('notifications.mark-read');

    Route::post('/notifications/{id}/email', [
        NotificationController::class,
        'emailNotification',
    ])->name('notifications.email');



    Route::get('/withdrawals', [
        WithdrawalController::class,
        'index',
    ])->name('withdrawals.index');

    Route::post('/withdrawals', [
        WithdrawalController::class,
        'store',
    ])->name('withdrawals.store');

});




require __DIR__ . '/auth.php';
