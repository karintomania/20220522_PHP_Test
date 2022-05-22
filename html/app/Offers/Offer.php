<?php

namespace App\Offers;

use App\Models\User;

interface Offer {
	public function getOfferId():int;
	public function isEligibleUsers(User $user):bool;
	public function calcDiscountAmount($totalAmount):float;
}