<?php

namespace App\Repositories\Interfaces;

interface TransactionRepositoryInterface
{
    public function all();
    public function findById(int $id);
    public function findByReference(string $reference);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}