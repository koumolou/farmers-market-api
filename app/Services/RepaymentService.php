<?php

namespace App\Services;

use App\Models\Setting;
use App\Repositories\Interfaces\FarmerRepositoryInterface;
use App\Repositories\Interfaces\RepaymentRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RepaymentService
{
    public function __construct(
        protected RepaymentRepositoryInterface $repaymentRepository,
        protected FarmerRepositoryInterface    $farmerRepository,
    ) {}

    public function recordRepayment(array $data): \App\Models\Repayment
    {
        return DB::transaction(function () use ($data) {

            $farmer        = $this->farmerRepository->findById($data['farmer_id']);
            $kgReceived    = (float) $data['kg_received'];
            $commodityRate = (float) Setting::getValue('commodity_rate_per_kg', 1000);
            $fcfaValue     = $kgReceived * $commodityRate;

            // Verify farmer actually has debt
            $outstandingDebt = $farmer->outstandingDebt();
            if ($outstandingDebt <= 0) {
                throw ValidationException::withMessages([
                    'farmer_id' => ['This farmer has no outstanding debt.'],
                ]);
            }

            // Create the repayment record
            $repayment = $this->repaymentRepository->create([
                'farmer_id'      => $farmer->id,
                'operator_id'    => Auth::id(),
                'kg_received'    => $kgReceived,
                'commodity_rate' => $commodityRate,
                'fcfa_value'     => $fcfaValue,
            ]);

            // FIFO: get oldest open/partial debts first
            $debts = $farmer->debts()
                ->whereIn('status', ['open', 'partial'])
                ->orderBy('created_at', 'asc')
                ->get();

            $remaining = $fcfaValue;

            foreach ($debts as $debt) {
                if ($remaining <= 0) break;

                // How much can we apply to this debt?
                $apply = min($remaining, $debt->remaining_amount);

                // Record which debt this repayment touched and how much
                $repayment->debts()->attach($debt->id, [
                    'amount_applied' => $apply,
                ]);

                // Update the debt balance
                $debt->remaining_amount -= $apply;
                $debt->status = $debt->remaining_amount <= 0 ? 'settled' : 'partial';
                $debt->save();

                $remaining -= $apply;
            }

            return $repayment->load('debts.transaction', 'farmer');
        });
    }

    public function getFarmerRepayments(int $farmerId)
    {
        return $this->repaymentRepository->getByFarmer($farmerId);
    }
}