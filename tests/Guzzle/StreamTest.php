<?php

namespace Http\Psr7Test\Tests\Guzzle;

use Http\Psr7Test\StreamIntegrationTest;

class StreamTest extends StreamIntegrationTest
{
    public function createStream($data)
    {
        return \GuzzleHttp\Psr7\stream_for($data);
    }
}
