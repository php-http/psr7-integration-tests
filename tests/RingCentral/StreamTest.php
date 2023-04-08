<?php

namespace Http\Psr7Test\Tests\RingCentral;

use Http\Psr7Test\StreamIntegrationTest;
use function RingCentral\Psr7\stream_for;

class StreamTest extends StreamIntegrationTest
{
    public function createStream($data)
    {
        return stream_for($data);
    }
}
