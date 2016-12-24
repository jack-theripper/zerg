<?php

namespace Zerg;

use InvalidArgumentException;
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
	 * @var int
	 */
	protected $position = 0;
	
	/**
	 * @var int
	 */
	protected $eofPosition = 0;
	
	/**
	 * @var BufferInterface Object that reads and writes data.
	 */
	protected $buffer;
	
	/**
	 * Gets the current position of the internal stream cursor.
	 *
	 * @return int
	 */
	public function getPosition()
	{
		return $this->position;
	}
	
	/**
	 * Sets the current position.
	 *
	 * @param  int $position
	 *
	 * @return $this
	 */
	public function setPosition($position)
	{
		$this->position = (int) $position;
		
		return $this;
	}
	
	/**
	 * Move internal pointer by given amount of bits ahead without reading dta.
	 *
	 * @param int $size Amount of bits to be skipped.
	 *
	 * @return StreamInterface
	 */
	public function skip($size)
	{
		$this->setPosition($this->getPosition() + $size);
	}
	
	/**
	 * Tests for end-of-file.
	 *
	 * @return bool
	 */
	public function isEof()
	{
		return $this->position >= $this->eofPosition;
	}
	
	/**
	 * You can read the number of bytes.
	 *
	 * @param int $bytesCount
	 *
	 * @return bool
	 */
	public function canReadBytes($bytesCount)
	{
		return $this->getPosition() + (int) $bytesCount <= $this->getEofPosition();
	}
	
	/**
	 * Gets the end-of-file position.
	 *
	 * @return int
	 */
	public function getEofPosition()
	{
		return $this->eofPosition;
	}
	
	/**
	 * Reads a number of bytes equal to $bytesCount from the stream and advances the internal
	 * position by the appropriate amount.
	 *
	 * @param int $bytesCount The number of bytes to read.
	 *
	 * @return string
	 */
	public function readString($bytesCount)
	{
		return $this->buffer->readString((int) $bytesCount);
	}
	
	/**
	 * Read the number of bytes as a integer.
	 *
	 * @param int  $bytesCount
	 * @param bool $signed
	 * @param int  $endian
	 *
	 * @return int
	 */
	public function readInt($bytesCount = 1, $signed = false, $endian = null)
	{
		return $this->buffer->readInt($bytesCount, $signed, $endian);
	}
	
	/**
	 * Writes a number of bytes to the stream and advances the internal
	 * position by the appropriate amount.
	 *
	 * @param string $bytes The bytes to write to the stream.
	 *
	 * @return $this
	 */
	public function writeString($bytes)
	{
		$this->buffer->writeString($bytes);
		
		return $this;
	}
	
	/**
	 * Write the bytes as a integer.
	 *
	 * @param int $value
	 * @param int $bytesCount
	 * @param int $endian
	 *
	 * @return $this
	 */
	public function writeInt($value, $bytesCount = 1, $endian = null)
	{
		$this->buffer->writeInt($value, $bytesCount, $endian);
		
		return $this;
	}
	
	/**
	 * Sets the size.
	 *
	 * @param int $position
	 *
	 * @return $this
	 */
	protected function setEofPosition($position)
	{
		$this->eofPosition = (int) $position;
		
		return $this;
	}
	
	/**
	 * Creates and returns an instance of the buffer.
	 *
	 * @param int $bufferType
	 * @param int $endian
	 *
	 * @return \Zerg\Buffer\BufferInterface
	 * @throws \InvalidArgumentException
	 */
	protected function createBuffer($bufferType, $endian)
	{
		$buffersMap = [
			self::BUFFER_BYTE => ByteBuffer::class,
			self::BUFFER_BIT  => BitBuffer::class
		];
		
		if ( ! isset($buffersMap[$bufferType]))
		{
			throw new InvalidArgumentException('The required buffer type is not supported.');
		}
		
		$bufferType = $buffersMap[$bufferType];
		
		return new $bufferType($endian);
	}
	
	/**
	 * Sets the buffer instance.
	 *
	 * @param \Zerg\Buffer\BufferInterface $buffer
	 *
	 * @return $this
	 */
	protected function setBuffer(BufferInterface $buffer)
	{
		$this->buffer = $buffer;
		$this->buffer->setStream($this);
		
		return $this;
	}
	
}