<?php

namespace Http\Psr7Test\Tests\RingCentral;

use Http\Psr7Test\UploadedFileIntegrationTest;

class UploadedFileTest extends UploadedFileIntegrationTest
{
    public function createSubject()
    {
        $this->markTestSkipped('RingCentral does not implement UploadedFileInterface.');
    }
}
