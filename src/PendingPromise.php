<?php

namespace Elephanto;

use GuzzleHttp\Promise\Promise;

/**
 * @author Salomon Dion (dev.mrdion@gmail.com)
 */
class PendingPromise
{
    protected $element;

    protected $promise;

    public function __construct(callable $element)
    {
        $this->element = $element;
        $this->promise = new Promise(function ($promise) {
            try {
                $promise->resolve(\call_user_func($this->element));
            } catch (\Throwable $th) {
                $promise->reject($th);
            }
        });
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
            $this->promise->resolve(\call_user_func($this->element));
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
    }
}
