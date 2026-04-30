<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Farmer;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
{
    
    if (Setting::count() === 0) {
        Setting::insert([
            ['key' => 'interest_rate',        'value' => '0.30', 'description' => 'Credit interest rate (30%)',    'created_at' => now(), 'updated_at' => now()],
            ['key' => 'commodity_rate_per_kg', 'value' => '1000', 'description' => '1kg cacao = 1000 FCFA',        'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    
    if (User::where('role', 'admin')->count() === 0) {
        $admin = User::create([
            'name'     => 'Admin Principal',
            'email'    => 'admin@farmarket.ci',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        $supervisor = User::create([
            'name'     => 'Kouassi Jean',
            'email'    => 'supervisor@farmarket.ci',
            'password' => Hash::make('password'),
            'role'     => 'supervisor',
        ]);

        User::create([
            'name'          => 'Yao Hervé',
            'email'         => 'operator@farmarket.ci',
            'password'      => Hash::make('password'),
            'role'          => 'operator',
            'supervisor_id' => $supervisor->id,
        ]);
    }

 
    if (Category::count() === 0) {
        $pesticides  = Category::create(['name' => 'Pesticides']);
        $fertilizers = Category::create(['name' => 'Engrais']);
        Category::create(['name' => 'Semences']);

        $herbicides   = Category::create(['name' => 'Herbicides',   'parent_id' => $pesticides->id]);
        $insecticides = Category::create(['name' => 'Insecticides', 'parent_id' => $pesticides->id]);
        $npk          = Category::create(['name' => 'NPK',          'parent_id' => $fertilizers->id]);
        $organic      = Category::create(['name' => 'Organique',    'parent_id' => $fertilizers->id]);

        // Products
        Product::insert([
            ['name' => 'Kalach 360 SL',    'description' => 'Herbicide systémique',      'price' => 3500,  'category_id' => $herbicides->id,   'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Primagram Gold',    'description' => 'Herbicide sélectif maïs',  'price' => 5200,  'category_id' => $herbicides->id,   'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Decis EC 25',       'description' => 'Insecticide pyréthrinoïde','price' => 4800,  'category_id' => $insecticides->id, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Confidor 200 SL',   'description' => 'Insecticide systémique',   'price' => 6500,  'category_id' => $insecticides->id, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'NPK 15-15-15',      'description' => 'Engrais complet céréales', 'price' => 12000, 'category_id' => $npk->id,          'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Urée 46%',          'description' => 'Engrais azoté',            'price' => 9500,  'category_id' => $npk->id,          'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fumure organique',  'description' => 'Compost naturel 25kg',     'price' => 3000,  'category_id' => $organic->id,      'created_at' => now(), 'updated_at' => now()],
        ]);
    }

  
    if (Farmer::count() === 0) {
        Farmer::insert([
            ['identifier' => 'CI-2024-0001', 'firstname' => 'Koné',     'lastname' => 'Mamadou',   'phone' => '0701020304', 'credit_limit' => 150000, 'created_at' => now(), 'updated_at' => now()],
            ['identifier' => 'CI-2024-0002', 'firstname' => 'Bamba',    'lastname' => 'Fatoumata', 'phone' => '0705060708', 'credit_limit' => 200000, 'created_at' => now(), 'updated_at' => now()],
            ['identifier' => 'CI-2024-0003', 'firstname' => 'Touré',    'lastname' => 'Ibrahim',   'phone' => '0709101112', 'credit_limit' => 100000, 'created_at' => now(), 'updated_at' => now()],
            ['identifier' => 'CI-2024-0004', 'firstname' => 'Coulibaly','lastname' => 'Aïssatou',  'phone' => '0511121314', 'credit_limit' => 80000,  'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
}