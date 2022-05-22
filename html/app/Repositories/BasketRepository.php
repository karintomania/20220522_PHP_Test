<?php

namespace App\Repositories;

use App\Models\{Product, UserProduct, UserOffer};
use Illuminate\Database\Capsule\Manager as Capsule;

class BasketRepository {

	private Capsule $capsule;

	function __construct(Capsule $capsule){
		$this->capsule = $capsule;
	}

	public function checkIfProductExists($userId, $productId){

		$existingUserProductsCount = UserProduct::where('user_id', $userId)
			->where('product_id', $productId)
			->count();
		
		return $existingUserProductsCount > 0;
	}

	public function getTotalPrice($userId){
		$total = $this->capsule->connection()->table('user_product')
			->join('products', 'product_id', '=', 'products.id')
			->where('user_id', $userId)
			->sum('price');

		return $total;
	}
	
	public function addProduct($userId, $productId){

		return UserProduct::create(['user_id' => $userId, 'product_id' => $productId]);
	}

}