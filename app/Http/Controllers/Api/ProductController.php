<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Responses\ApiResponse;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService) {}

    public function index(Request $request)
    {
        // Optional filter by category_id: GET /api/products?category_id=3
        if ($request->has('category_id')) {
            $products = $this->productService->getByCategory((int) $request->category_id);
        } else {
            $products = $this->productService->getAll();
        }

        return ApiResponse::success($products);
    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->create($request->validated());
        return ApiResponse::success($product, 'Product created successfully', 201);
    }

    public function show(int $id)
    {
        $product = $this->productService->find($id);
        return ApiResponse::success($product);
    }

    public function update(UpdateProductRequest $request, int $id)
    {
        $product = $this->productService->update($id, $request->validated());
        return ApiResponse::success($product, 'Product updated successfully');
    }

    public function destroy(int $id)
    {
        $this->productService->delete($id);
        return ApiResponse::success(null, 'Product deleted successfully');
    }
}