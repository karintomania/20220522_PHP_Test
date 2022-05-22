<?php

namespace App\Database;

use Illuminate\Database\Capsule\Manager as Capsule;

class Migration{

	private Capsule $capsule;

	public function __construct(Capsule $capsule){
		$this->capsule = $capsule;
	}

	public function migrate(){

        // user table
        $this->capsule::schema()->dropIfExists('user');
        $this->capsule::schema()->dropIfExists('users');
        $this->capsule::schema()->create('users', function ($table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->boolean('has_12_months_contract');
            $table->timestamps();
        });

        // product table
        $this->capsule::schema()->dropIfExists('products');
        $this->capsule::schema()->create('products', function ($table) {
            $table->increments('id');
            $table->string('product_code', 20)->unique();
            $table->string('name', 100);
            $table->float('price', 10, 2);
            $table->timestamps();
        });

        // association table for user and product
        $this->capsule::schema()->dropIfExists('user_product');
        $this->capsule::schema()->create('user_product', function ($table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('product_id');
            $table->timestamps();
        });

        // association table for user and offer
        $this->capsule::schema()->dropIfExists('user_offer');
        $this->capsule::schema()->create('user_offer', function ($table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('offer_id');
            $table->timestamps();
        });

    }
}