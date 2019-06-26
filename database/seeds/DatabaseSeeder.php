<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(GroupModuleConnectionModuleTableSeeder::class);
        $this->call(GroupModulesTableSeeder::class);
        $this->call(GroupUserConnectionGroupModuleTableSeeder::class);
        $this->call(GroupUsersTableSeeder::class);
        $this->call(ModuleConnectionActionTableSeeder::class);
        $this->call(ModulesTableSeeder::class);
        $this->call(ActionsTableSeeder::class);
    }
}
