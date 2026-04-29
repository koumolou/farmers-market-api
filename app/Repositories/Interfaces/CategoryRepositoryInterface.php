<?php

namespace App\Repositories\Interfaces;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    public function all();
    public function findById(int $id);
   public function getRoots(): Collection;
   
    public function create(array $data);
    public function update(int $id, array $data);
   public function delete(int $id): bool;
}