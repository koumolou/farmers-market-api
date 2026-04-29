<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Farmer\StoreFarmerRequest;
use App\Http\Requests\Farmer\UpdateFarmerRequest;
use App\Http\Responses\ApiResponse;
use App\Services\FarmerService;

class FarmerController extends Controller
{
    public function __construct(protected FarmerService $farmerService) {}

    public function index()
    {
        return ApiResponse::success($this->farmerService->getAll());
    }

    public function store(StoreFarmerRequest $request)
    {
        $farmer = $this->farmerService->create($request->validated());
        return ApiResponse::success($farmer, 'Farmer created successfully', 201);
    }

    public function show(int $id)
    {
        return ApiResponse::success($this->farmerService->getProfile($id));
    }

    public function update(UpdateFarmerRequest $request, int $id)
    {
        $farmer = $this->farmerService->update($id, $request->validated());
        return ApiResponse::success($farmer, 'Farmer updated successfully');
    }

    public function search(\Illuminate\Http\Request $request)
    {
        $request->validate(['query' => 'required|string|min:2']);
        $farmer = $this->farmerService->search($request->query('query'));
        return ApiResponse::success($farmer);
    }
}