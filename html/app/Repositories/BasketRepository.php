<?php

namespace App\Repositories;

use App\Models\{Product, UserProduct, UserOffer};

class BasketRepository {

	public function addOffer($userId, $offerId){
		UserOffer::create(['user_id' => $userId, 'offer_id' => $offerId]);
	}

	public function checkIfProductExists($userId, $productId){

		$existingUserProductsCount = UserProduct::where('user_id', $userId)
			->where('product_id', $productId)
			->count();
		
		return $existingUserProductsCount > 0;
	}
	
	public function addProduct($userId, $productId){

		return UserProduct::create(['user_id' => $userId, 'product_id' => $productId]);
	}

}