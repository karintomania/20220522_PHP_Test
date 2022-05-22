<?php

namespace Tests;

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Basket;
use App\Models\{User,UserOffer, Product, UserProduct};
use App\Database\{Migration, Seeder};

class BasketTest extends BaseTest{

	private Capsule $capsule;

	public function setUp(): void {
		$this->capsule = $this::$container->get('Capsule');

		// migrate & seed DB before every tests
		$this::$container->call([Migration::class, 'migrate']);
		$this::$container->call([Seeder::class, 'seed']);

	}

	public function testInitSavesEligibleOffers(){
		$user =	User::find(1);

		$basket = $this::$container->get(Basket::class);
		$basket->init($user);
		// get the saved offers for the user
		$userOffers = UserOffer::where('user_id', $user->id)
			->get();

		$this->assertEquals(1, count($userOffers));
		$userOffer = $userOffers[0];
		$this->assertEquals($user->id, $userOffer->user_id);
		$this->assertEquals(0, $userOffer->offer_id);
	}

	public function testAddSavesProduct(){
		$user =	User::find(1);

		$basket = $this::$container->get(Basket::class);
		$basket->init($user);

		$product = Product::find(1);

		$basket->add($product);

		$userProducts = UserProduct::where('user_id', $user->id)->get();		

		$this->assertEquals(1, count($userProducts));
		$userProduct = $userProducts[0];
		$this->assertEquals($product->id, $userProduct->product_id);

	}

	public function testAddThrowsExceptionForDuplicateProduct(){
		$user =	User::find(1);

		$basket = $this::$container->get(Basket::class);
		$basket->init($user);

		$product = Product::find(1);

		$basket->add($product);

		// throw exception for duplicated product
		$this->expectException(\InvalidArgumentException::class);
		$basket->add($product);

	}

	public function testTotalWithDiscount(){
		$user =	User::find(1);

		$basket = $this::$container->get(Basket::class);
		$basket->init($user);

		$products = [];
		$products[] = Product::find(1);
		$products[] = Product::find(2);
		$products[] = Product::find(3);

		foreach($products as $product){ $basket->add($product); }

		$total = $basket->total();

		$expectedTotal = collect($products)->reduce(function($total, $product){
			return $total + $product->price;
		}, 0); // total of the products
		$expectedTotal *= 0.9; // discount

		$this->assertEquals($expectedTotal, $total);

	}

	public function testTotalWithoutDiscount(){
		$user =	User::find(2);

		$basket = $this::$container->get(Basket::class);
		$basket->init($user);

		$products = [];
		$products[] = Product::find(1);
		$products[] = Product::find(2);
		$products[] = Product::find(3);

		foreach($products as $product){ $basket->add($product); }

		$total = $basket->total();

		$expectedTotal = collect($products)->reduce(function($total, $product){
			return $total + $product->price;
		}, 0);

		$this->assertEquals($expectedTotal, $total);

	}
}