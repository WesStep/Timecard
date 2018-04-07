<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = 'employee';
        $role->save();

        $role = new Role();
        $role->name = 'payroll admin';
        $role->save();

        $role = new Role();
        $role->name = 'business owner';
        $role->save();
    }
}
