<?php

namespace Zerg;

use Zerg\Buffer\BufferInterface;

class StringStream implements StreamInterface
{
	use StreamTrait;
	
	/**
	 * @protected string The inner string encapsulated by the Stream.
	 */
	protected $string = '';
	
	/**
	 * Return new file stream that will read data form given file.
	 *
	 * @param string              $string
	 * @param int                 $endian
	 * @param int|BufferInterface $buffer Buffer type.
	 *
	 * @throws \Zerg\Exception
	 * @throws \InvalidArgumentException
	 */
	public function __construct($string, $endian = Endian::ENDIAN_BIG, $buffer = self::BUFFER_BYTE)
	{
		$this->string = (string) $string;
		$this->setEofPosition(strlen($this->string));
		
		if ( ! $buffer instanceof BufferInterface)
		{
			$buffer = $this->createBuffer($buffer, $endian);
		}
		
		$this->setBuffer($buffer);
	}
	
	/**
	 * Reads a number of raw bytes.
	 *
	 * @param int $bytesCount The number of bytes to read.
	 *
	 * @return string
	 */
	public function read($bytesCount = 1)
	{
		$this->skip((int) $bytesCount);
		
		return substr($this->string, $this->getPosition() - $bytesCount, $bytesCount);
	}
	
	/**
	 * Writes a number of bytes.
	 *
	 * @param string $bytes The bytes to write to the stream.
	 *
	 * @return StreamInterface
	 */
	public function write($bytes)
	{
		$this->skip(strlen($bytes));
		$this->string .= $bytes;
		$this->setEofPosition($this->getPosition());
		
		return $this;
	}
	
}