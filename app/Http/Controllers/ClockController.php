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
        // Get the current date and time time
        $dateTime = new Carbon();
        // Verify that the company the user submitted is legitimate
        $this->validate($request, [
            'company' => 'required|string|max:100|exists:companies,name' // Add verification: if is_deleted is true, then don't allow
        ]);
        // Create the new shift in the database
        $shift = new Shift([
            'user_id' => $user->id,
            'company' => $request->input('company'),
            'clock_in_time' => $dateTime,
            'clock_out_time' => null,
            'duration_in_minutes' => null,
            'note' => null,
            'amount_to_pay' => null,
            'has_been_paid' => false,
            'is_deleted' => false
        ]);
        $user->shifts()->save($shift);
        // Update the user's status to clocked in
        DB::table('users')->where('id', $user->id)->update(['is_clocked_in' => true]);
        // Redirect back with the info.
        return redirect()->back()->with('info', 'User Clocked In!');
    }

    public function clockOut(Request $request)
    {
        // Validate the user's note for the shift
        $validatedData = $request->validate([
            'note' => 'required|max:140|string'
        ]);
        // Get the currently logged in user
        $user = Auth::user();
        // Get the clock in dateTime stamp
        $clock_in_time = DB::table('shifts')->where('user_id', $user->id)->latest()->pluck('clock_in_time');
        $clock_in_time = Carbon::parse($clock_in_time[0]);
        // Get the clock out dateTime stamp
        $clock_out_time = new Carbon();
        // Subtract the clock in time from the clock out time to get the duration in minutes
        $duration_in_minutes = $clock_out_time->diffInMinutes($clock_in_time);
        // Retrieve the user's pay rate and calculate the amount to pay
        $amount_to_pay = round(($duration_in_minutes / 60) * $user->pay_rate, 2, PHP_ROUND_HALF_UP);
        // Update the shift and set the 'has_been_paid' status to 'false'
        DB::table('shifts')->where('user_id', $user->id)->latest('created_at')->limit(1)->update([
            'clock_out_time' => $clock_out_time,
            'duration_in_minutes' => $duration_in_minutes,
            'note' => $request->input('note'),
            'amount_to_pay' => $amount_to_pay,
            'has_been_paid' => false
        ]);
        DB::table('users')->where('id', $user->id)->update(['is_clocked_in' => false]);
        // Redirect back with the info.
        return redirect()->back()->with('info', 'User Clocked Out!');
    }
}
