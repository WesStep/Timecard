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
        // Get user's first name
        // Get user data
        $user = Auth::user();
        // Separate first and last names
        $userName = explode(' ', $user->name);
        // Select just the first name
        $userFirstName = $userName[0];
        // Get the user's role_id and match it with a role
        $role = DB::table('roles')->where('id', $user->role_id)->pluck('name');
        // Set the session variable 'role' to reduce number of DB queries
        session(['role' => $role]);
        return view('dashboard.index', ['userFirstName' => $userFirstName, 'role' => session('role')]);
    }
}
