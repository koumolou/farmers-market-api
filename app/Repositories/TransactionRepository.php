<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\Interfaces\TransactionRepositoryInterface;

class TransactionRepository implements TransactionRepositoryInterface
{
    public function all() {
        return Transaction::with('farmer', 'operator', 'items.product')->get();
    }

    public function findById(int $id) {
        return Transaction::with('farmer', 'operator', 'items.product', 'debt')->findOrFail($id);
    }

    public function findByReference(string $reference)    // ← was missing
    {
        return Transaction::where('reference', $reference)->first();
    }

    public function create(array $data) { return Transaction::create($data); }

    public function update(int $id, array $data)          // ← was missing
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update($data);
        return $transaction;
    }

    public function delete(int $id)                       // ← was missing
    {
        return Transaction::findOrFail($id)->delete();
    }
}