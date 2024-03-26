<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('types')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::table('types')->insert([
            ['model' => 'tasks', 'name'=>'Задачи'],
            ['model' => 'users', 'name'=>'Участники'],
        ]);
    }
}
