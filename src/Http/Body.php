<?php

namespace Elephanto\Http;

/**
 * @author Salomon Dion (dev.mrdion@gmail.com)
 */
trait Body
{
    /**
     * Returns the content of the response/request body.
     *
     * @return mixed
     */
    abstract protected function getData();

    /**
     * Returns the body as it is.
     *
     * @return string
     */
    public function raw(): string
    {
        return $this->getData();
    }

    /**
     * Returns a JSON representation of the body.
     *
     * @return string
     */
    public function json(): string
    {
        return json_encode($this->getData());
    }

    /**
     * Returns an array representation of the body.
     *
     * @return array
     */
    public function array(): array
    {
        return json_decode($this->getData(), true);
    }
}
