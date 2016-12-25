<?php

namespace Zerg\Tests;

use Zerg\Endian;

/**
 * Class EndianTest
 *
 * @package Zerg\Tests
 */
class EndianTest extends \PHPUnit_Framework_TestCase
{
	
	public function testConstants()
	{
		$reflactionClass = new \ReflectionClass(Endian::class);
		
		$this->assertArrayHasKey('ENDIAN_LITTLE', $reflactionClass->getConstants());
		$this->assertArrayHasKey('ENDIAN_BIG', $reflactionClass->getConstants());
	}
	
}
