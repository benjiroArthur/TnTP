<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => 'hotel',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'traveller',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'transport',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'admin',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
