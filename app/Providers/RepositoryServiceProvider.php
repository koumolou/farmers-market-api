<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Interfaces
use App\Repositories\Interfaces\FarmerRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\TransactionRepositoryInterface;
use App\Repositories\Interfaces\DebtRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\Interfaces\RepaymentRepositoryInterface;

// Implementations
use App\Repositories\FarmerRepository;
use App\Repositories\UserRepository;
use App\Repositories\ProductRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\DebtRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\RepaymentRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class,        UserRepository::class);
$this->app->bind(CategoryRepositoryInterface::class,    CategoryRepository::class);
$this->app->bind(ProductRepositoryInterface::class,     ProductRepository::class);
$this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
$this->app->bind(RepaymentRepositoryInterface::class,   RepaymentRepository::class);
$this->app->bind(FarmerRepositoryInterface::class,      FarmerRepository::class);
    }

    

    public function boot(): void
    {
        //
    }
}