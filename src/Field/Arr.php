<?php

namespace Zerg\Field;

use Zerg\StreamInterface;

/**
 * Class Arr repeat given field needed times.
 *
 * This field return array of values, that are read from Stream by given field,
 * specified count of times, or until some condition are performed.
 *
 * @since 1.0
 * @package Zerg\Field
 */
class Arr extends Collection
{
    /**
     * @var int Count of elements.
     */
    protected $count;

    /**
     * @var string|callable
     */
    protected $until;

    /**
     * @var array|AbstractField Field to be repeated.
     */
    protected $field;

    /**
     * @var int
     */
    protected $index;

    public function __construct($count, $field = [], $options = [])
    {
        $this->index = 0;
        if (is_array($count)) {
            $this->configure($count);
        } else {
            $this->setCount($count);
            $this->setField($field);
            $this->configure($options);
        }
    }

    /**
     * Call parse method on arrayed field needed times.
     *
     * @api
     * @param StreamInterface $stream Stream from which children read.
     * @return array Array of parsed values.
     * @since 1.0
     */
    public function parse(StreamInterface $stream)
    {
        try {
            return parent::parse($stream);
        } catch (\OutOfBoundsException $e) {
            if ($this->isUntilEof()) {
                return $this->dataSet->getData();
            }

            throw $e;
        }
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return (int) $this->resolveProperty('count');
    }

    /**
     * @param int $count
     * @return $this
     */
    public function setCount($count)
    {
        $this->count = $count;
        return $this;
    }

    /**
     * @return callable|string
     */
    public function getUntil()
    {
        return $this->until;
    }

    /**
     * @param callable|string $until
     * @return $this
     */
    public function setUntil($until)
    {
        $this->until = $until;
        return $this;
    }

    /**
     * @return AbstractField
     */
    public function getField()
    {
        $field = $this->resolveProperty('field');
        if (is_array($field)) {
            $field = Factory::get($field);
        }
        return $field;
    }

    /**
     * @param array|AbstractField $field
     * @return $this
     */
    public function setField($field)
    {
        if (is_array($field)) {
            $field = Factory::get($field);
        }
        $this->field = $field;
        return $this;
    }

    /**
     * @inheritdoc
     * @return AbstractField
     */
    public function current()
    {
        return $this->getField();
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        $this->index++;
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        if (is_callable($this->getUntil())) {
            $value = $this->getDataSet()->getValueByCurrentPath();
            return call_user_func($this->getUntil(), end($value));
        }
        return $this->index < $this->getCount() || $this->isUntilEof();
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->index = 0;
    }

    /**
     * Whether array must read until end of file.
     *
     * @return bool
     */
    private function isUntilEof()
    {
        $until = $this->getUntil();
        return is_string($until) && strtolower($until) === 'eof';
    }
}