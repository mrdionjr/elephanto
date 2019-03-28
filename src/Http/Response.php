<?php

namespace Elephanto\Http;

use Elephanto\Contracts\Response as ResponseInterface;
use Elephanto\Helpers\Http;

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
     * Response's request.
     *
     * @var Request
     */
    private $request;

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
    protected function data()
    {
        return $this->data;
    }

    /**
     * Returns the request that generated this response.
     *
     * @return Request
     */
    public function request(): Request
    {
        return $this->request;
    }

    /**
     * Returns the Headers object associated with the response.
     *
     * @return Headers
     *
     * @throws
     */
    public function headers(): Headers
    {
        return $this->headers;
    }

    /**
     * Returns the status code of the response (e.g., 200 for a success).
     *
     * @return int
     */
    public function status()
    {
        return $this->headers->get('status');
    }

    /**
     * Returns the status message corresponding to the status code (e.g., OK for 200).
     *
     * @var string
     */
    public function statusText(): string
    {
        return Http::STATUS_TEXT[$this->status()];
    }

    /**
     * Set the response request.
     *
     * @var Request
     *
     * @return $this
     */
    public function setRequest(Request &$request): Response
    {
        $this->request = $request;

        return $this;
    }
}
