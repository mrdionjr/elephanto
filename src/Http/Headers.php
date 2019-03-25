<?php

namespace Elephanto\Http;

/**
 * Defines a request or and response Header.
 *
 * @author Salomon Dion (dev.mrdion@gmail.com)
 */
class Headers implements \ArrayAccess
{
    /**
     * Contains CURL response informations.
     *
     * @var array
     */
    private $infos;

    public function __construct(array $infos = [])
    {
        $this->infos = $infos;
    }

    public function offsetExists($offset)
    {
        return isset($this->infos[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->infos[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->infos[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->infos[$offset]);
    }
}
