<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class StatsController extends Controller
{
    private function getShifts($startDate, $endDate)
    {
        // Gets the shifts and all associated information for the date range
        $shifts = DB::table('shifts')
        ->whereBetween('clock_in_time', [
            $startDate->toDateTimeString(),
            $endDate->toDateTimeString()
        ])
        ->orderBy('company_id')
        ->get();
        return $shifts;
    }

    private function getCompanies()
    {
        $companies = DB::table('companies')->where('is_deleted', false)->get();
        return $companies;
    }

    public function getStats(Request $request)
    {
        /**
         * This method checks the inputs and, depending on if the length string
         * is a default length or a custom length, it will set the start and end
         * dates and fetch the shifts accordingly. Then it will send the shift
         * data to the view.
         */

        // Get the employee's info for each employee account
        $role_id = DB::table('roles')->where('name', 'employee')->pluck('id');
        $employees = DB::table('users')->where('role_id', $role_id)->get();

        // Get the timeframe for searching for shifts
        if ($request->input('length') != 'custom') {
            // Set the start and end dates to today
            $endDate = new Carbon();
            $startDate = new Carbon();

            /**
             * Depending on what the requested start date is, set the end date
             * accordingly.
             */
            switch ($request->input('length')) {
                case 'week':
                    $startDate = $startDate->subDays(6);
                    break;
                case 'month':
                    $startDate = $startDate->subMonth();
                    break;
                case 'quarter':
                    $startDate = $startDate->subMonths(3);
                    break;
                case 'year':
                    $startDate = $startDate->subYear();
                    break;
            }
            $shifts = $this->getShifts($startDate, $endDate);
            $companies = $this->getCompanies();
            return view('dashboard/statistics', [
                'role' => session('role'),
                'shifts' => $shifts,
                'companies' => $companies,
                'employees' => $employees,
                'startDate' => $startDate,
                'endDate' => $endDate
            ]);
        }

        $endDate = new Carbon($request->input('startDate'));
        $startDate = new Carbon($request->input('endDate'));

        if (!$startDate < $endDate) {
            return redirect()
            ->back()
            ->with('info', 'Start date must come BEFORE end date.');
        }

        $shifts = $this->getShifts($startDate, $endDate);
        $companies = $this->getCompanies();
        return view('dashboard/statistics', [
            'role' => session('role'),
            'shifts' => $shifts,
            'companies' => $companies,
            'employees' => $employees,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);
    }
}
