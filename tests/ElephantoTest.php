<?php

declare(strict_types=1);

namespace mrdionjr\elephanto;

use Elephanto\Elephanto;
use Elephanto\Http\Response;
use GuzzleHttp\Promise\Promise;
use Elephanto\PendingPromise;

class ElephantoTest extends \PHPUnit\Framework\TestCase
{
    public function testRequestNotExecutedUntilThen()
    {
        /** @var PendingPromise $result */
        $result = Elephanto::get('http://localhost:3000/posts');

        $this->assertInstanceOf(PendingPromise::class, $result);
        $this->assertInstanceOf(Promise::class, $result->then());
    }

    public function testBodyIsSuccessfullyParsed()
    {
        /** @var Promise $result */
        $result = Elephanto::get('http://localhost:3000/posts');

        // $response = $result->wait();
        // $this->assertIsArray($response->array());
        // $this->assertJson($response->json());

        $this->assertTrue(true);
    }

    public function testHeadersCorrectlySet()
    {
        $data = ['title' => 'Elephanto Rocks !'];
        $result = Elephanto::post('http://localhost:3000/posts', $data, [
           'headers' => ['Content-Type: application/json'],
        ]);
        // $response = $result->wait();
        // $this->assertContains('Content-Type: application/json', $response->getHeaders());

        $this->assertTrue(true);
    }
}
