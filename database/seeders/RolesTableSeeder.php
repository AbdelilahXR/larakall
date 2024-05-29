<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'super_admin',
                'guard_name' => 'web',
                'created_at' => '2024-02-19 23:33:27',
                'updated_at' => '2024-02-19 23:33:27',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'client',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:56',
                'updated_at' => '2024-03-29 18:49:56',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'agent',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:50:59',
                'updated_at' => '2024-03-29 18:50:59',
            ),
        ));
        
        
    }
}