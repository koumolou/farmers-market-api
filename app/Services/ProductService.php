<?php

namespace App\Services;

use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductService
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository
    ) {}

    public function getAll()
    {
        return $this->productRepository->allWithCategory();
    }

    public function getByCategory(int $categoryId)
    {
        return $this->productRepository->getByCategory($categoryId);
    }

    public function find(int $id)
    {
        return $this->productRepository->findById($id);
    }

    public function create(array $data)
    {
        return $this->productRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->productRepository->update($id, $data);
    }

    public function delete(int $id): void
    {
        $this->productRepository->delete($id);
    }
}