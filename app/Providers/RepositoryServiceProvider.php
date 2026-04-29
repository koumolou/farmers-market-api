<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Interfaces
use App\Repositories\Interfaces\FarmerRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\Repositories\Interfaces\DebtRepositoryInterface;

// Implementations
use App\Repositories\FarmerRepository;
use App\Repositories\UserRepository;
use App\Repositories\ProductRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\DebtRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    
    public function register(): void
    {
        $this->app->bind(FarmerRepositoryInterface::class, FarmerRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
        $this->app->bind(DebtRepositoryInterface::class, DebtRepository::class);
    }

    
    public function boot(): void
    {
        //
    }
}