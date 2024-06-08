<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\TransactionsController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('createEmployees', [EmployeesController::class, 'createEmployees']);
Route::post('transaction/accept', [TransactionsController::class, 'acceptTransaction']);
Route::get('transaction/get-payouts', [TransactionsController::class, 'getPayouts']);
Route::get('transaction/repayment-all-debts', [TransactionsController::class, 'paymentAllEmployees']);
