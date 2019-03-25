<?php

namespace Elephanto\Contracts;

use Elephanto\Http\Headers;

/**
* @author Salomon Dion (dev.mrdion@gmail.com)
*/
interface Response
{
    /**
     * Returns the response headers.
     */
    public function getHeaders(): Headers;
}
