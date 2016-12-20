<?php

namespace Zerg\Stream;

use Zerg\Stream\AbstractStream;

/**
 * Class BufferStream
 *
 * @package Zerg
 */
class BufferStream extends AbstractStream
{
	
	/**
	 * Implementations should init buffer itself by given value.
	 *
	 * @param object $buffer Value to init buffer.
	 */
	public function __construct($buffer)
	{
		$this->buffer = $buffer;
	}
	
}