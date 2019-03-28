<?php

namespace Elephanto;

use GuzzleHttp\Promise\Promise;

/**
 * @author Salomon Dion (dev.mrdion@gmail.com)
 */
class PendingPromise
{
    /**
     * @var callable
     */
    protected $waitFn;

    /**
     * @var Promise
     */
    protected $promise;

    public function __construct($waitFn = null, $cancelFn = null)
    {
        $this->waitFn = $waitFn;
        // Defining the element first is required to pass it as reference
        $promise = new Promise(function () use (&$promise) {
            $promise->resolve(\call_user_func($this->waitFn));
        });
        $this->promise = $promise;
    }

    /**
     * Proxy promise call to execute the request.
     *
     * @param callable|null $onSuccess
     * @param callable|null $onError
     *
     * @return Promise
     */
    public function then(?callable $onSuccess = null, ?callable $onError = null): Promise
    {
        $promise = $this->promise->then($onSuccess, $onError);

        try {
            $this->promise->resolve(\call_user_func($this->waitFn));
        } catch (\Throwable $th) {
            $this->promise->reject($th);
        }

        return $promise;
    }

    public function __call($name, $arguments)
    {
        if ('wait' === $name) {
            return $this->promise->wait();
        }

        throw new \Exception(sprintf('Method %s does not exists on %s', $name, __CLASS__), 1);
    }
}
