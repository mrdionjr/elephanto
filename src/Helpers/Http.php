<?php

namespace Elephanto\Helpers;

/**
 * @author Salomon Dion (dev.mrdion@gmail.com)
 */
class Http
{
    public const STATUS_TEXT = [
        200 => 'OK',
        201 => 'CREATED',
        404 => 'NOT FOUND',
        401 => 'FORBIDDEN',
        500 => 'INTERNAL SERVER ERROR',
    ];
}
