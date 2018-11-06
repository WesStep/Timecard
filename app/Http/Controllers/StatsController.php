<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Illuminate\Validation\Rule;

class StatsController extends Controller
{
	public function getStats(Request $request) {
		// Validate input
		$this->validate($request, [
			'length' => [
				'string',
				Rule::in(['custom', 'week', 'month', 'quarter', 'year']),
			],
		]);

		// Set variables
		$employees = $this->getEmployees();
		$timeFrame = $this->getTimeframe($request);
		$shifts = $this->getShifts($timeFrame['startDate'], $timeFrame['endDate']);
		$companies = $this->getCompanies();
		$totalShiftsPerEmployee = $this->getTotalShiftsPerEmployee($timeFrame['startDate'], $timeFrame['endDate'], $employees);
		$totalMinutesPerEmployee = $this->getTotalMinutesPerEmployee($timeFrame['startDate'], $timeFrame['endDate'], $employees);
		$totalWagesPerEmployee = $this->getTotalWagesPerEmployee($timeFrame['startDate'], $timeFrame['endDate'], $employees);
		$totalShifts = $this->getTotalShifts($timeFrame['startDate'], $timeFrame['endDate']);
		$totalMinutes = $this->getTotalMinutes($timeFrame['startDate'], $timeFrame['endDate']);
		$totalWages = $this->getTotalWages($timeFrame['startDate'], $timeFrame['endDate']);

		return view('dashboard/statistics', [
			'role' => session('role'),
			'shifts' => $shifts,
			'companies' => $companies,
			'employees' => $employees,
			'startDate' => $timeFrame['startDate'],
			'endDate' => $timeFrame['endDate'],
			'totalShiftsPerEmployee' => $totalShiftsPerEmployee,
			'totalMinutesPerEmployee' => $totalMinutesPerEmployee,
			'totalWagesPerEmployee' => $totalWagesPerEmployee,
			'totalShifts' => $totalShifts,
			'totalMinutes' => $totalMinutes,
			'totalWages' => $totalWages
		]);
	}

	private function getEmployees() {
		// Get the employee's info for each employee account
		$role_id = DB::table('roles')->where('name', 'employee')->pluck('id');
		return DB::table('users')->where('role_id', $role_id)->get();
	}

	private function getTimeframe(Request $request) {
		if ($request->input('length') != 'custom') {
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
			return [
				'startDate' => $startDate,
				'endDate' => $endDate,
			];
		}

		$startDate = new Carbon($request->input('startDate'));
		$endDate = new Carbon($request->input('endDate'));
		if ($startDate > $endDate) {
			return redirect()
				->back()
				->with('info', 'Start date must come BEFORE end date.');
		}
		return [
			'startDate' => $startDate,
			'endDate' => $endDate,
		];
	}

	private function getShifts($startDate, $endDate) {
		// Gets the shifts and all associated information for the date range
		$shifts = DB::table('shifts')
			->whereBetween('clock_in_time', [
				$startDate->toDateTimeString(),
				$endDate->toDateTimeString(),
			])
			->orderBy('company_id')
			->orderBy('id')
			->get();

		foreach ($shifts as $shift) {
			$shift->clock_in_time = \DateTime::createFromFormat('Y-m-d H:i:s', $shift->clock_in_time)->format('j M Y \\a\\t g:i a');
			if ($shift->clock_out_time != null) {
				$shift->clock_out_time = \DateTime::createFromFormat('Y-m-d H:i:s', $shift->clock_out_time)->format('j M Y \\a\\t g:i a');
			} else {
				$shift->clock_out_time = \DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', time()))->format('j M Y \\a\\t g:i a');
			}
		}
		return $shifts;
	}

	private function getCompanies() {
		$companies = DB::table('companies')->where('is_deleted', false)->get();
		return $companies;
	}

	private function getTotalShiftsPerEmployee($startDate, $endDate, $employees) {
		foreach ($employees as $employee) {
			$total = DB::table('shifts')
				->where('user_id', $employee->id)
				->whereBetween('clock_in_time', [$startDate, $endDate])
				->count();
			$totals[$employee->name] = $total;
		}
		return $totals;
	}

	/**
	 * This function returns a number that represents the minutes that the employee has worked.
	 * @param $startDate
	 * @param $endDate
	 * @param $employees
	 * @return array $totals
	 */
	private function getTotalMinutesPerEmployee($startDate, $endDate, $employees) {
		foreach ($employees as $employee) {
			$total = DB::table('shifts')
				->where('user_id', $employee->id)
				->whereBetween('clock_in_time', [$startDate, $endDate])
				->sum('duration_in_minutes');
			$lastShift = DB::table('shifts')
				->where('user_id', $employee->id)
				->where('clock_out_time', null)
				->get();
			if ($lastShift[0]->clock_out_time == null) {
				$currentShiftMinutes = Carbon::now()->diffForHumans(Carbon::create($startDate));
				dd($currentShiftMinutes);
			}
			$totals[$employee->name] = $total;
		}
		return $totals;
	}

	private function getTotalWagesPerEmployee($startDate, $endDate, $employees) {
		foreach ($employees as $employee) {
			$total = DB::table('shifts')
				->where('user_id', $employee->id)
				->whereBetween('clock_in_time', [$startDate, $endDate])
				->sum('amount_to_pay');
			$totals[$employee->name] = $total;
		}
		return $totals;
	}

	private function getTotalShifts($startDate, $endDate) {
		return DB::table('shifts')->whereBetween('clock_in_time', [$startDate, $endDate])->count();
	}

	private function getTotalMinutes($startDate, $endDate) {
		return DB::table('shifts')->whereBetween('clock_in_time', [$startDate, $endDate])->sum('duration_in_minutes');
	}

	private function getTotalWages($startDate, $endDate) {
		return DB::table('shifts')->whereBetween('clock_in_time', [$startDate, $endDate])->sum('amount_to_pay');
	}
}
