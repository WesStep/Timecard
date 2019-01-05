<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResetController extends Controller
{
	public function resetData() {
		exec('cd ~/timecard; /usr/local/bin/php72 artisan migrate:fresh --seed');
		return redirect()->route('explain')->with('info', 'Database Reset Successful!');
	}
}
