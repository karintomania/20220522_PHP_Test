<?php

namespace App;

use App\Repositories\{BasketRepository, OfferRepository};
use App\Models\{User, Product};

class Basket {
	
	private BasketRepository $basketRepository;
	private OfferRepository $offerRepository;
	private User $user;

	function __construct(BasketRepository $basketRepository, OfferRepository $offerRepository){
		$this->basketRepository = $basketRepository;
		$this->offerRepository = $offerRepository;
	}

	// save eligible offers to the user
	function init($user){
		$this->user = $user;
		$eligibleOffers = $this->offerRepository->getEligibleOffers($user);

		foreach($eligibleOffers as $offer){
			$this->basketRepository->addOffer($this->user->id, $offer->getOfferId());
		}
	}

	function add(Product $product){

		$ifProductExists = $this->basketRepository->checkIfProductExists($this->user->id, $product->id);

		if($ifProductExists)
			throw new \InvalidArgumentException('This product is already added to the basket.');

		return $this->basketRepository->addProduct($this->user->id, $product->id);

	}

	function total(){
	}


}