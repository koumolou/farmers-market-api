<?php

namespace App\Services;

use App\Repositories\Interfaces\FarmerRepositoryInterface;
use Illuminate\Validation\ValidationException;

class FarmerService
{
    public function __construct(
        protected FarmerRepositoryInterface $farmerRepository
    ) {}

    public function getAll()
    {
        return $this->farmerRepository->all();
    }

    public function find(int $id)
    {
        return $this->farmerRepository->findById($id);
    }

    public function search(string $query)
    {
        // Try identifier first, then phone
        $farmer = $this->farmerRepository->findByIdentifier($query)
               ?? $this->farmerRepository->findByPhone($query);

        if (!$farmer) {
            throw ValidationException::withMessages([
                'query' => ['No farmer found with that identifier or phone number.'],
            ]);
        }

        return $farmer;
    }

    public function create(array $data)
    {
        return $this->farmerRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        return $this->farmerRepository->update($id, $data);
    }

    public function getProfile(int $id): array
    {
        $farmer = $this->farmerRepository->findById($id);

        return [
            'farmer'           => $farmer,
            'outstanding_debt' => $farmer->outstandingDebt(),
            'open_debts'       => $farmer->debts()
                                    ->whereIn('status', ['open', 'partial'])
                                    ->with('transaction')
                                    ->orderBy('created_at', 'asc')
                                    ->get(),
        ];
    }
}