<?php

namespace Elephanto\Http;

/**
 * Defines a request or and response Header.
 *
 * @author Salomon Dion (dev.mrdion@gmail.com)
 */
class Headers
{
    /**
     * Contains the response/request headers.
     *
     * @var array
     */
    private $infos;

    public function __construct(array $infos = [])
    {
        // FIXME: Normalize headers for request and responses
        $this->infos = $infos;
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

    public function toArray(): array
    {
        return $this->infos;
    }
}
