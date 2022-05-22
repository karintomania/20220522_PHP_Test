<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent{
	protected $fillable = ['name', 'has_12_months_contract'];

	public function getEligibleOffers(){
		//
	}
}