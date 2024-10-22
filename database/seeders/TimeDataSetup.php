<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class TimeDataSetup extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->setPermission();
        $this->setType();
        $this->setStatuses();

    }

    private function setPermission()
    {
        $permissions = [
            'timedata.view',
            'timedata.create',
            'timedata.edit',
            'timedata.delete',
         ];

          // Looping and Inserting Array's Permissions into Permission Table
         foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
          }

    }

    private function setType()
    {
        DB::table('types')->insert([
            ['model' => 'time_data', 'name'=>'События'],
        ]);
    }

    private function setStatuses()
    {
        $typeId = DB::table('types')->where('model','=','time_data')->pluck('id');
        if (!empty($typeId)) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            //DB::table('statuses')->truncate();
            //DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            DB::table('statuses')->insert([
                ['type_id' => $typeId[0], 'name'=>'Создано'],
                ['type_id' => $typeId[0], 'name'=>'Завершено'],
                ['type_id' => $typeId[0], 'name'=>'В работе'],
                ['type_id' => $typeId[0], 'name'=>'Перенесено'],
            ]);
        }

    }
}
