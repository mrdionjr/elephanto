<?php

namespace Elephanto\Http;

use Elephanto\Contracts\Request as RequestInterface;

/**
* Defines a HTTP Request.
*
* @author Salomon Dion (dev.mrdion@gmail.com)
*/
class Request implements RequestInterface
{
    use Body;
}
