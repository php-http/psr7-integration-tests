<?php

namespace Http\Psr7Test\Tests\Slim;

use Http\Psr7Test\StreamIntegrationTest;
use Psr\Http\Message\StreamInterface;
use Slim\Http\Stream;

class StreamTest extends StreamIntegrationTest
{
    public function createStream($body)
    {
        if ($body instanceof StreamInterface) {
            return $body;
        }
        if (is_resource($body)) {
            return new Stream($body);
        }
        $resource = fopen('php://memory', 'r+');
        $stream = new Stream($resource);
        if (null !== $body && '' !== $body) {
            $stream->write((string) $body);
        }

        return $stream;
    }
}
