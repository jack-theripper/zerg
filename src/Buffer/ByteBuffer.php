<?php

namespace Zerg\Buffer;

use LengthException;
use Zerg\Endian;
use Zerg\StreamInterface;

/**
 * Class ByteBuffer
 *
 * @package Zerg\Buffer
 */
class ByteBuffer implements BufferInterface
{
	
	/**
	 * @var int Endian for current buffer instance.
	 */
	protected $endian;
	
	/**
	 * @var StreamInterface
	 */
	protected $stream;
	
	/**
	 * ByteBuffer constructor.
	 *
	 * @param int $endian
	 */
	public function __construct($endian = null)
	{
		$this->endian = $endian ?: Endian::getMachineEndian();
	}
	
	/**
	 * Gets the endian.
	 *
	 * @return int
	 */
	public function getEndian()
	{
		return $this->endian;
	}
	
	/**
	 * Sets the current endian.
	 *
	 * @param int $endian
	 *
	 * @return ByteBuffer
	 */
	public function setEndian($endian)
	{
		$this->endian = $endian;
		
		return $this;
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
		return $this->stream->read($bytesCount);
	}
	
	/**
	 * Read the number of bytes as a integer.
	 *
	 * @param int  $bytesCount
	 * @param bool $signed
	 * @param int  $endian
	 *
	 * @return int
	 * @throws \LengthException
	 */
	public function readInt($bytesCount = 1, $signed = false, $endian = null)
	{
		if ($bytesCount > 8)
		{
			throw new LengthException("Can't read integer larger 64 bit.");
		}
		
		if ($bytesCount > 4 && ! $this->can64())
		{
			throw new LengthException('Your system not support 64 bit integers.');
		}
		
		if ($endian === null)
		{
			$endian = $this->getEndian();
		}
		
		$fullBytes = $this->getFullSize($bytesCount);
		$data = $this->fitTo($this->stream->read($bytesCount), $fullBytes, $endian);
		
		return Packer::unpack(Packer::getFormat('int', $fullBytes * 8, $signed, $endian), $data);
	}
	
	/**
	 * Writes a number of bytes to the stream and advances the internal
	 * position by the appropriate amount.
	 *
	 * @param string $bytes The bytes to write to the stream.
	 *
	 * @return BufferInterface
	 */
	public function writeString($bytes)
	{
		$this->stream->write($bytes);
		
		return $this;
	}
	
	/**
	 * Write the bytes as a integer.
	 *
	 * @param int $value
	 * @param int $bytesCount
	 * @param int $endian
	 *
	 * @return BufferInterface
	 * @throws \LengthException
	 */
	public function writeInt($value, $bytesCount = 1, $endian = null)
	{
		if ($bytesCount > 8)
		{
			throw new LengthException('Can\'t write integer larger 64 bit.');
		}
		
		if ($bytesCount > 4 && ! $this->can64())
		{
			throw new LengthException('Your system not support 64 bit integers.');
		}
		
		if ($endian === null)
		{
			$endian = $this->getEndian();
		}
		
		$value = Packer::pack(Packer::getFormat('int', $bytesCount * 8, false, $endian), $value);
		$this->stream->write($value);
		
		return $this;
	}
	
	/**
	 * Sets the stream instance.
	 *
	 * @param \Zerg\StreamInterface $stream
	 *
	 * @return BufferInterface
	 */
	public function setStream(StreamInterface $stream)
	{
		$this->stream = $stream;
		
		return $this;
	}
	
	/**
	 * @return bool
	 */
	protected function can64()
	{
		return PHP_INT_SIZE == 8;
	}
	
	/**
	 * @param string $bytes
	 *
	 * @return int
	 */
	protected function getFullSize($bytes)
	{
		if ($bytes > 4)
		{
			return 8;
		}
		elseif ($bytes > 2)
		{
			return 4;
		}
		
		return $bytes;
	}
	
	/**
	 * @param string $data
	 * @param int    $fullSize
	 * @param string $endian
	 *
	 * @return string
	 */
	protected function fitTo($data, $fullSize, $endian)
	{
		if ($fullSize > strlen($data))
		{
			$data = str_pad($data, $fullSize, "\x00", $endian == Endian::ENDIAN_BIG ? STR_PAD_LEFT : STR_PAD_RIGHT);
		}
		else
		{
			$data = substr($data, ($endian == Endian::ENDIAN_LITTLE ? 0 : -$fullSize), $fullSize);
		}
		
		return $data;
	}
	
}