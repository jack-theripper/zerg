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
	 * Return new string stream that will read data form given string.
	 *
	 * @param string $string
	 * @param int    $buffer
	 */
    public function __construct($string, $buffer = self::BUFFER_BYTE)
    {
	    $handle = fopen('php://memory', 'br+');
	    fwrite($handle, $string);
	    rewind($handle);
	
	    $this->buffer = $this->createBuffer($handle, $buffer);
    }

}