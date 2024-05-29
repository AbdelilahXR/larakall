<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => '$2y$12$NQy38xvBWyzD4wkwKozqV.09PPqvBMpsChnwTRViaV0pVtlYcf60C',
                'created_at' => '2024-02-19 23:05:40',
                'updated_at' => '2024-02-19 23:05:40',
                'deleted_at' => NULL,
                'earnings' => 0.0,
                'email_verified_at' => NULL,
                'remember_token' => 'LTQ1LJC9t2JF38urvchrvDDDirvFhpOZMtw1gQtTAcZIS1dJa0ZvgvTs8xED',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'client',
                'email' => 'client@gmail.com',
                'password' => '$2y$12$HHrvMjT2SSr7Gdy8aT4MNuy2OnpnO0lfzvwdOkirDt8n2K0ZFLAuK',
                'created_at' => '2024-03-29 20:38:29',
                'updated_at' => '2024-03-29 20:38:29',
                'deleted_at' => NULL,
                'earnings' => 0.0,
                'email_verified_at' => NULL,
                'remember_token' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'agent',
                'email' => 'agent@gmail.com',
                'password' => '$2y$12$HHrvMjT2SSr7Gdy8aT4MNuy2OnpnO0lfzvwdOkirDt8n2K0ZFLAuK',
                'created_at' => '2024-03-29 20:38:29',
                'updated_at' => '2024-03-29 20:38:29',
                'deleted_at' => NULL,
                'earnings' => 0.0,
                'email_verified_at' => NULL,
                'remember_token' => NULL,
            ),
        ));
        
        
    }
}