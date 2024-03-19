<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('colors')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        DB::table('colors')->insert([
            ['base' => '_clean', 'dark' => '_clean'],
            ['base' => 'bg-gray-100', 'dark' => 'bg-gray-200'],
            ['base' => 'bg-gray-300', 'dark' => 'bg-gray-400'],
            ['base' => 'bg-red-100', 'dark' => 'bg-red-200'],
            ['base' => 'bg-red-300', 'dark' => 'bg-red-400'],
            ['base' => 'bg-orange-100', 'dark' => 'bg-orange-200'],
            ['base' => 'bg-orange-300', 'dark' => 'bg-orange-400'],
            ['base' => 'bg-yellow-100', 'dark' => 'bg-yellow-200'],
            ['base' => 'bg-yellow-300', 'dark' => 'bg-yellow-400'],
            ['base' => 'bg-lime-100', 'dark' => 'bg-lime-200'],
            ['base' => 'bg-lime-300', 'dark' => 'bg-lime-400'],
            ['base' => 'bg-green-100', 'dark' => 'bg-green-200'],
            ['base' => 'bg-green-300', 'dark' => 'bg-green-400'],
            ['base' => 'bg-cyan-100', 'dark' => 'bg-cyan-200'],
            ['base' => 'bg-cyan-300', 'dark' => 'bg-cyan-400'],
            ['base' => 'bg-sky-100', 'dark' => 'bg-sky-200'],
            ['base' => 'bg-sky-300', 'dark' => 'bg-sky-400'],
            ['base' => 'bg-indigo-100', 'dark' => 'bg-indigo-200'],
            ['base' => 'bg-indigo-300', 'dark' => 'bg-indigo-400'],
            ['base' => 'bg-fuchsia-100', 'dark' => 'bg-fuchsia-200'],
            ['base' => 'bg-fuchsia-300', 'dark' => 'bg-fuchsia-400'],
        ]);
    }
}
