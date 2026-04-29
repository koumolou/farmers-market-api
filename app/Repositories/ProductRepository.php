<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function all() { return Product::all(); }

    public function findById(int $id) { return Product::findOrFail($id); }

    public function findByName(string $name)
    {
        return Product::where('name', $name)->first();
    }

    public function create(array $data) { return Product::create($data); }

    public function update(int $id, array $data)
    {
        $product = Product::findOrFail($id);
        $product->update($data);
        return $product;
    }

    public function delete(int $id)
    {
        return Product::findOrFail($id)->delete();
    }
}