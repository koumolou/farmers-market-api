<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Repayment\StoreRepaymentRequest;
use App\Http\Responses\ApiResponse;
use App\Services\RepaymentService;

class RepaymentController extends Controller
{
    public function __construct(protected RepaymentService $repaymentService) {}

    public function store(StoreRepaymentRequest $request)
    {
        $repayment = $this->repaymentService->recordRepayment($request->validated());
        return ApiResponse::success($repayment, 'Repayment recorded successfully', 201);
    }

    public function farmerRepayments(int $farmerId)
    {
        $repayments = $this->repaymentService->getFarmerRepayments($farmerId);
        return ApiResponse::success($repayments);
    }
}