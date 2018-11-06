<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
	protected $fillable = ['name', 'is_deleted'];

	public function shifts() {
		return $this->hasMany('App\Shift');
	}
}
