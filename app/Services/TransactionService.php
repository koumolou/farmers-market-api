<?php

namespace App\Services;

use App\Models\Debt;
use App\Models\Setting;
use App\Repositories\Interfaces\FarmerRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransactionService
{
    public function __construct(
        protected TransactionRepositoryInterface $transactionRepository,
        protected FarmerRepositoryInterface      $farmerRepository,
        protected ProductRepositoryInterface     $productRepository,
    ) {}

    public function checkout(array $data): \App\Models\Transaction
    {
        return DB::transaction(function () use ($data) {

            $farmer        = $this->farmerRepository->findById($data['farmer_id']);
            $paymentMethod = $data['payment_method'];
            $items         = $data['items']; // [['product_id' => 1, 'quantity' => 2], ...]

            // 1. Calculate subtotal from real product prices
            $subtotal = 0;
            $lineItems = [];

            foreach ($items as $item) {
                $product   = $this->productRepository->findById($item['product_id']);
                $lineTotal = $product->price * $item['quantity'];
                $subtotal += $lineTotal;

                $lineItems[] = [
                    'product_id' => $product->id,
                    'quantity'   => $item['quantity'],
                    'unit_price' => $product->price,
                    'subtotal'   => $lineTotal,
                ];
            }

            // 2. Apply interest if credit
            $interestRate   = null;
            $interestAmount = 0;
            $grandTotal     = $subtotal;

            if ($paymentMethod === 'credit') {
                $interestRate   = (float) Setting::getValue('interest_rate', 0.30);
                $interestAmount = $subtotal * $interestRate;
                $grandTotal     = $subtotal + $interestAmount;

                // 3. Credit limit enforcement — BLOCK if exceeded
                $currentDebt = $farmer->outstandingDebt();
                if (($currentDebt + $grandTotal) > $farmer->credit_limit) {
                    throw ValidationException::withMessages([
                        'credit_limit' => [
                            sprintf(
                                'Credit limit exceeded. Current debt: %s FCFA, New debt: %s FCFA, Limit: %s FCFA.',
                                number_format($currentDebt, 2),
                                number_format($grandTotal, 2),
                                number_format($farmer->credit_limit, 2)
                            )
                        ],
                    ]);
                }
            }

            // 4. Create the transaction
            $transaction = $this->transactionRepository->create([
                'farmer_id'      => $farmer->id,
                'operator_id'    => Auth::id(),
                'payment_method' => $paymentMethod,
                'subtotal'       => $subtotal,
                'interest_rate'  => $interestRate,
                'interest_amount'=> $interestAmount,
                'grand_total'    => $grandTotal,
            ]);

            // 5. Create transaction items
            foreach ($lineItems as $lineItem) {
                $transaction->items()->create($lineItem);
            }

            // 6. Create debt record if credit
            if ($paymentMethod === 'credit') {
                Debt::create([
                    'farmer_id'       => $farmer->id,
                    'transaction_id'  => $transaction->id,
                    'original_amount' => $grandTotal,
                    'remaining_amount'=> $grandTotal,
                    'status'          => 'open',
                ]);
            }

            return $transaction->load('items.product', 'farmer', 'operator', 'debt');
        });
    }
}