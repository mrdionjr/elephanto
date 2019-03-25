<?php
namespace Elephanto;

use GuzzleHttp\Promise\Promise;

/**
* Wrap the promise library to provide a consistent interface.
* @author Salomon Dion (dev.mrdion@gmail.com)
*/
class PromiseAdapter
{
    /**
     * @var Promise
     */
    protected $promise;

    protected $element;

    public function __construct($element)
    {
        $this->promise = new Promise();
        $this->element = $element;
    }

    public function resolve($data)
    {
        $this->promise->resolve($data);
    }

    public function reject($reason)
    {
        $this->promise->reject($reason);
    }

    /**
     * @param callable $onSuccess
     * @param callable|null $onError
     * @return Promise
     */
    public function then(callable $onSuccess, callable $onError = null)
    {
        $promise = $this->promise->then($onSuccess, $onError);
        $this->resolve($this->element->run());
        return $promise;
    }
}
