<?php

namespace App\Repositories;

use App\Models\{Product, User, UserOffer, UserProduct};
use App\Offers\{Offer, TwelveMonthsOffer};

class OfferRepository {
	private $offers;

	function __construct(){

		$offerClasses = [TwelveMonthsOffer::class];

		foreach($offerClasses as $offerClass){
			$offer = new $offerClass;
			$this->offers[$offer->getOfferId()] = $offer;
		}
		
	}

	function getEligibleOffers($user){
		$eligibleOffers = [];
		foreach($this->offers as $offer){
			if($offer->isEligibleUser($user)){
				$eligibleOffers[] = $offer;
			}
		}
		return $eligibleOffers;
	}

	function addOffer($userId, $offerId){
		UserOffer::create(['user_id' => $userId, 'offer_id' => $offerId]);
	}


	function calcTotalDiscountForUser($userId, $originalPrice){

		$discount = 0;
		$userOffers = $this->getAddedOffersForUser($userId);

		foreach($userOffers as $userOffer){
			$offer = $this->offers[$userOffer->offer_id];

			$discount += $offer->calcDiscountAmount($originalPrice);
		}

		return $discount;

	}

	function getAddedOffersForUser($userId){
		return UserOffer::select('offer_id')->where('user_id', $userId)->get();

	}

}