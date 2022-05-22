<?php

namespace App\Offers;

use App\Models\User;

class TwelveMonthsOffer implements Offer{

	const OFFER_ID = 0;

	public function getOfferId():int{
		return self::OFFER_ID;
	}

	public function isEligibleUser(User $user):bool{
		return (bool) $user->has_12_months_contract;
	}

	public function calcDiscountAmount($totalAmount):float{
		return $totalAmount * 0.1;
	}

}