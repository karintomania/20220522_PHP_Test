<?php

namespace Tests;

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Repositories\OfferRepository;
use App\Models\{User,UserOffer};
use App\Offers\TwelveMonthsOffer;
use App\Database\{Migration, Seeder};

class OfferRepositoryTest extends BaseTest{

	private Capsule $capsule;

	public function setUp(): void {
		$this->capsule = $this::$container->get('Capsule');

		// migrate & seed DB before every tests
		$this::$container->call([Migration::class, 'migrate']);
		$this::$container->call([Seeder::class, 'seed']);
	}

	// test if GetEligibleOffer() returns eligible offer for the user
	public function testGetEligibleOfferReturnsEligibleOffer(){
		$user = User::find(1); // has 12 months contract
		$offerRepository = $this::$container->get(OfferRepository::class);

		$offers = $offerRepository->getEligibleOffers($user);

		$includes12MonthsOffer = collect($offers)
			->reduce(function($carry, $offer){
				return $carry ? true : $offer instanceof TwelveMonthsOffer;
			}, false);

		$this->assertTrue($includes12MonthsOffer);
	}


	// test if GetEligibleOffer() exclude non eligible offer from result
	public function testGetEligibleOfferExcludesNonEligibleOffer(){
		$user = User::find(2); // doesn't have 12 months contract
		$offerRepository = $this::$container->get(OfferRepository::class);

		$offers = $offerRepository->getEligibleOffers($user);

		$includes12MonthsOffer = collect($offers)
			->reduce(function($carry, $offer){
				return $carry ? true : $offer instanceof TwelveMonthsOffer;
			}, false);

		$this->assertFalse($includes12MonthsOffer);
	}

	public function testCalcTotalDiscountForUserSuccess(){

		$userId = 1;
		$totalPrice = 100;
		$offerRepository = $this::$container->get(OfferRepository::class);
		// add offer
		UserOffer::create(['user_id' => 1, 'offer_id' => 0]);

		$discount = $offerRepository->calcTotalDiscountForUser($userId, $totalPrice);

		$this->assertEquals(100 * 0.1, $discount);

	}
}