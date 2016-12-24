<?php

namespace Zerg\Field;

use Zerg\StreamInterface;

/**
 * String represents string type data.
 *
 * Data, parsed by this type of field returns as it is in binary file.
 *
 * @since 0.1
 * @package Zerg\Field
 */
class StringType extends Scalar
{
    
	/**
     * Read string from stream as it is.
     *
     * @param StreamInterface $stream Stream from which read.
     * @return string Returned string.
     */
    public function read(StreamInterface $stream)
    {
        return $stream->readString($this->getSize(), $this->getEndian());
    }
	
}