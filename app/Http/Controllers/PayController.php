<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class PayController extends Controller
{
    public function getEmployee(Request $request)
    {
        $this->validate($request, [
            'employeeToPay' => 'integer|exists:users,id'
        ]);
        $employee_id = $request->input('employeeToPay');

        // Select all unpaid shifts of the employee
        $unpaidShifts = DB::table('shifts')
        ->where([
            ['user_id', $employee_id],
            ['has_been_paid', false],
            ['is_deleted', false]
        ])
        ->orderBy('clock_in_time', 'desc')
        ->get();
        // Select all companies that are not deleted
        $companies = DB::table('companies')
        ->where('is_deleted', false)
        ->orderBy('name')
        ->get();

        // Create the shifts array
        $shifts = array();
        $i = 0;
        foreach($unpaidShifts as $shift)
        {
            $id = $shift->id;
            $company = $shift->company_id;
            $clock_in_time = date("Y-m-d\TH:i", strtotime($shift->clock_in_time));
            $clock_out_time = date("Y-m-d\TH:i", strtotime($shift->clock_out_time));
            $duration = $shift->duration_in_minutes;
            $amount = $shift->amount_to_pay;
            array_push($shifts, [
                $id,
                $company,
                $clock_in_time,
                $clock_out_time,
                $duration,
                $amount
            ]);
            $i ++;
        }

        // Get the totals for the shifts: time worked and amount to pay
        $totalToPay = 0.00;
        $totalTimeWorked = 0;
        foreach($shifts as $shift)
        {
            $totalToPay += $shift[5];
            $totalTimeWorked += $shift[4];
        }

        // Get the employee role_id
        $role_id = DB::table('roles')->where('name', 'employee')->pluck('id');
        // Find employee's info for each employee account
        $users = DB::table('users')->where('role_id', $role_id)->get();
        return view('dashboard/pay', [
            'role' => session('role'),
            'shifts' => $shifts,
            'users' => $users,
            'totalPay' => $totalToPay,
            'totalWorked' => $totalTimeWorked,
            'employee_id' => $employee_id,
            'companies' => $companies
        ]);
    }

    /**
     * Sets the associated shift to an 'is_deleted' state.
     *
     * Since it will be set to a deleted state, it will not actually be
     * removed from the DB, but it will NOT show up anymore in the client-
     * facing views.
     *
     * @param  Request $request [Contains the shift in question.]
     * @return [void]
     */
    public function deleteShift(Request $request)
    {
        $this->validate($request, [
            'employee_id' => 'required|exists:users,id|integer',
            'shift_id' => 'required|exists:shifts,id|integer',
            'reason_for_deletion' => 'required|string|max:140'
        ]);

        DB::table('shifts')
        ->where([
            ['user_id', '=', $request->input('employee_id')],
            ['id', '=', $request->input('shift_id')]
        ])
        ->update([
            'is_deleted' => true,
            'reason_for_deletion' => $request->input('reason_for_deletion')
        ]);

        return redirect()->back()->with('info', 'Shift has been deleted!');
    }

    /**
     * Updates the associated shift according to the changes the payroll admin
     * makes to it.
     *
     * @param  Request $request [Contains the shift info and changes to make.]
     * @return [void]
     */
    public function editShift(Request $request)
    {
        $this->validate($request, [
            'employee_id' => 'required|exists:users,id|integer',
            'shift_id' => 'required|exists:shifts,id|integer',
            'company_id' => 'required|exists:companies,id|integer',
            'clock_in_time' => 'required|date',
            'clock_out_time' => 'required|date'
        ]);

        // Format the clock in and clock out times
        // Clock In
        $clock_in_time = new \DateTime($request->input('clock_in_time'));
        $clock_in_year = $clock_in_time->format('Y');
        $clock_in_month = $clock_in_time->format('m');
        $clock_in_day = $clock_in_time->format('d');
        $clock_in_hour = $clock_in_time->format('H');
        $clock_in_minute = $clock_in_time->format('i');
        $clock_in_second = $clock_in_time->format('s');
        $clock_in_time_zone = $clock_in_time->format('T');
        $clock_in_time = Carbon::create(
            $clock_in_year,
            $clock_in_month,
            $clock_in_day,
            $clock_in_hour,
            $clock_in_minute,
            $clock_in_second
        );

        // Clock Out
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

        /**
         * Update the duration in minutes and the amount to pay variables.
         */
        $duration_in_minutes =  $clock_out_time->diffInMinutes($clock_in_time);

        // Retrieve the user's pay rate and calculate the amount to pay
        $pay_rate = DB::table('users')->where('id', $request->input('employee_id'))->pluck('pay_rate');
        $amount_to_pay = round(($duration_in_minutes / 60) * $pay_rate[0], 2, PHP_ROUND_HALF_UP);

        // Update the shifts table where the shift ID matches
        DB::table('shifts')->where([
            ['user_id', '=', $request->input('employee_id')],
            ['id', '=', $request->input('shift_id')]
        ])
        ->update([
            'company_id' => $request->input('company_id'),
            'clock_in_time' => $request->input('clock_in_time'),
            'clock_out_time' => $request->input('clock_out_time'),
            'duration_in_minutes' => $duration_in_minutes,
            'amount_to_pay' => $amount_to_pay
        ]);

        // Redirect back to the pay page
        return redirect()->back()->with('info', 'Shift updated!');
    }

    /**
     * Records all shifts currently unpaid for employee as 'paid'.
     * @param  Request $request [Contains the shifts to mark as paid.]
     * @return [void]
     */
    public function recordPayment(Request $request)
    {
        // Validate the correct input for the employee ID
        $this->validate($request, [
            'paid' => 'required',
            'employee_id' => 'integer|exists:users,id'
        ]);
        $id = $request->input('employee_id');
        // Update all unpaid shifts of the employee and set 'has_been_paid' to true
        DB::table('shifts')
            ->where([
                ['user_id', $id],
                ['has_been_paid', false]
            ])
            ->update(['has_been_paid' => true]);
        return redirect()->back()->with('info', 'Shift(s) have been paid for.');
    }
}
