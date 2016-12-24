<?php

namespace Zerg\Buffer;

use Zerg\StreamInterface;

/**
 * Interface BufferInterface
 *
 * @package Zerg\Buffer
 */
interface BufferInterface
{
	
	/**
	 * Gets the endian.
	 *
	 * @return int
	 */
	public function getEndian();
	
	/**
	 * Sets the current endian.
	 *
	 * @param int $endian
	 *
	 * @return BufferInterface
	 */
	public function setEndian($endian);
	
	/**
	 * Reads a number of bytes equal to $bytesCount from the stream and advances the internal
	 * position by the appropriate amount.
	 *
	 * @param int $bytesCount The number of bytes to read.
	 *
	 * @return string
	 */
	public function readString($bytesCount);
	
	/**
	 * Read the number of bytes as a integer.
	 *
	 * @param int  $bytesCount
	 * @param bool $signed
	 * @param int  $endian
	 *
	 * @return int
	 */
	public function readInt($bytesCount = 1, $signed = false, $endian = null);
	
	/**
	 * Writes a number of bytes to the stream and advances the internal
	 * position by the appropriate amount.
	 *
	 * @param string $bytes The bytes to write to the stream.
	 *
	 * @return BufferInterface
	 */
	public function writeString($bytes);
	
	/**
	 * Write the bytes as a integer.
	 *
	 * @param int $value
	 * @param int $bytesCount
	 * @param int $endian
	 *
	 * @return BufferInterface
	 */
	public function writeInt($value, $bytesCount = 1, $endian = null);
	
	/**
	 * Sets the stream instance.
	 *
	 * @param \Zerg\StreamInterface $stream
	 *
	 * @return BufferInterface
	 */
	public function setStream(StreamInterface $stream);
	
}