<?php

namespace Zerg;

use Zerg\Buffer\BufferInterface;

/**
 * Interface StreamInterface
 *
 * @package Zerg
 */
interface StreamInterface
{
	
	/**
	 * @var int Byte buffer.
	 */
	const BUFFER_BYTE = 1;
	
	/**
	 * @var int Bit buffer.
	 */
	const BUFFER_BIT = 2;
	
	/**
	 * Getter for $buffer property.
	 *
	 * @return BufferInterface Object that reads data from file|memory stream.
	 */
	public function getBuffer();
	
	/**
	 * Move internal pointer by given amount of bits ahead without reading dta.
	 *
	 * @param int $size Amount of bits to be skipped.
	 */
	public function skip($size);
	
}