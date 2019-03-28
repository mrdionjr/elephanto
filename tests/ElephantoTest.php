<?php

declare(strict_types=1);

namespace Elephanto;

use Elephanto\Http\Response;
use GuzzleHttp\Promise\Promise;
use Elephanto\Exception\HttpException;

class ElephantoTest extends \PHPUnit\Framework\TestCase
{
    public function testRequestNotExecutedUntilThen()
    {
        /** @var PendingPromise $result */
        $result = Elephanto::get('https://jsonplaceholder.typicode.com/posts');

        $this->assertInstanceOf(PendingPromise::class, $result);
        $this->assertInstanceOf(Promise::class, $result->then());
    }


    public function testThrowExceptionWhenUnableToMakeRequest()
    {
        /** @var Promise $result */
        $result = Elephanto::get('http://localhost:5000');
        $this->expectException(HttpException::class);
        $result->wait();
    }

    public function testGetRequestParamsAreSet()
    {
        /** @var Promise $result */
        $result = Elephanto::get('https://jsonplaceholder.typicode.com/posts', ['params' => [
            'action' => 'great',
            'name' => 'salomon',
        ]]);
        $response = $result->wait();

        $this->assertStringContainsString('action=great&name=salomon', $response->request()->url());
    }

    public function testPostRequestBodyIsSet()
    {
        $body = ['title' => 'Yeah nigga', 'author' => 'DiJay'];
        /** @var Promise $result */
        $result = Elephanto::post('https://jsonplaceholder.typicode.com/posts', $body);
        $response = $result->wait();

        $this->assertEquals($body, $response->request()->array());
    }

    public function testResponseBodyIsSuccessfullyParsed()
    {
        /** @var Promise $result */
        $result = Elephanto::get('https://jsonplaceholder.typicode.com/posts');
        $response = $result->wait();

        $this->assertIsArray($response->array());
        $this->assertJson($response->json());
        $this->assertIsString($response->raw());
    }

    public function testRequestHeadersCorrectlySet()
    {
        $result = Elephanto::get('https://jsonplaceholder.typicode.com/posts', [
           'headers' => ['Content-Type: application/json'],
        ]);
        $response = $result->wait();
        $request = $response->request();

        $this->assertEquals('Content-Type: application/json', $request->headers()->get(0));
    }

    public function testResponseHeadersCorrectlySet()
    {
        $result = Elephanto::get('https://jsonplaceholder.typicode.com/posts');
        $response = $result->wait();

        $this->assertNotEmpty($response->headers()->toArray());
    }

    public function testResponseHasStatus()
    {
        $result = Elephanto::get('https://jsonplaceholder.typicode.com/posts');
        $response = $result->wait();

        $this->assertIsInt($response->status());
    }

    public function testResponseHasCorrectStatusText()
    {
        $result = Elephanto::post('https://jsonplaceholder.typicode.com/posts', [
            'title' => 'Testify',
            'author' => 'Elephanto',
        ]);
        $response = $result->wait();

        $this->assertEquals('CREATED', $response->statusText());
    }
}
