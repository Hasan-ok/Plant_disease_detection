<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DetectionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController; 
use App\Http\Controllers\ProductUserController;
use App\Http\Controllers\ExpertUserController;
use App\Http\Controllers\Gardener\GardenerController;
use App\Http\Controllers\Gardener\TreatmentController;
use App\Http\Controllers\TreatmentUserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('home');
})->name('home');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.show.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/login', function (){
    return view('login');
})->name('login');

require __DIR__.'/auth.php';

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::middleware(['web'])->group(function () {

    Route::get('/detect', [DetectionController::class, 'index'])->name('detection.upload');
    Route::post('/detect', [DetectionController::class, 'detectDisease'])->name('detection.detect');
    Route::get('/result', [DetectionController::class, 'showResult'])->name('detection.result');

    Route::middleware(['auth'])->group(function () {
        Route::get('/detect/history', [DetectionController::class, 'history'])->name('detection.history');
        Route::delete('/detect/history/{id}', [DetectionController::class, 'deleteHistory'])->name('detection.history.delete');
        Route::get('/detect/history/export', [DetectionController::class, 'exportHistory'])->name('detection.history.export');
        Route::post('/detect/save', [DetectionController::class, 'saveResult'])->name('detection.save');
    });
});

Route::get('/history', function(){
    return view('history');
});


Route::get('/redirect-by-role', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect('/admin/dashboard');
    } elseif ($user->role === 'gardener') {
        return redirect('/gardener/dashboard');
    } else {
        return redirect('/');
    }
})->middleware('auth');


Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    Route::get('/experts', [AdminController::class, 'experts'])->name('experts');
    Route::get('/experts/create', [AdminController::class, 'createExpert'])->name('experts.create');
    Route::post('/experts', [AdminController::class, 'storeExpert'])->name('experts.store');
    Route::get('/experts/{expert}', [AdminController::class, 'showExpert'])->name('experts.show');
    Route::get('/experts/{expert}/edit', [AdminController::class, 'editExpert'])->name('experts.edit');
    Route::put('/experts/{expert}', [AdminController::class, 'updateExpert'])->name('experts.update');
    Route::delete('/experts/{expert}', [AdminController::class, 'destroyExpert'])->name('experts.destroy');

    Route::get('/messages', [AdminController::class, 'messages'])->name('messages.index');

    Route::resource('users', UserController::class);

});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
});

Route::get('/products', [ProductUserController::class, 'index'])->name('products.index');

Route::get('/experts', [ExpertUserController::class, 'index'])->name('experts.index');

Route::middleware(['auth'])->prefix('gardener')->name('gardener.')->group(function () {
    Route::get('/dashboard', [GardenerController::class, 'dashboard'])->name('dashboard');
    Route::resource('/treatments', TreatmentController::class);
});

Route::get('/treatments', [TreatmentUserController::class, 'index'])->name('treatments.index');

Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');

Route::middleware(['auth'])->group(function () {
    Route::resource('appointments', AppointmentController::class)->except(['create']);
});

Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{productId}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('/payment-success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment-cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
});
