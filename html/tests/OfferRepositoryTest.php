<?php

namespace Tests;

use App\Basket;
use App\Repositories\OfferRepository;
use App\Models\{User,UserOffer};
use App\Offers\TwelveMonthsOffer;

class OfferRepositoryTest extends BaseTest{

	public function setUp(): void {
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
}