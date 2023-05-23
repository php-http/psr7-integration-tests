<?php

namespace Http\Psr7Test\Tests\HttpSoft;

use Http\Psr7Test\UploadedFileIntegrationTest;
use HttpSoft\Message\Stream;
use HttpSoft\Message\UploadedFile;

class UploadedFileTest extends UploadedFileIntegrationTest
{
    public function createSubject()
    {
        $stream = new Stream('php://memory', 'rw');
        $stream->write('foobar');

        return new UploadedFile($stream, $stream->getSize(), UPLOAD_ERR_OK);
    }
}
