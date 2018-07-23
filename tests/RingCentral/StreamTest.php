<?php

namespace Http\Psr7Test\Tests\RingCentral;

use Http\Psr7Test\StreamIntegrationTest;

class StreamTest extends StreamIntegrationTest
{
    public function createStream($data)
    {
        return \RingCentral\Psr7\stream_for($data);
    }
}
