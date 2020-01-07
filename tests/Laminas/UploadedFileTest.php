<?php

namespace Http\Psr7Test\Tests\Laminas;

use Http\Psr7Test\UploadedFileIntegrationTest;
use Laminas\Diactoros\Stream;
use Laminas\Diactoros\UploadedFile;

class UploadedFileTest extends UploadedFileIntegrationTest
{
    public function createSubject()
    {
        $stream = new Stream('php://memory', 'rw');
        $stream->write('foobar');

        return new UploadedFile($stream, $stream->getSize(), UPLOAD_ERR_OK);
    }
}
