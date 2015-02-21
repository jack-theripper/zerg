<?php

namespace Zerg\Field;

use Zerg\Stream\AbstractStream;

abstract class Scalar extends AbstractField implements Countable, Sizeable
{
    use CountableTrait;
    use SizeableTrait;

    protected $valueCallback;

    /**
     * @return mixed
     */
    public function getValueCallback()
    {
        return $this->valueCallback;
    }

    /**
     * @param mixed $valueCallback
     */
    public function setValueCallback($valueCallback)
    {
        $this->valueCallback = $valueCallback;
    }

    abstract public function read(AbstractStream $stream);

    public function __construct($size, $properties = [])
    {
        $this->setSize($size);
        $this->configure($properties);
    }

    public function parse(AbstractStream $stream)
    {
        return $this->format($this->read($stream));
    }

    public function format($value)
    {
        if (is_callable($this->valueCallback)) {
            $value = call_user_func($this->valueCallback, $value);
        }
        return $value;
    }
}