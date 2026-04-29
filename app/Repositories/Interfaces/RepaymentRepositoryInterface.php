<?php

namespace App\Repositories\Interfaces;

interface RepaymentRepositoryInterface
{
    public function create(array $data);
    public function getByFarmer(int $farmerId);    
}