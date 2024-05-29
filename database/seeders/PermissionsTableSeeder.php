<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'view_order',
                'guard_name' => 'web',
                'created_at' => '2024-02-19 23:33:27',
                'updated_at' => '2024-02-19 23:33:27',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'view_any_order',
                'guard_name' => 'web',
                'created_at' => '2024-02-19 23:33:27',
                'updated_at' => '2024-02-19 23:33:27',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'create_order',
                'guard_name' => 'web',
                'created_at' => '2024-02-19 23:33:27',
                'updated_at' => '2024-02-19 23:33:27',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'update_order',
                'guard_name' => 'web',
                'created_at' => '2024-02-19 23:33:27',
                'updated_at' => '2024-02-19 23:33:27',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'restore_order',
                'guard_name' => 'web',
                'created_at' => '2024-02-19 23:33:27',
                'updated_at' => '2024-02-19 23:33:27',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'restore_any_order',
                'guard_name' => 'web',
                'created_at' => '2024-02-19 23:33:27',
                'updated_at' => '2024-02-19 23:33:27',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'replicate_order',
                'guard_name' => 'web',
                'created_at' => '2024-02-19 23:33:27',
                'updated_at' => '2024-02-19 23:33:27',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'reorder_order',
                'guard_name' => 'web',
                'created_at' => '2024-02-19 23:33:27',
                'updated_at' => '2024-02-19 23:33:27',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'delete_order',
                'guard_name' => 'web',
                'created_at' => '2024-02-19 23:33:27',
                'updated_at' => '2024-02-19 23:33:27',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'delete_any_order',
                'guard_name' => 'web',
                'created_at' => '2024-02-19 23:33:27',
                'updated_at' => '2024-02-19 23:33:27',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'force_delete_order',
                'guard_name' => 'web',
                'created_at' => '2024-02-19 23:33:27',
                'updated_at' => '2024-02-19 23:33:27',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'force_delete_any_order',
                'guard_name' => 'web',
                'created_at' => '2024-02-19 23:33:27',
                'updated_at' => '2024-02-19 23:33:27',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'view_role',
                'guard_name' => 'web',
                'created_at' => '2024-02-19 23:33:27',
                'updated_at' => '2024-02-19 23:33:27',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'view_any_role',
                'guard_name' => 'web',
                'created_at' => '2024-02-19 23:33:27',
                'updated_at' => '2024-02-19 23:33:27',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'create_role',
                'guard_name' => 'web',
                'created_at' => '2024-02-19 23:33:27',
                'updated_at' => '2024-02-19 23:33:27',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'update_role',
                'guard_name' => 'web',
                'created_at' => '2024-02-19 23:33:27',
                'updated_at' => '2024-02-19 23:33:27',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'delete_role',
                'guard_name' => 'web',
                'created_at' => '2024-02-19 23:33:27',
                'updated_at' => '2024-02-19 23:33:27',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'delete_any_role',
                'guard_name' => 'web',
                'created_at' => '2024-02-19 23:33:27',
                'updated_at' => '2024-02-19 23:33:27',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'view_company',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'view_any_company',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'create_company',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'update_company',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'restore_company',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'restore_any_company',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'replicate_company',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'reorder_company',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'delete_company',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'delete_any_company',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'force_delete_company',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'force_delete_any_company',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'view_message',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'view_any_message',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'create_message',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'update_message',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'restore_message',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'restore_any_message',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'replicate_message',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'reorder_message',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'delete_message',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'delete_any_message',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'force_delete_message',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'force_delete_any_message',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'view_pack',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'view_any_pack',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'create_pack',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'update_pack',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'restore_pack',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            47 => 
            array (
                'id' => 48,
                'name' => 'restore_any_pack',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'replicate_pack',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'reorder_pack',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'delete_pack',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'delete_any_pack',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'force_delete_pack',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'force_delete_any_pack',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            54 => 
            array (
                'id' => 55,
                'name' => 'view_payment',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            55 => 
            array (
                'id' => 56,
                'name' => 'view_any_payment',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            56 => 
            array (
                'id' => 57,
                'name' => 'create_payment',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            57 => 
            array (
                'id' => 58,
                'name' => 'update_payment',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            58 => 
            array (
                'id' => 59,
                'name' => 'restore_payment',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            59 => 
            array (
                'id' => 60,
                'name' => 'restore_any_payment',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            60 => 
            array (
                'id' => 61,
                'name' => 'replicate_payment',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            61 => 
            array (
                'id' => 62,
                'name' => 'reorder_payment',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            62 => 
            array (
                'id' => 63,
                'name' => 'delete_payment',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            63 => 
            array (
                'id' => 64,
                'name' => 'delete_any_payment',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            64 => 
            array (
                'id' => 65,
                'name' => 'force_delete_payment',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            65 => 
            array (
                'id' => 66,
                'name' => 'force_delete_any_payment',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            66 => 
            array (
                'id' => 67,
                'name' => 'view_product',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            67 => 
            array (
                'id' => 68,
                'name' => 'view_any_product',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            68 => 
            array (
                'id' => 69,
                'name' => 'create_product',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            69 => 
            array (
                'id' => 70,
                'name' => 'update_product',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            70 => 
            array (
                'id' => 71,
                'name' => 'restore_product',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            71 => 
            array (
                'id' => 72,
                'name' => 'restore_any_product',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            72 => 
            array (
                'id' => 73,
                'name' => 'replicate_product',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            73 => 
            array (
                'id' => 74,
                'name' => 'reorder_product',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            74 => 
            array (
                'id' => 75,
                'name' => 'delete_product',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            75 => 
            array (
                'id' => 76,
                'name' => 'delete_any_product',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            76 => 
            array (
                'id' => 77,
                'name' => 'force_delete_product',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            77 => 
            array (
                'id' => 78,
                'name' => 'force_delete_any_product',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            78 => 
            array (
                'id' => 79,
                'name' => 'view_state',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            79 => 
            array (
                'id' => 80,
                'name' => 'view_any_state',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            80 => 
            array (
                'id' => 81,
                'name' => 'create_state',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            81 => 
            array (
                'id' => 82,
                'name' => 'update_state',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            82 => 
            array (
                'id' => 83,
                'name' => 'restore_state',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            83 => 
            array (
                'id' => 84,
                'name' => 'restore_any_state',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            84 => 
            array (
                'id' => 85,
                'name' => 'replicate_state',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            85 => 
            array (
                'id' => 86,
                'name' => 'reorder_state',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            86 => 
            array (
                'id' => 87,
                'name' => 'delete_state',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            87 => 
            array (
                'id' => 88,
                'name' => 'delete_any_state',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            88 => 
            array (
                'id' => 89,
                'name' => 'force_delete_state',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            89 => 
            array (
                'id' => 90,
                'name' => 'force_delete_any_state',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            90 => 
            array (
                'id' => 91,
                'name' => 'view_stock',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            91 => 
            array (
                'id' => 92,
                'name' => 'view_any_stock',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            92 => 
            array (
                'id' => 93,
                'name' => 'create_stock',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            93 => 
            array (
                'id' => 94,
                'name' => 'update_stock',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            94 => 
            array (
                'id' => 95,
                'name' => 'restore_stock',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            95 => 
            array (
                'id' => 96,
                'name' => 'restore_any_stock',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            96 => 
            array (
                'id' => 97,
                'name' => 'replicate_stock',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            97 => 
            array (
                'id' => 98,
                'name' => 'reorder_stock',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            98 => 
            array (
                'id' => 99,
                'name' => 'delete_stock',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            99 => 
            array (
                'id' => 100,
                'name' => 'delete_any_stock',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            100 => 
            array (
                'id' => 101,
                'name' => 'force_delete_stock',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            101 => 
            array (
                'id' => 102,
                'name' => 'force_delete_any_stock',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            102 => 
            array (
                'id' => 103,
                'name' => 'view_store',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            103 => 
            array (
                'id' => 104,
                'name' => 'view_any_store',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            104 => 
            array (
                'id' => 105,
                'name' => 'create_store',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            105 => 
            array (
                'id' => 106,
                'name' => 'update_store',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            106 => 
            array (
                'id' => 107,
                'name' => 'restore_store',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            107 => 
            array (
                'id' => 108,
                'name' => 'restore_any_store',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            108 => 
            array (
                'id' => 109,
                'name' => 'replicate_store',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            109 => 
            array (
                'id' => 110,
                'name' => 'reorder_store',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            110 => 
            array (
                'id' => 111,
                'name' => 'delete_store',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            111 => 
            array (
                'id' => 112,
                'name' => 'delete_any_store',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            112 => 
            array (
                'id' => 113,
                'name' => 'force_delete_store',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            113 => 
            array (
                'id' => 114,
                'name' => 'force_delete_any_store',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            114 => 
            array (
                'id' => 115,
                'name' => 'view_subscription',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            115 => 
            array (
                'id' => 116,
                'name' => 'view_any_subscription',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            116 => 
            array (
                'id' => 117,
                'name' => 'create_subscription',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            117 => 
            array (
                'id' => 118,
                'name' => 'update_subscription',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            118 => 
            array (
                'id' => 119,
                'name' => 'restore_subscription',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            119 => 
            array (
                'id' => 120,
                'name' => 'restore_any_subscription',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            120 => 
            array (
                'id' => 121,
                'name' => 'replicate_subscription',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            121 => 
            array (
                'id' => 122,
                'name' => 'reorder_subscription',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            122 => 
            array (
                'id' => 123,
                'name' => 'delete_subscription',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            123 => 
            array (
                'id' => 124,
                'name' => 'delete_any_subscription',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            124 => 
            array (
                'id' => 125,
                'name' => 'force_delete_subscription',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            125 => 
            array (
                'id' => 126,
                'name' => 'force_delete_any_subscription',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            126 => 
            array (
                'id' => 127,
                'name' => 'view_user',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            127 => 
            array (
                'id' => 128,
                'name' => 'view_any_user',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:15',
                'updated_at' => '2024-03-29 18:49:15',
            ),
            128 => 
            array (
                'id' => 129,
                'name' => 'create_user',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:16',
                'updated_at' => '2024-03-29 18:49:16',
            ),
            129 => 
            array (
                'id' => 130,
                'name' => 'update_user',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:16',
                'updated_at' => '2024-03-29 18:49:16',
            ),
            130 => 
            array (
                'id' => 131,
                'name' => 'restore_user',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:16',
                'updated_at' => '2024-03-29 18:49:16',
            ),
            131 => 
            array (
                'id' => 132,
                'name' => 'restore_any_user',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:16',
                'updated_at' => '2024-03-29 18:49:16',
            ),
            132 => 
            array (
                'id' => 133,
                'name' => 'replicate_user',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:16',
                'updated_at' => '2024-03-29 18:49:16',
            ),
            133 => 
            array (
                'id' => 134,
                'name' => 'reorder_user',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:16',
                'updated_at' => '2024-03-29 18:49:16',
            ),
            134 => 
            array (
                'id' => 135,
                'name' => 'delete_user',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:16',
                'updated_at' => '2024-03-29 18:49:16',
            ),
            135 => 
            array (
                'id' => 136,
                'name' => 'delete_any_user',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:16',
                'updated_at' => '2024-03-29 18:49:16',
            ),
            136 => 
            array (
                'id' => 137,
                'name' => 'force_delete_user',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:16',
                'updated_at' => '2024-03-29 18:49:16',
            ),
            137 => 
            array (
                'id' => 138,
                'name' => 'force_delete_any_user',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:16',
                'updated_at' => '2024-03-29 18:49:16',
            ),
            138 => 
            array (
                'id' => 139,
                'name' => 'page_MyProfilePage',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:16',
                'updated_at' => '2024-03-29 18:49:16',
            ),
            139 => 
            array (
                'id' => 140,
                'name' => 'widget_DashboardFirstLineOverview',
                'guard_name' => 'web',
                'created_at' => '2024-03-29 18:49:16',
                'updated_at' => '2024-03-29 18:49:16',
            ),
        ));
        
        
    }
}