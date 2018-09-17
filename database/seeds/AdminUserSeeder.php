<?php

use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\AdminUser::firstOrCreate([
            'username' => 'admin'
        ], [
           'phone' => '123456',
           'password' => bcrypt(123456),
        ]);
    }
}
