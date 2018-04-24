<?php

namespace App\Http\Controllers;

use Auth;
use App\Shift;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /*
     *  Notes include which type of account or user (if unauthenticated) can access the page.
     */

    public function getArchive(Request $request)
    {
        // Archive page [employee]
        $user = Auth::user();

        // Get the first day for the specified month
        $firstOfTheMonth = new Carbon('first day of ' . $request->month . ' ' . $request->year);

        // Create the monthDays array
        $monthDays = array();

        // Add each subsequent day to the array
        for ($i = 0; $i < $firstOfTheMonth->daysInMonth; $i ++)
        {
            $firstOfTheMonth = new Carbon('first day of' . $request->month . ' ' . $request->year);
            $day = new Carbon($firstOfTheMonth->addDay($i));
            $dayNumber = $day->day;
            $dayName = $day->format('l');
            $shifts = array();
            array_push($monthDays, [$day, $dayNumber, $dayName, $shifts]);
        }

        // Get the shifts for the month according to the user
        $daysInMonth = $firstOfTheMonth->daysInMonth - 1;
        $monthShifts = Shift::selectRaw('day(created_at) day, clock_in_time, clock_out_time, duration_in_minutes, note, amount_to_pay, company_id, has_been_paid')
            ->where('user_id', $user->id)
            ->wherebetween('created_at', array($monthDays[0][0], $monthDays[$daysInMonth][0]))
            ->orderBy('created_at')->get(); // To access clock in time: $monthDays[$i]['clock_in_time']

        $i = 0;
        foreach ($monthDays as $day)
        {
            /*
             * Loop through each shift last week as 'shift' and see if the day tied to the shift matches the current
             * day.
             */
            $x = 0;
            foreach ($monthShifts as $shift)
            {
                // Get the company name from the company_id
                $company_name = DB::table('companies')->where('id', $shift['company_id'])->pluck('name');

                /*
                 * If the shift day number is equal to the week day number, then add the shift to the day array for
                 * shifts. If not, continue with the loop.
                 */
                if (intval($shift['day']) == $day[1])
                {
                    array_push($monthDays[$i][3], []);
                    $clock_in_time = new Carbon($shift['clock_in_time']);
                    $clock_out_time = new Carbon($shift['clock_out_time']);
                    array_push($monthDays[$i][3][$x], $shift['day'], $clock_in_time, $clock_out_time, $shift['duration_in_minutes'], $shift['note'], $company_name[0], $shift['amount_to_pay'], $shift['has_been_paid']);
                    $x ++;
                }
            }
            $i ++;
        }
        // Select the month and year from the shift table for the user and put it in an archives array
        $archives = Shift::selectRaw('year(created_at) year, monthname(created_at) month')->where('user_id', $user->id)->groupBy('year', 'month')->orderByRaw('min(created_at) desc')->get()->toArray();

        return view('dashboard.archive', ['role' => session('role'), 'monthDays' => $monthDays, 'archives' => $archives, 'month' => $request->month, 'year' => $request->year]);
    }

    public function getClock()
    {
        // Clock in/out page [employee]
        // Check if the user is clocked in
        $user = Auth::user();
        $is_clocked_in = $user->is_clocked_in;

        // Get the current date and time time
        $currentTime = new Carbon();
        $currentTime = date("Y-m-d\TH:i", strtotime($currentTime));

        // Get the list of companies from the database
        $companies = DB::table('companies')->where('is_deleted', 'false')->orderBy('name')->get();

        // Redirect back to the clock page
        return view('dashboard.clock', ['role' => session('role'), 'is_clocked_in' => $is_clocked_in, 'companies' => $companies, 'currentTime' => $currentTime]);
    }

    public function getCompany()
    {
        $companies = DB::table('companies')->where('is_deleted', 'false')->orderBy('name')->get();
        // Edit Companies Page [business owner]
        return view('dashboard.company', ['role' => session('role'), 'companies' => $companies]);
    }

    public function getDashboard()
    {
        // Main Dashboard Page [employee, payroll admin, business owner]
        return view('dashboard.index', ['role' => session('role')]);
    }

    public function getDelete()
    {
        // Delete account page [payroll admin, business owner]
        // Get the employee role_id
        $role_id = DB::table('roles')->where('name', 'employee')->pluck('id');
        // Find employee's info for each employee account
        $employee = DB::table('users')->where('role_id', $role_id)->get();
        return view('dashboard.delete', ['role' => session('role'), 'users' => $employee]);
    }

    public function getDisclaimer()
    {
        return view('main.disclaimer', ['role' => session('role')]);
    }

    public function getEdit()
    {
        // Edit account info page [employee, payroll admin, business owner]
        $user = Auth::user();
        return view('dashboard.edit', ['role' => session('role'), 'user' => $user]);
    }

    public function getHistory()
    {
        // Get work history page [employee]
        // Get the currently logged in user
        $user = Auth::user();

        // Create the lastWeek array
        $lastWeek = array();

        // Get the days for the last week
        for ($i = 0; $i < 7; $i ++)
        {
            $day = Carbon::now()->subDay($i);
            $dayNumber = $day->day;
            $dayName = $day->format('l');
            $shifts = array();
            array_push($lastWeek, [$day, $dayNumber, $dayName, $shifts]);
        } // For getting down to the week day number, use this: $lastWeek[$i][1]

        // Get the shifts for the last week according to the user
        $lastWeekShifts = Shift::selectRaw('day(created_at) day, clock_in_time, clock_out_time, duration_in_minutes, note, amount_to_pay, company_id, has_been_paid')
        ->where('user_id', $user->id)
        ->wherebetween('created_at', array($lastWeek[6][0], $lastWeek[0][0]))
        ->orderBy('created_at', 'desc')->get(); // To access clock in time: $lastWeekShifts[$i]['clock_in_time']

        $i = 0;
        foreach ($lastWeek as $day)
        {
            /*
             * Loop through each shift last week as 'shift' and see if the day tied to the shift matches the current
             * day.
             */
            $x = 0;
            foreach ($lastWeekShifts as $shift)
            {
                // Get the company name from the company_id
                $company_name = DB::table('companies')->where('id', $shift['company_id'])->pluck('name');

                /*
                 * If the shift day number is equal to the week day number, then add the shift to the day array for
                 * shifts. If not, continue with the loop.
                 */
                if (intval($shift['day']) == $day[1])
                {
                    array_push($lastWeek[$i][3], []);
                    $clock_in_time = new Carbon($shift['clock_in_time']);
                    $clock_out_time = new Carbon($shift['clock_out_time']);
                    array_push($lastWeek[$i][3][$x], $shift['day'], $clock_in_time, $clock_out_time, $shift['duration_in_minutes'], $shift['note'], $company_name[0], $shift['amount_to_pay'], $shift['has_been_paid']);
                    $x ++;
                }
            }
            $i ++;
        }
        // Select the month and year from the shift table for the user and put it in an archives array
        $archives = Shift::selectRaw('year(created_at) year, monthname(created_at) month')->where('user_id', $user->id)->groupBy('year', 'month')->orderByRaw('min(created_at) desc')->get()->toArray();

        return view('dashboard.history', ['role' => session('role'), 'lastWeek' => $lastWeek, 'archives' => $archives]);
    }

    public function getIndex()
    {
        // Main index page [guests]
        return view('main.index');
    }

    public function getLogin()
    {
        // Login page [authentigating guests]
        return view('auth.login');
    }

    public function getManager()
    {
        // Manage employee accounts page [payroll admin, business owner]
        // Get the employee role_id
        $role_id = DB::table('roles')->where('name', 'employee')->pluck('id');
        // Find employee's info for each employee account
        $employee = DB::table('users')->where('role_id', $role_id)->get();
        return view('dashboard.manage', ['role' => session('role'), 'users' => $employee]);
    }

    public function getPay()
    {
        // Manage Payments page [payroll admin]
        // Get the employee role_id
        $role_id = DB::table('roles')->where('name', 'employee')->pluck('id');
        // Find employee's info for each employee account
        $employee = DB::table('users')->where('role_id', $role_id)->get();
        return view('dashboard.pay', ['role' => session('role'), 'users' => $employee]);
    }

    public function getRegister()
    {
        // Create accounts page [payroll admin, business owner]
        // Get the employee role_id
        $rolesToAssign = DB::table('roles')->get();
        return view('auth.register', ['role' => session('role'), 'rolesToAssign' => $rolesToAssign]);
    }

    public function getStatsWeek()
    {
        // Business stats page [business owner]

        // Grab the Current day and the day a week ago
        $today = Carbon::now();
        $weekAgo = Carbon::now()->subDays(6);

        // Get the employee role_id
        $role_id = DB::table('roles')->where('name', 'employee')->pluck('id');

        // Find employee's info for each employee account
        $employee = DB::table('users')->where('role_id', $role_id)->get();

        // Get the shift hours and notes of employees from the last seven days
        $shifts = [];

        // foreach($employee as $employee)
        // {
        // $userShifts = DB::table('shifts')
        // ->where(['user_id' => $employee->id])
        // ->groupBy('company', 'duration_in_minutes')
        // ->orderBy('company')
        // ->pluck('duration_in_minutes', 'note'); // FIX THIS
        //  }
        // dd($userShifts);
        // Get the current companies
        $companies = DB::table('companies')->where('is_deleted', false)->orderBy('name')->get();
        return view('dashboard.statistics',
            [
                'role' => session('role'),
                'users' => $employee,
                'companies' => $companies,
                'today' => $today,
                'weekAgo' => $weekAgo
            ]
        );
    }

    public function getStatsMonth()
    {

    }

    public function getStatsYear()
    {

    }
}
