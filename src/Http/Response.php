<?php

namespace Elephanto\Http;

use Elephanto\Contracts\Response as ResponseInterface;

/**
 * Defines a HTTP Response.
 *
 * @author Salomon Dion (dev.mrdion@gmail.com)
 */
class Response implements ResponseInterface
{
    use Body;

    /**
     * Contains the response headers.
     *
     * @var Headers
     */
    private $headers;

    /**
     * Contains the response data.
     *
     * @var mixed|null
     */
    private $data;

    /**
     * Parser constructor.
     *
     * @param resource $curl_resource
     */
    public function __construct($data, Headers $headers)
    {
        $this->headers = $headers;
        $this->data = $data;
    }

    /**
     * Returns the response provided by the server.
     */
    protected function getData()
    {
        return $this->data;
    }

    /**
     * Returns the request that generated this response.
     *
     * @return Request
     */
    public function getRequest(): Request
    {
        return new Request;
    }

    /**
     * Returns the Headers object associated with the response.
     *
     * @return Headers
     * @throws
     */
    public function getHeaders(): Headers
    {
        return $this->headers;
    }

    /**
     * Returns the status code of the response (e.g., 200 for a success).
     *
     * @return int
     * @throws
     */
    public function getStatus()
    {
        return $this->headers['status_code'];
    }

    /**
     * Returns the status message corresponding to the status code (e.g., OK for 200).
     */
    public function getStatusText()
    {
        return 'OK';
    }
}
