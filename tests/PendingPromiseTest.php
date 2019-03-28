<?php

declare(strict_types=1);

namespace Elephanto;

use GuzzleHttp\Promise\Promise;

class DumbClass
{
    public function withoutError()
    {
    }

    public function withError()
    {
        throw new \Exception('Just a dummy exception');
    }
}

class PendingPromiseTest extends \PHPUnit\Framework\TestCase
{
    public function testCanRunSynchronously()
    {
        $mockClass = $this->createMock(DumbClass::class, ['withoutError']);
        $result = new PendingPromise([$mockClass, 'withoutError']);

        $mockClass->expects($this->once())->method('withoutError');
        $result->wait();
    }

    public function testCanRunASynchronously()
    {
        $mockClass = $this->createMock(DumbClass::class, ['withoutError']);
        $result = new PendingPromise([$mockClass, 'withoutError']);

        $mockClass->expects($this->once())->method('withoutError');
        $promise = $result->then();

        $this->assertInstanceOf(Promise::class, $promise);
    }

    public function testThrowExceptionIsMethodDoesNotExists()
    {
        $this->expectException(\Exception::class);
        (new PendingPromise())->await();
    }
}
