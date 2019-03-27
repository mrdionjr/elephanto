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
     * Contains the headers from the CURL response informations.
     *
     * @var array
     */
    private $infos;

    public function __construct(array $infos = [])
    {
        $this->infos = [
            'content-type' => $infos['content_type'],
            'url' => $infos['url'],
            'host' => $infos['primary_ip'],
            'status' => $infos['http_code'],
        ];
    }

    /**
     * Retrieve a header value.
     */
    public function get($name)
    {
        return $this->infos[strtolower($name)];
    }

    /**
     * Set a header value.
     */
    public function set($name, $value)
    {
        $this->infos[strtolower($name)] = $value;

        return $this;
    }

    public function offsetExists($offset)
    {
        return isset($this->infos[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        return $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        unset($this->infos[$offset]);
    }
}
