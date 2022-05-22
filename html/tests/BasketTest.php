<?php

namespace Tests;

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Basket;
use App\Models\{User,UserOffer};
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
		$this->assertEquals(1, $userOffer->user_id);
		$this->assertEquals(0, $userOffer->offer_id);
	}
}