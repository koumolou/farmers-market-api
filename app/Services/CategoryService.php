<?php

namespace App\Services;

use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryService
{
    public function __construct(
        protected CategoryRepositoryInterface $categoryRepository
    ) {}

    public function getTree()
    {
        // Returns only root categories with children eager-loaded recursively
        return $this->categoryRepository->getRoots();
    }

    public function getAll()
    {
        return $this->categoryRepository->all();
    }

    public function find(int $id)
    {
        return $this->categoryRepository->findById($id);
    }

    public function create(array $data)
    {
        return $this->categoryRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->categoryRepository->update($id, $data);
    }

    public function delete(int $id): void
    {
        $this->categoryRepository->delete($id);
    }
}