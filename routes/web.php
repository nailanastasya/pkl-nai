<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NodinController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// -----------------------------
// Login routes
// -----------------------------

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'login'])->name('login');

Route::post('/actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');
Route::get('/actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');

// -----------------------------
// Home route
// -----------------------------
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// -----------------------------
// Customers
// -----------------------------
Route::get('/customers', [CustomerController::class, 'index'])->name('customer.index');
Route::get('/customer/create', [CustomerController::class, 'create'])->name('customer.create');
Route::post('/customer/store', [CustomerController::class, 'store'])->name('customer.store');
Route::get('/customer/prospects', [CustomerController::class, 'prospects'])->name('customer.prospects');

Route::get('/customers/search', [CustomerController::class, 'searchAccepted'])->name('customer.search');
Route::get('/prospects/search', [CustomerController::class, 'searchPending'])->name('prospects.search');

Route::post('customer/{id}/accept', [CustomerController::class, 'accept'])->name('customer.accept');
Route::get('/customer/{id}', [CustomerController::class, 'show'])->name('customer.show');
Route::get('/customer/{id}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
Route::put('/customer/{id}', [CustomerController::class, 'update'])->name('customer.update');
Route::delete('/customer/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');
Route::patch('/customers/{id}/cancel', [CustomerController::class, 'cancel'])->name('customer.cancel');

Route::get('/customers/trashed', [CustomerController::class, 'trashed'])->name('customer.trashed');
Route::post('/customers/{id}/restore', [CustomerController::class, 'restore'])->name('customer.restore');

// -----------------------------
// Products
// -----------------------------
Route::get('/product', [ProductController::class, 'index'])->name('product.index');
Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
Route::post('/product', [ProductController::class, 'store'])->name('product.store');
Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product.edit');
Route::put('/product/{id}', [ProductController::class, 'update'])->name('product.update');
Route::get('/product/search', [ProductController::class, 'search'])->name('product.search');
Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');

// -----------------------------
// Quotations
// -----------------------------
Route::delete('/quotation/{id}', [QuotationController::class, 'destroy'])->name('quotation.destroy');

// -----------------------------
// Activity Logs
// -----------------------------
Route::get('/activity', [ActivityLogController::class, 'index'])->name('log.index');
Route::delete('/activity/{id}', [ActivityLogController::class, 'destroy'])->name('log.destroy');
Route::get('/activity/search', [ActivityLogController::class, 'search'])->name('log.search');
Route::delete('/logs/clear-all', [ActivityLogController::class, 'clearAll'])->name('logs.clear-all');

// -----------------------------
// Users
// -----------------------------
Route::get('/users', [UserController::class, 'index'])->name('user.index');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user', [UserController::class, 'store'])->name('user.store');
Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
Route::get('/user/list', [UserController::class, 'list'])->name('user.list');
Route::get('/user/search', [UserController::class, 'search'])->name('user.search');
Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

// -----------------------------
// Purchase Orders
// -----------------------------
Route::get('/po', [PurchaseOrderController::class, 'index'])->name('purchase-order.index');
Route::delete('/po/{id}', [PurchaseOrderController::class, 'destroy'])->name('purchase-order.destroy');

// -----------------------------
// Nodin
// -----------------------------
Route::get('/nodin', [NodinController::class, 'index'])->name('nodin.index');
Route::get('/nodin/create', [NodinController::class, 'create'])->name('nodin.create');
Route::post('/nodin', [NodinController::class, 'store'])->name('nodin.store');
Route::get('/nodin/{id}/edit', [NodinController::class, 'edit'])->name('nodin.edit');
Route::put('/nodin/{id}', [NodinController::class, 'update'])->name('nodin.update');
Route::delete('/nodin/{id}', [NodinController::class, 'destroy'])->name('nodin.destroy');
Route::get('/nodin/search', [NodinController::class, 'search'])->name('nodin.search');

// -----------------------------
// Invoices
// -----------------------------
Route::get('/invoice', [InvoiceController::class, 'index'])->name('invoice.index');
Route::get('/invoice/create', [InvoiceController::class, 'create'])->name('invoice.create');
Route::post('/invoice', [InvoiceController::class, 'store'])->name('invoice.store');
Route::get('/invoice/{id}', [InvoiceController::class, 'show'])->name('invoice.show');
Route::get('/invoice/{id}/edit', [InvoiceController::class, 'edit'])->name('invoice.edit');
Route::put('/invoice/{id}', [InvoiceController::class, 'update'])->name('invoice.update');
Route::delete('/invoice/{id}', [InvoiceController::class, 'destroy'])->name('invoice.destroy');
Route::get('/invoice/search', [InvoiceController::class, 'search'])->name('invoice.search');
Route::get('invoices/archive', [InvoiceController::class, 'archiveIndex'])->name('invoice.archiveIndex');
Route::patch('invoice/{id}/archive', [InvoiceController::class, 'archive'])->name('invoice.archive');
Route::patch('invoice/{id}/unarchive', [InvoiceController::class, 'unarchive'])->name('invoice.unarchive');

// -----------------------------
// Receipts
// -----------------------------
Route::post('/invoices/{invoice}/receipts', [ReceiptController::class, 'store'])->name('receipt.store');

// -----------------------------
// Profile (protected)
// -----------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
