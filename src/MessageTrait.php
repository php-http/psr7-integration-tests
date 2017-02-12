<?php

namespace Http\Psr7Test;

use Psr\Http\Message\MessageInterface;

/**
 * Test MessageInterface.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
trait MessageTrait
{
    /**
     * @return MessageInterface
     */
    abstract protected function getMessage();

    public function testProtocolVersion()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);

            return;
        }

        $initialMessage = $this->getMessage();
        $message = $initialMessage->withProtocolVersion('1.0');
        $this->assertNotSameObject($initialMessage, $message);

        $this->assertEquals('1.0', $message->getProtocolVersion());
    }

    public function testGetHeaders()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);

            return;
        }

        $message = $this->getMessage()->withAddedHeader('content-type', 'text/html');
        $message = $message->withAddedHeader('content-type', 'text/plain');
        $headers = $message->getHeaders();

        $this->assertTrue(isset($headers['content-type']));
        $this->assertCount(2, $headers['content-type']);
    }

    public function testHasHeader()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);

            return;
        }

        $message = $this->getMessage()->withAddedHeader('content-type', 'text/html');

        $this->assertTrue($message->hasHeader('content-type'));
        $this->assertTrue($message->hasHeader('Content-Type'));
        $this->assertTrue($message->hasHeader('ConTent-Type'));
    }

    public function testGetHeader()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);

            return;
        }

        $message = $this->getMessage()->withAddedHeader('content-type', 'text/html');
        $message = $message->withAddedHeader('content-type', 'text/plain');
        $this->assertCount(2, $message->getHeader('content-type'));
        $this->assertCount(2, $message->getHeader('Content-Type'));
        $this->assertCount(2, $message->getHeader('CONTENT-TYPE'));
        $emptyHeader = $message->getHeader('Bar');
        $this->assertCount(0, $emptyHeader);
        $this->assertTrue(is_array($emptyHeader));
    }

    public function testGetHeaderLine()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);

            return;
        }

        $message = $this->getMessage()->withAddedHeader('content-type', 'text/html');
        $message = $message->withAddedHeader('content-type', 'text/plain');
        $this->assertRegExp('|text/html, ?text/plain|', $message->getHeaderLine('content-type'));
        $this->assertRegExp('|text/html, ?text/plain|', $message->getHeaderLine('Content-Type'));
        $this->assertRegExp('|text/html, ?text/plain|', $message->getHeaderLine('CONTENT-TYPE'));

        $this->assertEquals('', $message->getHeaderLine('Bar'));
    }

    public function testWithHeader()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);

            return;
        }

        $initialMessage = $this->getMessage();
        $message = $initialMessage->withHeader('content-type', 'text/html');
        $this->assertNotSameObject($initialMessage, $message);
        $this->assertEquals('text/html', $message->getHeaderLine('content-type'));

        $message = $initialMessage->withHeader('content-type', 'text/plain');
        $this->assertEquals('text/plain', $message->getHeaderLine('content-type'));

        $message = $initialMessage->withHeader('Content-TYPE', 'text/script');
        $this->assertEquals('text/script', $message->getHeaderLine('content-type'));
    }

    public function testWithAddedHeader()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);

            return;
        }

        $message = $this->getMessage()->withAddedHeader('content-type', 'text/html');
        $message = $message->withAddedHeader('CONTENT-type', 'text/plain');
        $this->assertRegExp('|text/html, ?text/plain|', $message->getHeaderLine('content-type'));
        $this->assertRegExp('|text/html, ?text/plain|', $message->getHeaderLine('Content-Type'));
    }

    public function testWithoutHeader()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);

            return;
        }

        $message = $this->getMessage()->withAddedHeader('content-type', 'text/html');
        $message = $message->withAddedHeader('Age', '0');
        $message = $message->withAddedHeader('X-Foo', 'bar');

        $headers = $message->getHeaders();
        $headerCount = count($headers);
        $this->assertTrue(isset($headers['Age']));

        // Remove a header
        $message = $message->withoutHeader('age');
        $headers = $message->getHeaders();
        $this->assertCount($headerCount - 1, $headers);
        $this->assertFalse(isset($headers['Age']));
    }

    public function testBody()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);

            return;
        }

        $initialMessage = $this->getMessage();
        $stream = \GuzzleHttp\Psr7\stream_for('foo');
        $message = $initialMessage->withBody($stream);
        $this->assertNotSameObject($initialMessage, $message);

        $this->assertEquals($stream, $message->getBody());
    }
}
