<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\CheckoutRequest;
use App\Http\Responses\ApiResponse;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    public function __construct(protected TransactionService $transactionService) {}

    public function checkout(CheckoutRequest $request)
    {
        $transaction = $this->transactionService->checkout($request->validated());
        return ApiResponse::success($transaction, 'Transaction completed successfully', 201);
    }
}