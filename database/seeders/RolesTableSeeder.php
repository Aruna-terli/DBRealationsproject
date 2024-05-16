<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['id' => 1, 'role_name' => 'client'],
            ['id' => 2, 'role_name' => 'employee'],
            ['id' => 3, 'role_name' => 'admin'],
        ]);
    }
}
