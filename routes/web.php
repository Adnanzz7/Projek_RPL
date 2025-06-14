<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\FeedbackController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AdminPurchaseController;
use App\Http\Controllers\PurchaseHistoryController;

Route::get('/', [BarangController::class, 'index'])->name('barangs.index');
Route::get('/barangs/create', [BarangController::class, 'create'])->name('barangs.create');
# Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/upload-foto', [ProfileController::class, 'uploadFoto'])->name('profile.uploadFoto');
    Route::put('/user/password', [UserController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('wishlist', WishlistController::class)->middleware('auth');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
Route::get('/purchase-history', [PurchaseHistoryController::class, 'index'])->name('history.index');
Route::get('/purchase/history', [PurchaseHistoryController::class, 'history'])->name('purchases.history');

Route::get('/purchase-history/export-pdf', [PurchaseHistoryController::class, 'exportPdf'])->name('history.exportPdf');
Route::get('/purchase-history/export-excel', [PurchaseHistoryController::class, 'exportExcel'])->name('history.exportExcel');


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/purchases-management', [AdminPurchaseController::class, 'index'])
        ->name('admin.purchases.management');

    Route::post('admin/purchase/{id}/update-status', [AdminPurchaseController::class, 'updateStatus'])
        ->name('admin.purchase.updateStatus');
});

Route::get('/', [BarangController::class, 'index'])->name('barangs.index');

Route::get('barangs/{id}/beli', [BarangController::class, 'beli'])->name('barangs.beli');

Route::post('/barangs/beli-massa', [BarangController::class, 'beliMassa'])->name('barangs.beli.massa');

Route::get('barangs/{barang}', [BarangController::class, 'show'])->name('barangs.show');

Route::post('keranjang/tambah', [BarangController::class, 'tambahKeKeranjang'])->name('keranjang.tambah');

Route::middleware(['auth', 'check.role:admin,supplier'])->group(function () {
    Route::resource('barangs', BarangController::class)->except(['index', 'show']);
    Route::resource('barangs', BarangController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('/barangs/create', [BarangController::class, 'create'])->name('barangs.create');
    Route::get('/barangs/{barang}/edit', [BarangController::class, 'edit'])->name('barangs.edit');
    Route::post('/barangs', [BarangController::class, 'store'])->name('barangs.store');
    Route::patch('/barangs/{barang}', [BarangController::class, 'update'])->name('barangs.update');
    Route::delete('/barangs/{barang}', [BarangController::class, 'destroy'])->name('barangs.destroy');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::post('/checkout/payment', [CheckoutController::class, 'processPayment'])->name('checkout.payment');
});

Route::get('/redirect-after-login', function () {
    $user = auth()->user();

    if ($user && $user->role === 'admin') {
        return redirect()->route('admin.pendit.purchases')->with('success', 'Selamat datang, Admin!');
    } elseif ($user && $user->role === 'supplier') {
        return redirect()->route('barangs.index')->with('success', 'Selamat datang, Supplier!');
    }

    return redirect()->route('barangs.index');
})->middleware(['auth']);

Route::post('/barangs/beli/konfirmasi', [BarangController::class, 'beliMassa'])->name('barangs.beli.massa');

Route::get('/barangs/beli/konfirmasi', [BarangController::class, 'konfirmasiPembelian'])->name('barangs.beli.konfirmasi');

Route::post('/barangs/beli/proses', [BarangController::class, 'prosesPembelian'])->name('barangs.beli.proses');

Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout')->middleware('auth');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/edit/{id}', [CartController::class, 'edit'])->name('cart.edit');
Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/checkout', [CartController::class, 'processCheckout'])->name('cart.checkout.process');
Route::post('/cancel', [CartController::class, 'cancel'])->name('cart.cancel');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/selesai', [CartController::class, 'selesai'])->name('cart.finish');
Route::get('/cart/selesai', [CartController::class, 'selesai'])->name('cart.finish.get');
Route::post('/cart/complete-checkout', [CartController::class, 'completeCheckout'])->name('cart.completeCheckout');
Route::get('/cart/download-pdf', [CartController::class, 'downloadPdf'])->name('cart.downloadPdf');
Route::get('/cart/success/{orderId}', [CartController::class, 'success'])
     ->name('cart.success');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/pembayaran-berhasil/{orderId}', [CartController::class, 'success'])->name('cart.success');
Route::get('/pembayaran-berhasil/{orderId}', [CartController::class, 'success'])->name('cart.success.get');
Route::post('/cart/add/{id}', [CartController::class, 'showAddForm'])->name('cart.add.form');
Route::get('/cart/add/{id}', [CartController::class, 'showAddForm'])->name('cart.add.form');
Route::post('/cart/add', [CartController::class, 'addFromForm'])->name('cart.addFromForm');
Route::post('/cart/payment', [CheckoutController::class, 'processPayment'])->name('cart.payment');

Route::get('pembayaran-berhasil/{id}/download', [CartController::class, 'downloadPdf'])->name('cart.downloadPdf');

Route::middleware(['auth', 'role:admin,supplier'])->group(function () {
    Route::resource('barangs', BarangController::class);
    Route::get('/barangs/create', [BarangController::class, 'create'])->name('barangs.create');
});

Route::get('/suggestion', [FeedbackController::class, 'create'])->name('suggestion.create');
Route::post('/suggestion', [FeedbackController::class, 'store'])->name('suggestion.store');
Route::get('/suggestion-list', [FeedbackController::class, 'showSuggestions'])->name('suggestion-list.index');

Route::resource('wishlist', WishlistController::class)->middleware('auth');
Route::post('wishlist/add/{barangId}', [WishlistController::class, 'add'])->name('wishlist.add');
Route::post('/wishlist/toggle/{barang}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::post('wishlist/store', [WishlistController::class, 'store'])->name('wishlist.store');
Route::post('/wishlist/move-to-cart/{id}', [WishlistController::class, 'moveToCart'])->name('wishlist.moveToCart');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('cart.success');


require __DIR__ . '/auth.php';
