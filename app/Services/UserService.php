<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {}

    public function createSupervisor(array $data): \App\Models\User
    {
        $data['password'] = Hash::make($data['password']);
        $data['role']     = 'supervisor';
        return $this->userRepository->create($data);
    }

    public function createOperator(array $data): \App\Models\User
    {
        $data['password']      = Hash::make($data['password']);
        $data['role']          = 'operator';
        $data['supervisor_id'] = Auth::id();
        return $this->userRepository->create($data);
    }

    public function getSupervisors()
    {
        return $this->userRepository->getByRole('supervisor');
    }

    public function getOperatorsBySupervisor(int $supervisorId)
    {
        return $this->userRepository->getOperatorsBySupervisor($supervisorId);
    }

    public function update(int $id, array $data): \App\Models\User
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $this->userRepository->update($id, $data);
    }

    public function delete(int $id): void
    {
        $this->userRepository->delete($id);
    }

    public function findById(int $id): \App\Models\User
{
    return $this->userRepository->findById($id);
}
}