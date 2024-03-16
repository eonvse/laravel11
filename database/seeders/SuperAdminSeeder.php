<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating Super Admin User
        Role::create(['name' => 'Super Admin']);
        $superAdmin = User::find(1);
        //Первый зарегистрированный пользователь = Super Admin
        $superAdmin->assignRole('Super Admin');

    }
}
