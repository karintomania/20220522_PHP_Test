<?php

namespace App\Repositories;

use App\Models\{Product, UserProduct};
use App\Offers\TwelveMonthsOffer;

class OfferRepository {
	private $offers;

	function __construct(){

		$offerClasses = [TwelveMonthsOffer::class];

		foreach($offerClasses as $offerClass){
			$offer = new $offerClass;
			$this->offers[$offer->getOfferId()] = $offer;
		}
		
	}
}