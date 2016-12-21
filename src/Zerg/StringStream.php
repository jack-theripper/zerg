<?php

namespace Zerg;

use Zerg\Buffer\BitBuffer;

/**
 * FileStream wraps string and allow fields to read data from it.
 *
 * @since 0.1
 * @package Zerg
 */
class StringStream implements StreamInterface
{
    use StreamTrait;
	
	/**
	 * @var resource
	 */
	protected $handle;
	
	/**
	 * Return new string stream that will read data form given string.
	 *
	 * @param string $string
	 * @param int    $buffer
	 */
    public function __construct($string, $buffer = self::BUFFER_BYTE)
    {
	    $this->handle = fopen('php://memory', 'br+');
	    
	    fwrite($this->handle, $string);
	    rewind($this->handle);
	
	    $this->buffer = $this->createBuffer($this->handle, $buffer);
    }
	
	/**
	 * The destructor method.
	 *
	 * @return void
	 */
	public function __destruct()
	{
		fclose($this->handle);
	}
	
}