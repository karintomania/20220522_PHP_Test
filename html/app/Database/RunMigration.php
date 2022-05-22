<?php

use App\Database\Migration;

$container = require __DIR__.'/../bootstrap.php';
$capsule = $container->get('Capsule');

$container->call([Migration::class, 'migrate']);