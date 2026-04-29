<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function all() { return Product::with('category')->get(); }
    public function allWithCategory() { return Product::with('category.parent')->get(); }
    public function getByCategory(int $categoryId) {
        return Product::with('category')->where('category_id', $categoryId)->get();
    }
    public function findById(int $id) { return Product::with('category')->findOrFail($id); }
    public function create(array $data) { return Product::create($data); }
    public function update(int $id, array $data) {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product;
    }
    public function delete(int $id) { Product::findOrFail($id)->delete(); }
}