<?php

namespace Zerg;

use InvalidArgumentException;
use OutOfBoundsException;
use Zerg\Buffer\BitBuffer;
use Zerg\Buffer\BufferInterface;
use Zerg\Buffer\ByteBuffer;

/**
 * Class FileStream
 *
 * @package Zerg
 */
class FileStream implements StreamInterface
{
	use StreamTrait {
		setPosition as protected _setPosition;
	}
	
	/**
	 * @var resource
	 */
	protected $handle;
	
	/**
	 * Return new file stream that will read data form given file.
	 *
	 * @param string|resource     $handle
	 * @param int                 $endian
	 * @param int|BufferInterface $buffer Buffer type.
	 *
	 * @throws \Zerg\Exception
	 * @throws \InvalidArgumentException
	 */
	public function __construct($handle, $endian = Endian::ENDIAN_BIG, $buffer = self::BUFFER_BYTE)
	{
		if (is_string($handle))
		{
			if ( ! is_file($handle))
			{
				throw new Exception('File path not found.');
			}
			
			$handle = fopen($handle, 'rb+');
		}
		
		if ( ! is_resource($handle))
		{
			throw new InvalidArgumentException('The handle must be a resource type.');
		}
		
		$this->handle = $handle;
		$this->setPosition(ftell($this->handle));
		$this->setEofPosition(fstat($this->handle)['size']);
		
		if ( ! $buffer instanceof BufferInterface)
		{
			$buffer = $this->createBuffer($buffer, $endian);
		}
		
		$this->setBuffer($buffer);
	}
	
	/**
	 * Sets the current position.
	 *
	 * @param  int $position
	 *
	 * @return FileStream
	 */
	public function setPosition($position)
	{
		$this->_setPosition($position);
		
		fseek($this->handle, $this->position);
		
		return $this;
	}
	
	/**
	 * Reads a number of raw bytes.
	 *
	 * @param int $bytesCount The number of bytes to read.
	 *
	 * @return string
	 * @throws \OutOfBoundsException
	 */
	public function read($bytesCount = 1)
	{
		if ($bytesCount < 1)
		{
			return '';
		}
		
		if ( ! $this->canReadBytes($bytesCount))
		{
			throw new OutOfBoundsException('Exceeds the boundary of the file.');
		}
		
		$this->_setPosition($this->getPosition() + (int) $bytesCount);
		
		return fread($this->handle, (int) $bytesCount);
	}
	
	/**
	 * Writes a number of bytes.
	 *
	 * @param string $bytes The bytes to write to the stream.
	 *
	 * @return FileStream
	 * @throws \Zerg\Exception
	 */
	public function write($bytes)
	{
		$bytesCount = strlen($bytes);
		
		if ($bytesCount < 1)
		{
			return $this;
		}
		
		$this->_setPosition($this->getPosition() + (int) $bytesCount);
		
		if (fwrite($this->handle, $bytes, $bytesCount) !== $bytesCount)
		{
			throw new Exception('An error in the recording process.');
		}
		
		if ($this->getPosition() > $this->getEofPosition())
		{
			$this->setEofPosition($this->getPosition());
		}
		
		return $this;
	}
	
	/**
	 * Closes an open file pointer.
	 *
	 * @return bool
	 */
	public function close()
	{
		return fclose($this->handle);
	}
	
}