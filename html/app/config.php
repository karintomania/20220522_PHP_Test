<?php

use Psr\Container\ContainerInterface;

use Illuminate\Database\Capsule\Manager as Capsule;

return [
		'Capsule' => function (ContainerInterface $c) {
			$capsule = new Capsule;

			$capsule->addConnection([
				'driver'   => 'sqlite',
				'database' => __DIR__.'/Database/db.sqlite',
				'prefix'   => '',
			], 'default');

			$capsule->setAsGlobal();
			$capsule->bootEloquent();

			return $capsule;
    },
];