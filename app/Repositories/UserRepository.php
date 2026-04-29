<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function all() { return User::all(); }
    public function findById(int $id) { return User::findOrFail($id); }
    public function findByEmail(string $email) { return User::where('email', $email)->first(); }
    public function getByRole(string $role) { return User::where('role', $role)->get(); }
    public function getOperatorsBySupervisor(int $supervisorId) {
        return User::where('supervisor_id', $supervisorId)->where('role', 'operator')->get();
    }
    public function create(array $data) { return User::create($data); }
    public function update(int $id, array $data) {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }
    public function delete(int $id) { User::findOrFail($id)->delete(); }
}