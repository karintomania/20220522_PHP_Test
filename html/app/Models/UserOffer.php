<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserOffer extends Eloquent{
	protected $table = 'user_offer';
	protected $fillable = ['user_id', 'offer_id'];
}