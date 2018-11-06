<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shift;
use Carbon\Carbon;
use DB;
use Auth;

class ClockController extends Controller
{
    public function clockIn(Request $request)
    {
        // Get the currently logged in user
        $user = Auth::user();

        // Verify that the company the user submitted is legitimate
        $this->validate($request, [
            'company_id' => 'required|integer|exists:companies,id',
            'clock_in_time' => 'required|date'
        ]);

        // Set the company_id variable
        $company_id = $request->input('company_id');

        // Get the clock in dateTime stamp
        $clock_in_time = new \DateTime($request->input('clock_in_time'));
        $clock_in_year = $clock_in_time->format('Y');
        $clock_in_month = $clock_in_time->format('m');
        $clock_in_day = $clock_in_time->format('d');
        $clock_in_hour = $clock_in_time->format('H');
        $clock_in_minute = $clock_in_time->format('i');
        $clock_in_second = $clock_in_time->format('s');
        $clock_in_time = Carbon::create(
            $clock_in_year,
            $clock_in_month,
            $clock_in_day,
            $clock_in_hour,
            $clock_in_minute,
            $clock_in_second
        );
        
        // Create the new shift in the database
        $shift = new Shift([
            'user_id' => $user->id,
            'company_id' => $company_id,
            'clock_in_time' => $clock_in_time,
            'clock_out_time' => null,
            'duration_in_minutes' => null,
            'note' => null,
            'amount_to_pay' => null,
            'has_been_paid' => false,
            'is_deleted' => false
        ]);
        $user->shifts()->save($shift);
        // Update the user's status to clocked in
        DB::table('users')
        ->where('id', $user->id)
        ->update(['is_clocked_in' => true]);
        // Redirect back with the info.
        return redirect()->back()->with('info', 'User Clocked In!');
    }

    public function clockOut(Request $request)
    {
        // Validate the user's note for the shift
        $this->validate($request, [
            'note' => 'required|max:140|string',
            'clock_out_time' => 'required|date'
        ]);

        // Get the currently logged in user
        $user = Auth::user();

        // Get the clock in dateTime stamp
        $clock_in_time = DB::table('shifts')
			->where('user_id', $user->id)
			->latest()
			->pluck('clock_in_time');
        $clock_in_time = Carbon::parse($clock_in_time[0]);

        // Get the clock out dateTime stamp
        $clock_out_time = new \DateTime($request->input('clock_out_time'));
        $clock_out_year = $clock_out_time->format('Y');
        $clock_out_month = $clock_out_time->format('m');
        $clock_out_day = $clock_out_time->format('d');
        $clock_out_hour = $clock_out_time->format('H');
        $clock_out_minute = $clock_out_time->format('i');
        $clock_out_second = $clock_out_time->format('s');
        $clock_out_time_zone = $clock_out_time->format('T');
        $clock_out_time = Carbon::create(
            $clock_out_year,
            $clock_out_month,
            $clock_out_day,
            $clock_out_hour,
            $clock_out_minute,
            $clock_out_second
        );

        /**
         * Check if the clock out time is later than the clock in time. If it
         * is not, redirect back to the page with the message below.
         */
        if ($clock_in_time > $clock_out_time) {
            $clock_in_time_string = $clock_in_time->toDayDateTimeString();
            return redirect()->back()->with('info', "Make sure to set your clock out time AFTER your clock in time of $clock_in_time_string");
        };

        // Subtract the clock in time from the clock out time to get the duration in minutes
        $duration_in_minutes = $clock_out_time->diffInMinutes($clock_in_time);

        // Retrieve the user's pay rate and calculate the amount to pay
        $amount_to_pay = round(($duration_in_minutes / 60) * $user->pay_rate, 2, PHP_ROUND_HALF_UP);

        // Update the shift and set the 'has_been_paid' status to 'false'
        DB::table('shifts')
        ->where('user_id', $user->id)
        ->latest('created_at')
        ->limit(1)
        ->update([
            'clock_out_time' => $clock_out_time,
            'duration_in_minutes' => $duration_in_minutes,
            'note' => $request->input('note'),
            'amount_to_pay' => $amount_to_pay,
            'has_been_paid' => false
        ]);
        DB::table('users')
        ->where('id', $user->id)
        ->update(['is_clocked_in' => false]);

        // Redirect back with the info.
        return redirect()->back()->with('info', 'User Clocked Out!');
    }
}
