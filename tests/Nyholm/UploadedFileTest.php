<?php

namespace Http\Psr7Test\Tests\Nyholm;

use Http\Psr7Test\UploadedFileIntegrationTest;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7\Stream;

class UploadedFileTest extends UploadedFileIntegrationTest
{
    public function createSubject()
    {
        return (new Psr17Factory())->createUploadedFile(Stream::create('writing to tempfile'));
    }
}
