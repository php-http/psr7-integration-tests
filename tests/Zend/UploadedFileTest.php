<?php

namespace Http\Psr7Test\Tests\Zend;

use Http\Psr7Test\UploadedFileIntegrationTest;
use Zend\Diactoros\Stream;
use Zend\Diactoros\UploadedFile;

class UploadedFileTest extends UploadedFileIntegrationTest
{
    public function createSubject()
    {
        $stream = new Stream('php://memory', 'rw');
        $stream->write('foobar');

        return new UploadedFile($stream, $stream->getSize(), UPLOAD_ERR_OK);
    }
}
