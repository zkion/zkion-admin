<?php

namespace Database\Seeders;

use App\Models\Manage;
use App\Models\Organization\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::query()->create([
            'name' => '技术部',
            'description' => '技术部',
            'address' => '昆明',
        ]);
        Manage::query()->create([
            'name' => 'lirui',
            'real_name' => '李锐',
            'password' => '1213456',
            'department_id' => 1,
        ]);
    }
}
