<?php
namespace App\Repositories\Interfaces;

interface FarmerRepositoryInterface
{
    public function all();
    public function findById(int $id);
    public function findByIdentifier(string $identifier);
    public function findByPhone(string $phone);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}