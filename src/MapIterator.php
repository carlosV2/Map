<?php

namespace carlosV2\Map;

class MapIterator implements \Iterator
{
    /**
     * @var integer
     */
    private $index;

    /**
     * @var mixed
     */
    private $offsets;

    /**
     * @var mixed
     */
    private $values;

    /**
     * @param mixed $offsets
     * @param mixed $values
     */
    public function __construct(array $offsets, array $values)
    {
        $this->offsets = $offsets;
        $this->values = $values;
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        return $this->values[$this->index];
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
        return $this->offsets[$this->index];
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return $this->index < count($this->offsets);
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->index = 0;
    }
}
