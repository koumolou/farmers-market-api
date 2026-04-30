<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Responses\ApiResponse;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $categoryService) {}

    public function index()
    {
        
        $tree = $this->categoryService->getTree();
        return ApiResponse::success($tree);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categoryService->create($request->validated());
        return ApiResponse::success($category, 'Category created successfully', 201);
    }

    public function show(int $id)
    {
        $category = $this->categoryService->find($id);
        return ApiResponse::success($category);
    }

    public function update(UpdateCategoryRequest $request, int $id)
    {
        $category = $this->categoryService->update($id, $request->validated());
        return ApiResponse::success($category, 'Category updated successfully');
    }

    public function destroy(int $id)
    {
        $this->categoryService->delete($id);
        return ApiResponse::success(null, 'Category deleted successfully');
    }
}