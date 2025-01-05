<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Warehouse;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // for ($i = 1; $i <= 25; $i++) {
        //     $warehouse = new Warehouse();
        //     do {
        //         $warehouse->id = 'WARE' . mt_rand(100000, 999999);
        //     } while (Warehouse::where('id', $warehouse->id)->exists());
        //     $warehouse->name = 'Kho ' . $i;
        //     $warehouse->address = $i . ' đường A, Thành phố B, Tỉnh C';
        //     $warehouse->save();
        // }
    }
}
