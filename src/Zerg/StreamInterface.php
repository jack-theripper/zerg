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