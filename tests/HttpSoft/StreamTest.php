<?php

namespace Http\Psr7Test\Tests\HttpSoft;

use Http\Psr7Test\StreamIntegrationTest;
use HttpSoft\Message\Stream;
use Psr\Http\Message\StreamInterface;

class StreamTest extends StreamIntegrationTest
{
    public function createStream($data)
    {
        if ($data instanceof StreamInterface) {
            return $data;
        }

        return new Stream($data);
    }
}
