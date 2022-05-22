<?php

namespace Tests;

use App\Test;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Database\{Migration, Seeder};

class BasketTest extends BaseTest{

	private Capsule $capsule;

	public function setUp(): void {
		$this->capsule = $this::$container->get('Capsule');

		// migrate & seed DB before every tests
		$this::$container->call([Migration::class, 'migrate']);
		$this::$container->call([Seeder::class, 'seed']);

	}

	public function test(){

	}
}