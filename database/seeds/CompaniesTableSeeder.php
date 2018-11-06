<?php

use Illuminate\Database\Seeder;
use App\Company;

class CompaniesTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$company = new Company();
		$company->name = 'Triumph Training';
		$company->is_deleted = false;
		$company->save();

		$company = new Company();
		$company->name = 'Home Investment Solutions';
		$company->is_deleted = false;
		$company->save();

		$company = new Company();
		$company->name = 'MyStepDad.org';
		$company->is_deleted = false;
		$company->save();
	}
}
