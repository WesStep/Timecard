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
		$company->name = 'Wayne Enterprises';
		$company->is_deleted = false;
		$company->save();

		$company = new Company();
		$company->name = 'Stark Industries';
		$company->is_deleted = false;
		$company->save();

		$company = new Company();
		$company->name = 'Acme Corporation';
		$company->is_deleted = false;
		$company->save();
	}
}
