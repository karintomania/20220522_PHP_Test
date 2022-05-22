<?php

namespace Tests;

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Repositories\BasketRepository;
use App\Models\{Product,UserProduct};
use App\Database\{Migration, Seeder};

class BasketRepositoryTest extends BaseTest{

	private Capsule $capsule;

	public function setUp(): void {
		$this->capsule = $this::$container->get('Capsule');

		// migrate & seed DB before every tests
		$this::$container->call([Migration::class, 'migrate']);
		$this::$container->call([Seeder::class, 'seed']);
	}


	public function testCheckIfProductExistsReturnsTrue(){

		$userId = 1;
		$productId = 1;
		UserProduct::create(['user_id'=>$userId, 'product_id'=>$productId]);

		$basketRepository = $this::$container->get(BasketRepository::class);

		$productExists = $basketRepository->checkIfProductExists($userId, $productId);

		$this->assertTrue($productExists);
		
	}

	public function testCheckIfProductExistsReturnsFalse(){

		$userId = 1;
		$productId = 1;

		$basketRepository = $this::$container->get(BasketRepository::class);

		$productExists = $basketRepository->checkIfProductExists($userId, $productId);

		$this->assertFalse($productExists);
	}


	public function testGetTotalPrice(){

		$userId = 1;
		$products = [];
		$products[] = Product::find(2);
		$products[] = Product::find(3);
		$products[] = Product::find(4);

		$expectedTotal = 0;

		foreach($products as $product){ 

			UserProduct::create(['user_id'=>$userId, 'product_id'=>$product->id]);
			$expectedTotal += $product->price;

		 }

		$basketRepository = $this::$container->get(BasketRepository::class);
		$total = $basketRepository->getTotalPrice($userId);

		$this->assertEquals($expectedTotal, $total);

	}

}