<?php

namespace carlosV2\Map;

class Map implements \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * @var array
     */
    private $data;

    public function __construct()
    {
        $this->data = array();
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function has($offset)
    {
        return array_key_exists($this->getUniqueIdentifier($offset), $this->data);
    }

    /**
     * @param mixed $offset
     * @param mixed $default
     *
     * @return mixed
     */
    public function &get($offset, $default = null)
    {
        $offset = $this->getUniqueIdentifier($offset);
        if (array_key_exists($offset, $this->data)) {
            return $this->data[$offset]['value'];
        }

        return $default;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function set($offset, $value)
    {
        $this->data[$this->getUniqueIdentifier($offset)] = ['offset' => $offset, 'value' => $value];
    }

    /**
     * @param mixed $data
     *
     * @return string
     */
    private function getUniqueIdentifier($data)
    {
        return sha1(serialize($data));
    }

    /**
     * @inheritdoc
     */
    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    /**
     * @inheritdoc
     */
    public function &offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @inheritdoc
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$this->getUniqueIdentifier($offset)]);
    }

    /**
     * @inheritdoc
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * @inheritdoc
     */
    public function getIterator()
    {
        return new MapIterator($this->keys(), $this->values());
    }

    /**
     * @return mixed[]
     */
    public function keys()
    {
        return array_column($this->data, 'offset');
    }

    /**
     * @return mixed[]
     */
    public function values()
    {
        return array_column($this->data, 'value');
    }

    /**
     * @param callable $fn
     *
     * @return Map
     */
    public function map(callable $fn) {
        $map = new Map();
        foreach ($this->data as $data) {
            $map->set($data['offset'], $fn($data['value'], $data['offset']));
        }

        return $map;
    }
}
