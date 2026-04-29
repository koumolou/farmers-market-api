<?php

namespace App\Repositories;

use App\Models\Debt;
use App\Repositories\Interfaces\DebtRepositoryInterface;

class DebtRepository implements DebtRepositoryInterface
{
    public function all() { return Debt::all(); }

    public function findById(int $id) { return Debt::findOrFail($id); }

    public function findByFarmer(int $farmerId)
    {
        return Debt::where('farmer_id', $farmerId)->get();
    }

    public function create(array $data) { return Debt::create($data); }

    public function update(int $id, array $data)
    {
        $debt = Debt::findOrFail($id);
        $debt->update($data);
        return $debt;
    }

    public function delete(int $id)
    {
        return Debt::findOrFail($id)->delete();
    }
}