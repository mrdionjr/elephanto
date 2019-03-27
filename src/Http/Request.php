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

    /**
     * Request options.
     *
     * @var array
     */
    private $requestOptions;

    /**
     * Request response.
     *
     * @var Response
     */
    private $response;

    /**
     * Curl resource.
     *
     * @var resource
     */
    private $ch;

    public function __construct(array $requestOptions)
    {
        $this->requestOptions = $requestOptions;
    }

    /**
     * Execute the request.
     *
     * @return $this
     */
    public function run(): Request
    {
        $this->initializeCurl();
        $this->setCurlOptions();

        $data = curl_exec($this->ch);

        if (false === $data) {
            throw new HttpException(curl_error($this->ch));
        }

        $this->response = (new Response($data, new Headers(curl_getinfo($this->ch))))->setRequest($this);

        $this->close();

        return $this;
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    protected function getData()
    {
        return $this->requestOptions['body'] ?? null;
    }

    private function setCurlOptions()
    {
        curl_setopt_array($this->ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_BINARYTRANSFER => true,
            CURLOPT_HTTPHEADER => $this->requestOptions['headers'],
        ]);

        if ('POST' === $this->requestOptions['method']) {
            curl_setopt($this->ch, CURLOPT_POST, true);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($this->requestOptions['body']));
        }
    }

    /**
     * Ensures that the curl resource has been initialized.
     *
     * @param string $url
     */
    private function initializeCurl()
    {
        if (!is_resource($this->ch)) {
            $this->ch = curl_init($this->requestOptions['url']);
        }
    }

    /**
     * Close connection.
     */
    private function close()
    {
        if (is_resource($this->ch)) {
            curl_close($this->ch);
            $this->ch = null;
        }
    }
}
