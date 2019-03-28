<?php

namespace Elephanto\Contracts;

use Elephanto\Http\Headers;

/**
 * @author Salomon Dion (dev.mrdion@gmail.com)
 */
interface Request
{
    /**
     * Returns the request headers.
     */
    public function headers(): Headers;
}
