<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    protected $fillable = ['identifier', 'firstname', 'lastname', 'phone', 'credit_limit'];

public function transactions() { return $this->hasMany(Transaction::class); }
public function debts()        { return $this->hasMany(Debt::class); }
public function repayments()   { return $this->hasMany(Repayment::class); }

public function outstandingDebt()
{
    return $this->debts()
        ->whereIn('status', ['open', 'partial'])
        ->sum('remaining_amount');
}
}
