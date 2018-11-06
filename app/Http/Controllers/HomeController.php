<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$user = Auth::user();
		$userName = explode(' ', $user->name);
		$userFirstName = $userName[0];
		$role = DB::table('roles')->where('id', $user->role_id)->pluck('name');
		session(['role' => $role]);

		return view('dashboard.index', [
			'userFirstName' => $userFirstName,
			'role' => session('role')
		]);
	}
}
