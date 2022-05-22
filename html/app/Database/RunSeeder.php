<?php

use App\Database\Seeder;

$container = require __DIR__.'/../bootstrap.php';
$capsule = $container->get('Capsule');

$container->call([Seeder::class, 'seed']);