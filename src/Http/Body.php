<?php

namespace Elephanto\Http;

/**
 * @author Salomon Dion (dev.mrdion@gmail.com)
 */
trait Body
{
    abstract public function getData();

    /**
     * Returns a text representation of the response body.
     *
     * @return string
     */
    public function text(): string
    {
        return $this->getData();
    }

    /**
     * Returns a JSON representation of the response body.
     *
     * @return string
     */
    public function json(): string
    {
        return json_encode($this->getData());
    }

    /**
     * Returns an array representation of the response body.
     *
     * @return array
     */
    public function toArray(): array
    {
        return json_decode($this->getData(), true);
    }
}
