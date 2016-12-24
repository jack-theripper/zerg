<?php

namespace Zerg;

/**
 * Interface StreamInterface.
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
	 * Gets the current position of the internal stream cursor.
	 *
	 * @return int
	 */
	public function getPosition();
	
	/**
	 * Sets the current position.
	 *
	 * @param  int $position
	 *
	 * @return StreamInterface
	 */
	public function setPosition($position);
	
	/**
	 * Move internal pointer by given amount of bits ahead without reading dta.
	 *
	 * @param int $size Amount of bits to be skipped.
	 *
	 * @return StreamInterface
	 */
	public function skip($size);
	
	/**
	 * Tests for end-of-file.
	 *
	 * @return bool
	 */
	public function isEof();
	
	/**
	 * You can read the number of bytes.
	 *
	 * @param int $bytesCount
	 *
	 * @return bool
	 */
	public function canReadBytes($bytesCount);
	
	/**
	 * Gets the end-of-file position.
	 *
	 * @return int
	 */
	public function getEofPosition();
	
	/**
	 * Reads a number of raw bytes.
	 *
	 * @param int $bytesCount The number of bytes to read.
	 *
	 * @return string
	 */
	public function read($bytesCount = 1);
	
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
	 * Writes a number of bytes.
	 *
	 * @param string $bytes The bytes to write to the stream.
	 *
	 * @return StreamInterface
	 */
	public function write($bytes);
	
	/**
	 * Writes a number of bytes to the stream and advances the internal
	 * position by the appropriate amount.
	 *
	 * @param string $bytes The bytes to write to the stream.
	 *
	 * @return StreamInterface
	 */
	public function writeString($bytes);
	
	/**
	 * Write the bytes as a integer.
	 *
	 * @param int $value
	 * @param int $bytesCount
	 * @param int $endian
	 *
	 * @return StreamInterface
	 */
	public function writeInt($value, $bytesCount = 1, $endian = null);
	
}