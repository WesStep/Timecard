<?php

use Illuminate\Database\Seeder;
use App\Shift;

class ShiftsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$shift = new Shift();
		$shift->user_id = 1;
		$shift->company_id = 1;
		$current_date = date("Y-m-d");
		$shift->clock_in_time = $current_date . ' 10:00:00';
		$shift->clock_out_time = $current_date . ' 12:00:00';
		$shift->duration_in_minutes = 120;
		$shift->note = 'Test Shift for sample data.';
		$shift->amount_to_pay = 20;
		$shift->has_been_paid = false;
		$shift->is_deleted = false;
		$shift->reason_for_deletion = null;
		$shift->save();
	}
}
