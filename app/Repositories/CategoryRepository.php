<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function all() { return Category::all(); }

    public function getRoots(): \Illuminate\Database\Eloquent\Collection {
        return Category::with('children.children')
            ->whereNull('parent_id')
            ->get();
    }

    public function findById(int $id) { return Category::with('children')->findOrFail($id); }

    public function create(array $data) { return Category::create($data); }

    public function update(int $id, array $data) {
        $cat = Category::findOrFail($id);
        $cat->update($data);
        return $cat;
    }

    public function delete(int $id): bool  
    {
        return (bool) Category::findOrFail($id)->delete();
    }
}