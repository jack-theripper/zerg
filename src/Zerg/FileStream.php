<?php

namespace Zerg;

use RuntimeException;
use Zerg\Buffer\BitBuffer;

/**
 * FileStream wraps file and allow fields to read data from it.
 *
 * @since 0.1
 * @package Zerg\Stream
 */
class FileStream implements StreamInterface
{
    use StreamTrait;
	
	/**
	 * Return new file stream that will read data form given file.
	 *
	 * @param string $path Path of file.
	 *
	 * @throws \RuntimeException
	 * @throws \InvalidArgumentException
	 */
    public function __construct($path)
    {
        if ( ! is_file($path))
        {
            throw new RuntimeException('File path not found.');
        }
	    
    	$handle = fopen($path, 'rb');
        $this->buffer = new BitBuffer($handle);
    }
	
}