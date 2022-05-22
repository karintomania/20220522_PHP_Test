<?php

namespace Tests;
use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase{
	static $container;

	public static function setUpBeforeClass(): void{
		self::$container = require __DIR__.'/../app/bootstrap.php';
	}

}