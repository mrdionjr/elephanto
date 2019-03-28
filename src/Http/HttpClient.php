<?php

namespace Elephanto\Http;

use Elephanto\PendingPromise;

class HttpClient
{
    /**
     * Request base url.
     *
     * @var string
     */
    private $base_url;

    /**
     * Client requestOptions.
     *
     * @var array
     */
    private $requestOptions = [];

    /**
     * HttpClient Constructor.
     *
     * @param string $url
     * @param array  $requestOptions
     */
    public function __construct(array $requestOptions = [])
    {
        $this->requestOptions = $requestOptions;
        $this->base_url = $requestOptions['baseURL'] ?? '';
    }

    /**
     * Make GET request.
     *
     * @param string $url
     * @param array  $conf
     *
     * @return PendingPromise
     */
    public function get(string $url, array $conf = [])
    {
        if (isset($conf['params']) && !empty($conf['params'])) {
            $url = sprintf('%s?%s', $url, http_build_query($conf['params']));
        }

        $this->setHeaders($conf['headers'] ?? []);
        $this->setMethod('GET');
        $this->setURL($url);

        return new PendingPromise([$this, 'run']);
    }

    /**
     * Make POST request.
     *
     * @param string $url
     * @param array  $data
     *
     * @return PendingPromise
     */
    public function post(string $url, $data = null, array $conf = []): PendingPromise
    {
        $this->setHeaders($conf['headers'] ?? []);
        $this->setMethod('POST');
        $this->setURL($url);

        if ($data) {
            $this->setBody($data);
        }

        return new PendingPromise([$this, 'run']);
    }

    /**
     * Execute the request.
     *
     * @return mixed
     */
    public function run()
    {
        $request = (new Request($this->requestOptions))->run();

        return $request->response();
    }

    /**
     * Set the request body.
     *
     * @param string|array $data
     *
     * @return $this
     */
    private function setBody($body): HttpClient
    {
        $this->requestOptions['body'] = $body;

        return $this;
    }

    /**
     * Set the request headers.
     *
     * @param array $headers
     *
     * @return $this;
     */
    private function setHeaders(array $headers): HttpClient
    {
        $defaultHeaders = $this->requestOptions['headers'] ?? [];
        $this->requestOptions['headers'] = array_merge($defaultHeaders, $headers);

        return $this;
    }

    /**
     * Set the request method.
     *
     * @param string $method
     *
     * @return $this
     */
    private function setMethod(string $method): HttpClient
    {
        $this->requestOptions['method'] = $method;

        return $this;
    }

    /**
     * Set the request URL.
     *
     * @param string
     *
     * @return $this
     */
    private function setURL(string $url): HttpClient
    {
        $this->requestOptions['url'] = $this->base_url.$url;

        return $this;
    }
}
