<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Farmer;
use App\Models\Transaction;
use App\Models\Repayment;

class Debt extends Model
{
    protected $fillable = [
        'farmer_id',
        'transaction_id',
        'original_amount',
        'remaining_amount',
        'status'
    ];

    public function farmer()
    {
        return $this->belongsTo(Farmer::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function repayments()
    {
        return $this->belongsToMany(Repayment::class, 'repayment_debt')
                    ->withPivot('amount_applied')
                    ->withTimestamps();
    }
}