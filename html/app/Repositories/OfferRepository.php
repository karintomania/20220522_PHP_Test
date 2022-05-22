<?php

namespace App\Repositories;

use App\Models\{Product, User, UserProduct};
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
}