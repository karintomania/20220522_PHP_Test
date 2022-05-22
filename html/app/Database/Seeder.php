<?php

namespace App\Database;

use App\Models\{User, Product};
use Illuminate\Database\Capsule\Manager as Capsule;

class Seeder{

	private Capsule $capsule;

	public function __construct(Capsule $capsule){
		$this->capsule = $capsule;
	}

	public function seed(){

		User::truncate();
		User::create(['name' => 'test', 'has_12_months_contract' => true]);
		User::create(['name' => 'test2', 'has_12_months_contract' => false]);

		Product::truncate();
		Product::create(['product_code' => 'P0001', 'name' => 'Photography', 'price' => 200 ]);
		Product::create(['product_code' => 'P0002', 'name' => 'Floorplan', 'price' => 100]);
		Product::create(['product_code' => 'P0003', 'name' => 'Gas Certificate', 'price' => 83.50]);
		Product::create(['product_code' => 'P0004', 'name' => 'EICR Certificate', 'price' => 51]);

	}

}
