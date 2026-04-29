<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function all();
    public function findById(int $id);
    public function findByEmail(string $email);
    public function getByRole(string $role);                             
    public function getOperatorsBySupervisor(int $supervisorId);         
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
}