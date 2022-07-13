<?php

namespace Http\Psr7Test\Tests\Guzzle;

use GuzzleHttp\Psr7\UploadedFile;
use Http\Psr7Test\UploadedFileIntegrationTest;

class UploadedFileTest extends UploadedFileIntegrationTest
{
    public function createSubject()
    {
        $stream = \GuzzleHttp\Psr7\Utils::streamFor('Foobar');

        return new UploadedFile($stream, $stream->getSize(), UPLOAD_ERR_OK, 'filename.txt', 'text/plain');
    }
}
