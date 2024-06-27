<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('statuses')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::table('statuses')->insert([
            ['type_id' => null, 'name'=>'Завершено'],
            ['type_id' => null, 'name'=>'В процессе'],
            ['type_id' => null, 'name'=>'Перенесено'],
        ]);
    }
}
