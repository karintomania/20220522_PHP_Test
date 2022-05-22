<?php

namespace App\Repositories;

use App\Models\{Product, UserProduct};

class BasketRepository {
	
	public function addProduct($userId, $productId){
		UserProduct::create(['user_id' => $userId, 'product_id' => $productId]);
	}

}