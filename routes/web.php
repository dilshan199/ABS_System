<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\OuathController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuotationController;
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

Route::get('/', function () {
    return view('welcome');
})->middleware('checkOauth');

/**
 * Category routes
*/
Route::get('/category/create', [CategoryController::class, 'index'])->name('category.index')->middleware('checkOauth');
Route::post('/category/save', [CategoryController::class, 'store'])->name('category.store');
Route::get('/category/edit/{cat_id}', [CategoryController::class, 'edit'])->name('category.edit');
Route::post('/category/update/{cat_id}', [CategoryController::class, 'update'])->name('category.update');
Route::get('/category/delete/{cat_id}', [CategoryController::class, 'destroy'])->name('category.destroy');

/**
 * Product routes
*/
Route::get('/product/insert', [ProductController::class, 'index'])->name('product.index')->middleware('checkOauth');
Route::post('/product/save', [ProductController::class, 'store'])->name('product.store');
Route::get('/product/edit/{p_id}', [ProductController::class, 'edit'])->name('product.edit');
Route::post('/product/update/{p_id}', [ProductController::class, 'update'])->name('product.update');
Route::get('/product/delete/{p_id}', [ProductController::class, 'destroy'])->name('product.destroy');
Route::post('/product/search', [ProductController::class, 'search'])->name('product.search');

/**
 * Oauth routes
 */
Route::get('/oauth/create', [OuathController::class, 'index'])->name('oauth.index');
Route::post('/oauth/save', [OuathController::class, 'store'])->name('oauth.store');
Route::get('/oauth/edit/{id}', [OuathController::class, 'edit'])->name('oauth.edit');
Route::post('/oauth/update/{id}', [OuathController::class, 'update'])->name('oauth.update');
Route::get('/oauth/delete/{id}', [OuathController::class, 'destroy'])->name('oauth.destory');
Route::get('/oauth/sign-in', function(){return view('oauth.login'); })->name('oauth.sign-in');
Route::post('/oauth/login', [OuathController::class, 'signIn'])->name('oauth.login');
Route::get('/oauth/sign-out', [OuathController::class, 'signOut'])->name('oauth.logout');
Route::get('/', [OuathController::class, 'home'])->name('welcome')->middleware('checkOauth');

/**
 * Quotation routes
 */
Route::get('/quotation/create', [QuotationController::class, 'quotationPage'])->name('quotation.create');
Route::post('/quotation/vehicle-quotation', [QuotationController::class, 'getAllQuotation'])->name('quotation.relatedQuotation');
Route::post('/quotation/search-item', [QuotationController::class, 'getTypeItem'])->name('quotation.select-item');
Route::get('/quotation/get-item/{p_id}', [QuotationController::class, 'getItem'])->name('quotation.get-item');
Route::post('/quotation/add-cart', [QuotationController::class, 'addToCart'])->name('quotation.add-cart');
Route::get('/quotation/emptyCart', [QuotationController::class, 'emptyCart'])->name('quotation.empty-cart');
Route::post('/quotation/save', [QuotationController::class, 'store'])->name('quotation.store');
Route::post('/quotation/edit-quotation', [QuotationController::class, 'edit'])->name('quotation.edit-quotation');
Route::get('/quotation/remove-item/{c_id}', [QuotationController::class, 'removeCartItem'])->name('quotation.remove');
Route::post('/quotation/get-quotation/{quotation_id}', [QuotationController::class, 'getOldQuotation'])->name('quotation.get-quotation');
Route::get('/quotation/delete/{quotation_id}', [QuotationController::class, 'destroy'])->name('quotation.destroy');
/**
 * Invoice routes
*/
Route::get('/invoice/create', [InvoiceController::class, 'invoicePage'])->name('invoice.create');
Route::post('/invoice/save', [InvoiceController::class, 'store'])->name('invoice.store');
Route::get('/invoice/delete/{invoice_id}', [InvoiceController::class, 'destroy'])->name('invoice.destroy');
Route::post('/invoice/search-by-job', [InvoiceController::class, 'getByJobNo'])->name('invoice.get-by-job-no');
Route::post('/invoice/search-by-quotation', [InvoiceController::class, 'getByQuotationNo'])->name('invoice.get-by-quotation');
Route::post('/invoice/search-by-customer', [InvoiceController::class, 'invoiceByCustomerName'])->name('invoice.invoice-by-customer');
Route::post('/invoice/search-by-vehicle', [InvoiceController::class, 'invoiceByVehicleNo'])->name('invoice.invoice-by-vehicle');
Route::post('/invoice/search', [InvoiceController::class, 'edit'])->name('invoice.edit');
Route::post('/invoice/add-to-cart', [InvoiceController::class, 'addToCart'])->name('invoice.add-to-cart');
Route::post('/invoice/pay', [InvoiceController::class, 'payment'])->name('invoice.pay');
Route::post('/invoice/search-item', [InvoiceController::class, 'searchItem'])->name('invoice.search-item');
Route::get('/invoice/get-item/{p_id}', [InvoiceController::class, 'getItem'])->name('invoice.get-item');
Route::post('/invoice/search-customer', [InvoiceController::class, 'searchCustomer'])->name('invoice.search-customer');
Route::get('/invoice/get-customer/{customer_id}', [InvoiceController::class, 'getCustomer'])->name('invoice.get-customer');
Route::get('/invoice/remove-cart-item/{c_id}', [InvoiceController::class, 'removeCartItem'])->name('invoice.remove-cart-item');
Route::get('invoice/new', [InvoiceController::class, 'newInvoice'])->name('invoice.new');
Route::post('/invoice/calculater', [InvoiceController::class, 'calculator'])->name('invoice.calculater');
Route::post('/invoice/get-invoice/{invoice_id}', [InvoiceController::class, 'getOldInvoive'])->name('invoice.get-invoice');
Route::get('/invoice/print', function(){return view('invoice.print');})->name('invoice.print');


/**
 * Job routes
*/
Route::get('/job/create', [JobController::class, 'jobPage'])->name('job.create');
Route::post('/job/save', [JobController::class, 'store'])->name('job.store');
Route::post('/job/job-search', [JobController::class, 'show'])->name('job.show');
Route::post('/job/job-by-vehicle', [JobController::class, 'vehicleJobs'])->name('job.job-by-vehicle');
Route::get('/job/delete/{job_id}', [JobController::class, 'destroy'])->name('job.destroy');
Route::post('/job/job-by-customer', [JobController::class, 'jobSearchByName'])->name('job.job-by-customer');
Route::post('/job/search-customer', [JobController::class, 'autoCustomerSearch'])->name('job.search-customer');
Route::get('/job/get-customer/{customer_id}', [JobController::class ,'getCustomer'])->name('job.get-customer');
Route::post('/job/get-job/{job_id}', [JobController::class, 'getOldJob'])->name('job.get-job');
Route::get('/job/new', [JobController::class, 'newJobPage'])->name('job.new');
Route::post('/job/done', [JobController::class, 'markCompleteJob'])->name('job.done');
