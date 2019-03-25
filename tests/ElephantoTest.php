<?php

declare(strict_types = 1);

namespace mrdionjr\elephanto;

use Elephanto\Elephanto;
use GuzzleHttp\Promise\Promise;
use Elephanto\PromiseAdapter;
use Elephanto\Http\Response;

class ElephantoTest extends \PHPUnit\Framework\TestCase
{
    public function testGet()
    {
        /** @var Promise $result */
        $result = Elephanto::get('http://localhost:3000/posts')
            ->then(function (Response $response) {
                $this->assertIsArray($response->toArray());
                $this->assertJson($response->json());
            });

        $this->assertInstanceOf(Promise::class, $result);
    }
}
