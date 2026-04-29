<?php
namespace App\Repositories;

use App\Models\Farmer;
use App\Repositories\Interfaces\FarmerRepositoryInterface;

class FarmerRepository implements FarmerRepositoryInterface
{
    public function all() { return Farmer::all(); }
    public function findById(int $id) { return Farmer::findOrFail($id); }
    public function findByIdentifier(string $identifier) {
        return Farmer::where('identifier', $identifier)->first();
    }
    public function findByPhone(string $phone) {
        return Farmer::where('phone', $phone)->first();
    }
    public function create(array $data) { return Farmer::create($data); }
    public function update(int $id, array $data) {
        $farmer = Farmer::findOrFail($id);
        $farmer->update($data);
        return $farmer;
    }
    public function delete(int $id) { return Farmer::findOrFail($id)->delete(); }
}