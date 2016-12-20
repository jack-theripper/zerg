<?php

namespace Zerg\Field;

use Zerg\StreamInterface;

/**
 * Int field read data from Stream and cast it to integer.
 *
 * @since 0.1
 * @package Zerg\Field
 */
class IntType extends Scalar
{
    
	/**
     * @var bool Whether field is signed. If so, value form stream will be casted to signed integer.
     */
    protected $signed;

    /**
     * Getter for signed property.
     *
     * @return bool
     */
    public function getSigned()
    {
        return (bool) $this->signed;
    }

    /**
     * Setter for signed property.
     *
     * @param bool $signed
     */
    public function setSigned($signed)
    {
        $this->signed = $signed;
    }

    /**
     * Read data from Stream and cast it to integer.
     *
     * @param StreamInterface $stream Stream from which read.
     * @return int Result value.
     */
    public function read(StreamInterface $stream)
    {
        return $stream->getBuffer()->readInt($this->getSize(), $this->getSigned(), $this->getEndian());
    }
	
}