<?php

namespace App\Repositories\Interfaces;

interface DebtRepositoryInterface
{
    public function all();
    public function findById(int $id);
    public function findByFarmer(int $farmerId);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}