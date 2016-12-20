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
	 * @return BufferInterface
	 */
	public function setPosition($position);
	
	/**
	 * Gets the eof position.
	 *
	 * @return int
	 */
	public function getSize();
	
	/**
	 * @param int $bytesCount
	 *
	 * @return string
	 */
	public function read($bytesCount);
	
	/**
	 * @param string $bytes
	 *
	 * @return BufferInterface
	 */
	public function write($bytes);
	
	/**
	 * @param int  $bytes
	 * @param bool $signed
	 * @param int  $endian
	 *
	 * @return int
	 */
	public function readInt($bytes = 1, $signed = false, $endian = null);
	
	/**
	 * @param int $int
	 * @param int $bytes
	 * @param int $endian
	 *
	 * @return BufferInterface
	 */
	public function writeInt($int, $bytes = 1, $endian = null);
	
}