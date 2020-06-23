<?php

namespace Http\Psr7Test\Tests\Shieldon;

use Http\Psr7Test\UploadedFileIntegrationTest;
use Shieldon\Psr7\UploadedFile;
use Shieldon\Psr7\Stream;

class UploadedFileTest extends UploadedFileIntegrationTest
{
    public function createSubject()
    {
        $stream = new Stream(fopen('php://memory', 'r+'));
        $stream->write('foobar');

        return new UploadedFile($stream);
    }
}
