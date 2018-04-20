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
            $company = $shift->company;
            $clock_in_time = date("Y-m-d\TH:i", strtotime($shift->clock_in_time));
            $clock_out_time = date("Y-m-d\TH:i", strtotime($shift->clock_out_time));
            $duration = $shift->duration_in_minutes;
            $amount = $shift->amount_to_pay;
            array_push($shifts, [$id, $company, $clock_in_time, $clock_out_time, $duration, $amount]);
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
            'id' => $id,
            'companies' => $companies
        ]);
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
