
<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Dyago Matheus',
            'email' => 'dyago@gmail.com',
            'password' => bcrypt('123'),
        ]);
    }
}