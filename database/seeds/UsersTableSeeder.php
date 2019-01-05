<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		// Employees
		// Get the employee role ID
		$role_id = DB::table('roles')->where('name', 'employee')->pluck('id');

		$user = new User();
		$user->name = 'Employee';
		$user->email = 'sample.employee@gmail.com';
		$user->password = bcrypt('NewPass1234!');
		$user->pay_rate = 10.00;
		$user->role_id = $role_id[0];
		$user->is_clocked_in = false;
		$user->is_deleted = false;
		$user->save();

		// Payroll Admin
		// Get Payroll Admin Role ID
		$role_id = DB::table('roles')->where('name', 'payroll admin')->pluck('id');

		$user = new User();
		$user->name = 'Payroll Admin';
		$user->email = 'sample.payroll.admin@gmail.com';
		$user->password = bcrypt('NewPass1234!');
		$user->pay_rate = null;
		$user->role_id = $role_id[0];
		$user->is_clocked_in = false;
		$user->is_deleted = false;
		$user->save();

		// Business Owner
		//Select Business Owner Role ID
		$role_id = DB::table('roles')->where('name', 'business owner')->pluck('id');

		$user = new User();
		$user->name = 'Business Owner';
		$user->email = 'sample.business.owner@gmail.com';
		$user->password = bcrypt('NewPass1234!');
		$user->pay_rate = null;
		$user->role_id = $role_id[0];
		$user->is_clocked_in = false;
		$user->is_deleted = false;
		$user->save();
	}
}
