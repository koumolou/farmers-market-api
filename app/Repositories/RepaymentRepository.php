<?php

namespace App\Repositories;

use App\Models\Repayment;
use App\Repositories\Interfaces\RepaymentRepositoryInterface;

class RepaymentRepository implements RepaymentRepositoryInterface
{
    public function create(array $data) { return Repayment::create($data); }
    public function getByFarmer(int $farmerId) {
        return Repayment::with('debts.transaction')
            ->where('farmer_id', $farmerId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}