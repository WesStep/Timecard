<?php

namespace App\Http\Controllers;

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
        $id = $request->input('employeeToPay');
        // Select all unpaid shifts of the employee
        $unpaidShifts = DB::table('shifts')
            ->where([
                ['user_id', $id],
                ['has_been_paid', false]
            ])
            ->orderBy('clock_in_time', 'desc')
            ->get();
        // Create the shifts array
        $shifts = array();
        $i = 0;
        foreach($unpaidShifts as $shift)
        {
            $company = $shift->company;
            $clock_in_time = new Carbon($shift->clock_in_time);
            $clock_out_time = new Carbon($shift->clock_out_time);
            $duration = $shift->duration_in_minutes;
            $amount = $shift->amount_to_pay;
            array_push($shifts, [$company, $clock_in_time, $clock_out_time, $duration, $amount]);
            $i ++;
        }

        // Get the totals for the shifts: time worked and amount to pay
        $totalToPay = 0.00;
        $totalTimeWorked = 0;
        foreach($shifts as $shift)
        {
            $totalToPay += $shift[4];
            $totalTimeWorked += $shift[3];
        }
        // Get the employee role_id
        $role_id = DB::table('roles')->where('name', 'employee')->pluck('id');

        // Find employee's info for each employee account
        $users = DB::table('users')->where('role_id', $role_id)->get();
        return view('dashboard/pay', ['role' => session('role'), 'shifts' => $shifts, 'users' => $users, 'totalPay' => $totalToPay, 'totalWorked' => $totalTimeWorked, 'id' => $id]);
    }

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
