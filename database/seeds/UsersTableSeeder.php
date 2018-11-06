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
		$user->name = 'Hannah Stephenson';
		$user->email = 'hannah.c.stephenson@gmail.com';
		$user->password = bcrypt('NewPass1234!');
		$user->pay_rate = 10.00;
		$user->role_id = $role_id[0];
		$user->is_clocked_in = false;
		$user->is_deleted = false;
		$user->save();

		$user = new User();
		$user->name = 'Jacob Stephenson';
		$user->email = 'jssnowsled@gmail.com';
		$user->password = bcrypt('NewPass1234!');
		$user->pay_rate = 10.00;
		$user->role_id = $role_id[0];
		$user->is_clocked_in = false;
		$user->is_deleted = false;
		$user->save();

		$user = new User();
		$user->name = 'Nicholas Stephenson';
		$user->email = 'nickilstephenson@gmail.com';
		$user->password = bcrypt('NewPass1234!');
		$user->pay_rate = 10.00;
		$user->role_id = $role_id[0];
		$user->is_clocked_in = false;
		$user->is_deleted = false;
		$user->save();

		$user = new User();
		$user->name = 'Wes Stephenson';
		$user->email = 'wesstep1315@gmail.com';
		$user->password = bcrypt('NewPass1234!');
		$user->pay_rate = 10.00;
		$user->role_id = $role_id[0];
		$user->is_clocked_in = false;
		$user->is_deleted = false;
		$user->save();

		// Test Employee Account
		$user = new User();
		$user->name = 'Employee Test';
		$user->email = 'test.emp@smallstepsbigfeat.com';
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
		$user->name = 'Suzanne Stephenson';
		$user->email = 'suzannestephenson7@gmail.com';
		$user->password = bcrypt('NewPass1234!');
		$user->pay_rate = null;
		$user->role_id = $role_id[0];
		$user->is_clocked_in = false;
		$user->is_deleted = false;
		$user->save();

		// Test Payroll Admin Account
		$user = new User();
		$user->name = 'Payroll-Admin Test';
		$user->email = 'test.adm@smallstepsbigfeat.com';
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
		$user->name = 'Jim Stephenson';
		$user->email = 'jimbostep@gmail.com';
		$user->password = bcrypt('NewPass1234!');
		$user->pay_rate = null;
		$user->role_id = $role_id[0];
		$user->is_clocked_in = false;
		$user->is_deleted = false;
		$user->save();

		// Test Business Owner Account
		$user = new User();
		$user->name = 'Business-Owner Test';
		$user->email = 'test.own@smallstepsbigfeat.com';
		$user->password = bcrypt('NewPass1234!');
		$user->pay_rate = null;
		$user->role_id = $role_id[0];
		$user->is_clocked_in = false;
		$user->is_deleted = false;
		$user->save();
	}
}
