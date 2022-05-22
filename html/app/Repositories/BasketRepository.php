<?php

namespace App\Repositories;

use App\Models\{Product, UserProduct, UserOffer};

class BasketRepository {

	public function addOffer($userId, $offerId){
		UserOffer::create(['user_id' => $userId, 'offer_id' => $offerId]);
	}
	
	public function addProduct($userId, $productId){
		UserProduct::create(['user_id' => $userId, 'product_id' => $productId]);
	}

}