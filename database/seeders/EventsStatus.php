<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventsStatus extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $typeId = DB::table('types')->where('model','=','events')->pluck('id');
        if (!empty($typeId)) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('statuses')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            DB::table('statuses')->insert([
                ['type_id' => $typeId[0], 'name'=>'Создано'],
                ['type_id' => $typeId[0], 'name'=>'Завершено'],
                ['type_id' => $typeId[0], 'name'=>'В работе'],
                ['type_id' => $typeId[0], 'name'=>'Перенесено'],
            ]);
        }
    }
}