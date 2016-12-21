<?php

namespace Zerg;

use Zerg\Buffer\BitBuffer;
use Zerg\Buffer\BufferInterface;
use Zerg\Buffer\ByteBuffer;

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
	
	/**
	 * Creates and returns an instance of the buffer.
	 *
	 * @param resource $handle
	 * @param int $buffer
	 *
	 * @return \Zerg\Buffer\BufferInterface
	 */
	public function createBuffer($handle, $buffer)
	{
		switch ($buffer)
		{
			case StreamInterface::BUFFER_BYTE:
				
				return new ByteBuffer($handle);
				
			break;
			
			case StreamInterface::BUFFER_BIT:
				
				return new BitBuffer($handle);
				
			break;
		}
		
		throw new \InvalidArgumentException('The buffer type is not supported.');
	}
	
}