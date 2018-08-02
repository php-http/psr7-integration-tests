<?php

namespace Http\Psr7Test;

use Psr\Http\Message\StreamInterface;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
abstract class StreamIntegrationTest extends BaseTest
{
    /**
     * @var array with functionName => reason
     */
    protected $skippedTests = [];

    /**
     * @param string|resource|StreamInterface $data
     *
     * @return StreamInterface
     */
    abstract public function createStream($data);

    public function testToStringReadOnlyStreams()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $resource = fopen(__FILE__, 'r');
        $stream = $this->createStream($resource);

        // Make sure this does not throw exception
        $content = (string) $stream;
        $this->assertNotEmpty($content, 'You MUST be able to convert a read only stream to string');
    }

    public function testToStringRewindStreamBeforeToString()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $resource = fopen('php://memory', 'rw');
        fwrite($resource, 'abcdef');
        fseek($resource, 3);
        $stream = $this->createStream($resource);

        $content = (string) $stream;
        $this->assertEquals('abcdef', $content);
    }

    public function testClose()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $resource = fopen('php://memory', 'rw');
        fwrite($resource, 'abcdef');
        $stream = $this->createStream($resource);

        $this->assertTrue(is_resource($resource));
        $stream->close();
        $this->assertFalse(is_resource($resource));
    }

    public function testDetach()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $resource = fopen('php://memory', 'rw');
        fwrite($resource, 'abc');
        $stream = $this->createStream($resource);

        $this->assertEquals($resource, $stream->detach());
    }

    public function testGetSize()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $resource = fopen('php://memory', 'rw');
        fwrite($resource, 'abc');
        $stream = $this->createStream($resource);

        $this->assertEquals(3, $stream->getSize());
    }

    public function testTell()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $resource = fopen('php://memory', 'rw');
        fwrite($resource, 'abcdef');
        $stream = $this->createStream($resource);

        $this->assertEquals(6, $stream->tell());
        $stream->seek(0);
        $this->assertEquals(0, $stream->tell());
        $stream->seek(3);
        $this->assertEquals(3, $stream->tell());
        $stream->seek(6);
        $this->assertEquals(6, $stream->tell());
    }

    public function testEof()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $resource = fopen('php://memory', 'rw');
        fwrite($resource, 'abcdef');
        $stream = $this->createStream($resource);

        $stream->seek(0);
        $this->assertFalse($stream->eof());
        $stream->read(20);
        $stream->read(10);
        $this->assertTrue($stream->eof());
    }

    public function testIsSeekable()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $resource = fopen('php://memory', 'rw');
        fwrite($resource, 'abcdef');
        $stream = $this->createStream($resource);
        $this->assertTrue($stream->isSeekable());
    }

    /**
     * @group internet
     */
    public function testIsNotSeekable()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $url = 'https://raw.githubusercontent.com/php-http/multipart-stream-builder/master/tests/Resources/httplug.png';
        $resource = fopen($url, 'r');
        $stream = $this->createStream($resource);
        $this->assertFalse($stream->isSeekable());
    }

    public function testIsWritable()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $resource = fopen('php://memory', 'rw');
        fwrite($resource, 'abcdef');
        $stream = $this->createStream($resource);
        $this->assertTrue($stream->isWritable());
    }

    /**
     * @group internet
     */
    public function testIsNotWritable()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $url = 'https://raw.githubusercontent.com/php-http/multipart-stream-builder/master/tests/Resources/httplug.png';
        $resource = fopen($url, 'r');
        $stream = $this->createStream($resource);
        $this->assertFalse($stream->isWritable());
    }

    public function testIsReadable()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $resource = fopen('php://memory', 'rw');
        fwrite($resource, 'abcdef');
        $stream = $this->createStream($resource);
        $this->assertTrue($stream->isReadable());
    }

    /**
     * @group internet
     */
    public function testIsNotReadable()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $url = 'https://raw.githubusercontent.com/php-http/multipart-stream-builder/master/tests/Resources/httplug.png';
        $resource = fopen($url, 'r');
        $stream = $this->createStream($resource);
        $this->assertTrue($stream->isReadable());
    }

    public function testSeek()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $resource = fopen('php://memory', 'rw');
        fwrite($resource, 'abcdef');
        $stream = $this->createStream($resource);
        $stream->seek(3);

        $this->assertEquals('def', fread($resource, 3));
    }

    public function testRewind()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $resource = fopen('php://memory', 'rw');
        fwrite($resource, 'abcdef');
        $stream = $this->createStream($resource);
        $stream->rewind();

        $this->assertEquals('abcdef', fread($resource, 6));
    }

    /**
     * @group internet
     * @expectedException \RuntimeException
     */
    public function testRewindNotSeekable()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $url = 'https://raw.githubusercontent.com/php-http/multipart-stream-builder/master/tests/Resources/httplug.png';
        $resource = fopen($url, 'r');
        $stream = $this->createStream($resource);
        $stream->rewind();
    }

    public function testWrite()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $resource = fopen('php://memory', 'rw');
        fwrite($resource, 'abc');
        $stream = $this->createStream($resource);
        $bytes = $stream->write('def');

        $this->assertEquals(3, $bytes);
        $this->assertEquals('abcdef', (string) $stream);
    }

    public function testRead()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $resource = fopen('php://memory', 'rw');
        fwrite($resource, 'abcdef');
        $stream = $this->createStream($resource);
        $stream->rewind();

        $data = $stream->read(3);
        $this->assertEquals('abc', $data);

        $data = $stream->read(10);
        $this->assertEquals('def', $data);
    }

    public function testGetContents()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $resource = fopen('php://memory', 'rw');
        fwrite($resource, 'abcdef');
        $stream = $this->createStream($resource);
        $stream->rewind();

        $stream->seek(3);
        $this->assertEquals('def', $stream->getContents());
        $this->assertEquals('', $stream->getContents());
    }
}
