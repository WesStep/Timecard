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
    public function run()
    {
        $shift = new Shift();
        $shift->user_id = 4;
        $shift->company = 'Triumph Training';
        $shift->clock_in_time = '2018-04-03 10:00:00';
        $shift->clock_out_time = '2018-04-03 12:00:00';
        $shift->duration_in_minutes = 120;
        $shift->note = 'Test Shift for dummy data.';
        $shift->amount_to_pay = 20;
        $shift->has_been_paid = false;
        $shift->is_deleted = false;
        $shift->save();

        $shift = new Shift();
        $shift->user_id = 3;
        $shift->company = 'Triumph Training';
        $shift->clock_in_time = '2018-04-03 10:00:00';
        $shift->clock_out_time = '2018-04-03 12:00:00';
        $shift->duration_in_minutes = 120;
        $shift->note = 'Test Shift for dummy data.';
        $shift->amount_to_pay = 20;
        $shift->has_been_paid = false;
        $shift->is_deleted = false;
        $shift->save();

        $shift = new Shift();
        $shift->user_id = 2;
        $shift->company = 'Triumph Training';
        $shift->clock_in_time = '2018-04-03 10:00:00';
        $shift->clock_out_time = '2018-04-03 12:00:00';
        $shift->duration_in_minutes = 120;
        $shift->note = 'Test Shift for dummy data.';
        $shift->amount_to_pay = 20;
        $shift->has_been_paid = false;
        $shift->is_deleted = false;
        $shift->save();

        $shift = new Shift();
        $shift->user_id = 1;
        $shift->company = 'Triumph Training';
        $shift->clock_in_time = '2018-04-03 10:00:00';
        $shift->clock_out_time = '2018-04-03 12:00:00';
        $shift->duration_in_minutes = 120;
        $shift->note = 'Test Shift for dummy data.';
        $shift->amount_to_pay = 20;
        $shift->has_been_paid = false;
        $shift->is_deleted = false;
        $shift->save();
    }
}
