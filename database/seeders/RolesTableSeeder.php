<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['id' => 1, 'role_name' => 'client'],
            ['id' => 2, 'role_name' => 'employee'],
            ['id' => 3, 'role_name' => 'admin'],
        ];

        foreach ($roles as $role) {
           
            $existingRole = DB::table('roles')->where('id', $role['id'])->first();
            if (!$existingRole) {
                DB::table('roles')->insert($role);
            }
        }
    }
    
}
