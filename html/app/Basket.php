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

	function init($user){
		$this->user = $user;

	}

	function add(Product $product){
		$this->basketRepository->addProduct($this->user->id, $product->id);
	}

	function total(){
	}


}