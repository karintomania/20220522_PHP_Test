<?php

namespace App;

use App\Repositories\{ProductRepository, OfferRepository};
use App\Models\{User, Product};

class Basket {
	
	private ProductRepository $ProductRepository;
	private OfferRepository $offerRepository;
	private User $user;

	function __construct(ProductRepository $ProductRepository, OfferRepository $offerRepository){
		$this->ProductRepository = $ProductRepository;
		$this->offerRepository = $offerRepository;
	}

	// save eligible offers to the user
	function init($user){
		$this->user = $user;
		$eligibleOffers = $this->offerRepository->getEligibleOffers($user);

		foreach($eligibleOffers as $offer){
			$this->offerRepository->addOffer($this->user->id, $offer->getOfferId());
		}
	}

	function add(Product $product){

		$ifProductExists = $this->ProductRepository->checkIfProductExists($this->user->id, $product->id);

		if($ifProductExists)
			throw new \InvalidArgumentException('This product is already added to the basket.');

		return $this->ProductRepository->addProduct($this->user->id, $product->id);

	}

	function total(){
		$totalRawPrice = $this->ProductRepository->getTotalPrice($this->user->id);
		$discount = $this->offerRepository->calcTotalDiscountForUser($this->user->id, $totalRawPrice);

		return $totalRawPrice - $discount;
	}


}