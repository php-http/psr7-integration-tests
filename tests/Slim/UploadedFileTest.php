<?php

namespace Http\Psr7Test\Tests\Slim;

use Http\Psr7Test\UploadedFileIntegrationTest;
use Slim\Psr7\UploadedFile;

class UploadedFileTest extends UploadedFileIntegrationTest
{
    public function createSubject()
    {
        $tmpfname = tempnam('/tmp', 'foobar');

        $handle = fopen($tmpfname, 'w');
        fwrite($handle, 'writing to tempfile');
        fclose($handle);

        return new UploadedFile($tmpfname);
    }
}
