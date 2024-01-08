<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\Controller;

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



Route::get('/', [Controller::class, 'index']);
Route::get('/dashboard', [Controller::class, 'index']);



Route::get('/sales', [SaleController::class, 'index']);
Route::post('add', [SaleController::class, 'Add']);
Route::delete('delSale/{id}', [SaleController::class, 'Del']);
Route::put('updateSale/{id}', [SaleController::class, 'Update']);



Route::get('/products', [TypeController::class, 'index']);
Route::Delete('/deleteType', [TypeController::class, 'Delete']);
Route::post('/saveType', [TypeController::class, 'saveType'])->name('saveType');
Route::post('/editType', [TypeController::class, 'editType'])->name('editType');
Route::get('/DelType', [TypeController::class, 'DelType']);
Route::post('/undeleteType', [TypeController::class, 'undeleteType']);
Route::get('/typeProfile', [TypeController::class, 'typeProfile']);



Route::get('/Payments', [PaymentController::class, 'index']);
Route::post('/addPay', [PaymentController::class, 'Add']);
Route::delete('/delPay/{id}', [PaymentController::class, 'del']);
Route::get('/fetchPaymentData', [PaymentController::class, 'fetchPaymentData']);
Route::post('/editPay', [PaymentController::class, 'editPay']);



Route::get('/People', [PeopleController::class, 'index']);
Route::delete('/del', [PeopleController::class, 'Delete']);
Route::get('/DelTeam', [PeopleController::class, 'DelTeam']);
Route::post('/undel', [PeopleController::class, 'UnDelTeam']);
Route::post('/editTeam', [PeopleController::class, 'editTeam']);
Route::get('/AddTeam', [PeopleController::class, 'Add']);
Route::post('/saveTeam', [PeopleController::class, 'save']);
Route::get('/profile', [PeopleController::class, 'profile'])->name('profile');;





Route::get('/AddType', function () {
    return view('addType');
});



// Route::post('/sale', function () {
// })->name('sale');

