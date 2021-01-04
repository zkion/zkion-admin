<?php

namespace Database\Seeders;

use App\Models\Manage;
use App\Models\Organization\Department;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DepartmentSeeder::class,
        ]);
//         \App\Models\User::factory(10)->create();
    }
}
