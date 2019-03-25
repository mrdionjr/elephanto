<?php

namespace Elephanto\Http;

use GuzzleHttp\Promise\Promise;
use Elephanto\Exception\HttpException;
use Elephanto\PromiseAdapter;

/**
 * @method then($onSuccess, $onError)
 */
class HttpClient
{
    /**
     * Request base url
     *
     * @var string
     */
    private $base_url;

    /**
     * Client options
     */
    private $options;

    /**
     * The curl Resource
     *
     * @var Resource
     */
    private $curl_resource;

    /**
     * HttpClient Constructor.
     *
     * @param string $url
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
        $this->base_url = $options['baseUrl'] ?? '';
    }

    /**
     * Make GET request
     *
     * @param  string $url
     * @param  array  $conf
     *
     * @return PromiseAdapter
     */
    public function get(string $url, array $conf = [])
    {
        if (isset($conf['params']) && !empty($conf['params'])) {
            $url = sprintf("%s?%s", $url, http_build_query($conf['params']));
        }

        $this->initializeCurl($url);
        $this->setHeaders($conf['headers'] ?? []);

        return new PromiseAdapter($this);
    }

    /**
     * Make POST request
     *
     * @param  string $url
     * @param  array  $data
     * @return HttpClient
     */
    public function post(string $url, $data = null, array $conf = [])
    {
        $this->initializeCurl($url);
        $this->setHeaders($conf['headers'] ?? []);

        if (curl_setopt($this->curl_resource, CURLOPT_POST, true)) {
            if ($data) {
                $this->setBody($data);
            }
        }

        return new PromiseAdapter($this);
    }

    /**
     * Execute the request
     *
     * @return mixed
     * @throws \Exception
     */
    public function run()
    {
        $data = curl_exec($this->curl_resource);

        if ($data === false) {
            return new HttpException(curl_error($this->curl_resource));
        }

        $response = new Response($data, new Headers(curl_getinfo($this->curl_resource)));

        $this->close();

        return $response;
    }

    /**
     * Set the request body.
     *
     * @param string|array $data
     *
     * @return void
     */
    private function setBody($body)
    {
        curl_setopt($this->curl_resource, CURLOPT_POSTFIELDS, json_encode($body));
    }

    /**
     * Set the request headers.
     *
     * @param array $headers
     */
    private function setHeaders(array $headers)
    {
        $defaultHeaders = $this->options['headers'] ?? [];
        curl_setopt($this->curl_resource, CURLOPT_HTTPHEADER, array_merge($defaultHeaders, $headers));
    }

    /**
     * Ensures that the curl resource has been initialized
     *
     * @param string $url
     *
     * @return void
     */
    private function initializeCurl($url)
    {
        if (!is_resource($this->curl_resource)) {
            $this->curl_resource = curl_init($this->base_url.$url);
            $this->setReturnTransfertToRaw();
        }
    }

    /**
     * Close connection
     *
     * @return void
     */
    private function close()
    {
        curl_close($this->curl_resource);
        $this->curl_resource = null;
    }

    /**
     * Set CURLOPT_RETURNTRANSFER option to return the response as a string
     * instead of outputting it to the screen
     *
     * @return bool
     */
    private function setReturnTransfert()
    {
        if (!curl_setopt($this->curl_resource, CURLOPT_RETURNTRANSFER, true)) {
            $this->close();
            return false;
        }

        return true;
    }

    /**
     * Set Curl CURLOPT_BINARYTRANSFER option
     *
     * @return bool
     */
    private function setReturnTransfertToRaw()
    {
        if ($this->setReturnTransfert()) {
            if (!curl_setopt($this->curl_resource, CURLOPT_BINARYTRANSFER, true)) {
                $this->close();
                return false;
            }
        }

        return true;
    }
}
