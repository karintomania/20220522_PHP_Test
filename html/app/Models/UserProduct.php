<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserProduct extends Eloquent{
	protected $table = 'user_product';
	protected $fillable = ['user_id', 'product_id'];
}