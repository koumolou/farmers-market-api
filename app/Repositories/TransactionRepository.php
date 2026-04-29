<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\Interfaces\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function all() { return Transaction::all(); }

    public function findById(int $id) { return Transaction::findOrFail($id); }

    public function findByReference(string $reference)
    {
        return Transaction::where('reference', $reference)->first();
    }

    public function create(array $data) { return Transaction::create($data); }

    public function update(int $id, array $data)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update($data);
        return $transaction;
    }

    public function delete(int $id)
    {
        return Transaction::findOrFail($id)->delete();
    }
}