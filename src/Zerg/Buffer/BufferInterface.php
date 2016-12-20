<?php

namespace Zerg\Buffer;

/**
 * Interface BufferInterface
 *
 * @package Zerg\Buffer
 */
interface BufferInterface
{
	
	/**
	 * Gets the current position of the internal stream cursor.
	 *
	 * @return int
	 */
	public function getPosition();
	
	/**
	 * Sets the current position.
	 *
	 * @param int $position
	 *
	 * @return $this
	 */
	public function setPosition($position);
	
}