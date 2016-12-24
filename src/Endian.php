<?php

namespace Zerg;

/**
 * Class Endian
 *
 * @package Zerg
 */
class Endian
{
	
	/**
	 * @var int Little endian.
	 */
	const ENDIAN_LITTLE = 1;
	
	/**
	 * @var int Big endian.
	 */
	const ENDIAN_BIG = 2;
	
	/**
	 * @var int Is machine order Big or Little endian.
	 */
	private static $machineEndian;
	
	/**
	 * @return int
	 */
	public static function getMachineEndian()
	{
		if ( ! self::$machineEndian)
		{
			$testInt = 0x00FF;
			$p = pack('S', $testInt);
			self::$machineEndian = $testInt === current(unpack('v', $p)) ? self::ENDIAN_LITTLE : self::ENDIAN_BIG;
		}
		
		return self::$machineEndian;
	}
	
} 