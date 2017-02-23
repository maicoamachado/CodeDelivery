<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(CategoryTableSeeder::class);
        $this->call(StatusOrdersTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(CupomTableSeeder::class);
        Model::reguard();
    }
}
