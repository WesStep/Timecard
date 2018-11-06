<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Shift extends Model
{
	protected $fillable = ['user_id', 'company_id', 'clock_in_time', 'clock_out_time', 'duration_in_minutes', 'note', 'amount_to_pay', 'has_been_paid', 'is_deleted', 'reason_for_deletion'];

	public function users() {
		return $this->belongsTo('App\User');
	}

	public function companies() {
		return $this->hasOne('App\Company');
	}
}
