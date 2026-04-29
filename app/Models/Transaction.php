<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
    'farmer_id','operator_id','payment_method',
    'subtotal','interest_rate','interest_amount','grand_total'
];

public function farmer()   { return $this->belongsTo(Farmer::class); }
public function operator() { return $this->belongsTo(User::class, 'operator_id'); }
public function items()    { return $this->hasMany(TransactionItem::class); }
public function debt()     { return $this->hasOne(Debt::class); }
}
