<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'supervisor_id'];
    protected $hidden = ['password', 'remember_token'];

    public function supervisor() { return $this->belongsTo(User::class, 'supervisor_id'); }
    public function operators()  { return $this->hasMany(User::class, 'supervisor_id'); }
    public function transactions() { return $this->hasMany(Transaction::class, 'operator_id'); }

    public function isAdmin()      { return $this->role === 'admin'; }
    public function isSupervisor() { return $this->role === 'supervisor'; }
    public function isOperator()   { return $this->role === 'operator'; }
}