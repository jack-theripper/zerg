<?php

namespace Zerg;

use Zerg\Buffer\BufferInterface;

/**
 * Class StreamTrait
 *
 * @package Zerg
 */
trait StreamTrait
{
	
	/**
	 * @var BufferInterface Object that reads and writes data from|to file|memory stream.
	 */
	protected $buffer;
	
	/**
	 * Getter for $buffer property.
	 *
	 * @return BufferInterface Object that reads data from file|memory stream.
	 */
	public function getBuffer()
	{
		return $this->buffer;
	}
	
	/**
	 * Move internal pointer by given amount of bits ahead without reading dta.
	 *
	 * @param int $size Amount of bits to be skipped.
	 *
	 * @return $this
	 */
	public function skip($size)
	{
		$this->getBuffer()->setPosition($this->getBuffer()->getPosition() + $size);
		
		return $this;
	}
	
}