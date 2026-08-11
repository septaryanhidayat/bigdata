<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CmsSeeder::class);
        $this->call(MasterDataSeeder::class);

        User::updateOrCreate(
            ['email' => 'admin@smartedu.test'],
            [
                'name' => 'Administrator SmartEdu',
                'password' => bcrypt('p4l3mb4ng'),
            ]
        );
    }
}
