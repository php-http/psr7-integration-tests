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
        }

        $initialMessage = $this->getMessage();
        $original = clone $initialMessage;

        $message = $initialMessage->withProtocolVersion('1.0');

        $this->assertNotSameObject($initialMessage, $message);
        $this->assertEquals($initialMessage, $original, 'Message object MUST not be mutated');

        $this->assertSame('1.0', $message->getProtocolVersion());
    }

    public function testGetHeaders()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $initialMessage = $this->getMessage();
        $original = clone $initialMessage;

        $message = $initialMessage
            ->withAddedHeader('content-type', 'text/html')
            ->withAddedHeader('content-type', 'text/plain');

        $this->assertEquals($initialMessage, $original, 'Message object MUST not be mutated');

        $headers = $message->getHeaders();

        $this->assertTrue(isset($headers['content-type']));
        $this->assertCount(2, $headers['content-type']);
        $this->assertContains('text/html', $headers['content-type']);
        $this->assertContains('text/plain', $headers['content-type']);
    }

    public function testHasHeader()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
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
        }

        $message = $this->getMessage()->withAddedHeader('content-type', 'text/html');
        $message = $message->withAddedHeader('content-type', 'text/plain');
        $this->assertCount(2, $message->getHeader('content-type'));
        $this->assertCount(2, $message->getHeader('Content-Type'));
        $this->assertCount(2, $message->getHeader('CONTENT-TYPE'));
        $emptyHeader = $message->getHeader('Bar');
        $this->assertCount(0, $emptyHeader);
        $this->assertIsArray($emptyHeader);
    }

    public function testGetHeaderLine()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $message = $this->getMessage()->withAddedHeader('content-type', 'text/html');
        $message = $message->withAddedHeader('content-type', 'text/plain');
        $this->assertRegExp('|text/html, ?text/plain|', $message->getHeaderLine('content-type'));
        $this->assertRegExp('|text/html, ?text/plain|', $message->getHeaderLine('Content-Type'));
        $this->assertRegExp('|text/html, ?text/plain|', $message->getHeaderLine('CONTENT-TYPE'));

        $this->assertSame('', $message->getHeaderLine('Bar'));
    }

    public function testWithHeader()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $initialMessage = $this->getMessage();
        $original = clone $initialMessage;

        $message = $initialMessage->withHeader('content-type', 'text/html');
        $this->assertNotSameObject($initialMessage, $message);
        $this->assertEquals($initialMessage, $original, 'Message object MUST not be mutated');
        $this->assertEquals('text/html', $message->getHeaderLine('content-type'));

        $message = $initialMessage->withHeader('content-type', 'text/plain');
        $this->assertEquals('text/plain', $message->getHeaderLine('content-type'));

        $message = $initialMessage->withHeader('Content-TYPE', 'text/script');
        $this->assertEquals('text/script', $message->getHeaderLine('content-type'));

        $message = $initialMessage->withHeader('x-foo', ['bar', 'baz']);
        $this->assertRegExp('|bar, ?baz|', $message->getHeaderLine('x-foo'));

        $message = $initialMessage->withHeader('Bar', '');
        $this->assertTrue($message->hasHeader('Bar'));
        $this->assertSame([''], $message->getHeader('Bar'));
    }

    /**
     * @dataProvider getInvalidHeaderArguments
     */
    public function testWithHeaderInvalidArguments($name, $value)
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }
        $this->expectException(\InvalidArgumentException::class);
        $initialMessage = $this->getMessage();
        $initialMessage->withHeader($name, $value);
    }

    public function getInvalidHeaderArguments()
    {
        return [
            [[], 'foo'],
            ['foo', []],
            ['', ''],
            ['foo', false],
            [false, 'foo'],
            ['foo', new \stdClass()],
            [new \stdClass(), 'foo'],
        ];
    }

    public function testWithAddedHeader()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $message = $this->getMessage()->withAddedHeader('content-type', 'text/html');
        $message = $message->withAddedHeader('CONTENT-type', 'text/plain');
        $this->assertRegExp('|text/html, ?text/plain|', $message->getHeaderLine('content-type'));
        $this->assertRegExp('|text/html, ?text/plain|', $message->getHeaderLine('Content-Type'));
    }

    /**
     * @dataProvider getInvalidHeaderArguments
     */
    public function testWithAddedHeaderInvalidArguments($name, $value)
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }
        $this->expectException(\InvalidArgumentException::class);
        $initialMessage = $this->getMessage();
        $initialMessage->withAddedHeader($name, $value);
    }

    /**
     * Make sure we maintain headers when we add array values.
     */
    public function testWithAddedHeaderArrayValue()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $message = $this->getMessage()->withAddedHeader('content-type', 'text/html');
        $message = $message->withAddedHeader('content-type', ['text/plain', 'application/json']);

        $headerLine = $message->getHeaderLine('content-type');
        $this->assertRegExp('|text/html|', $headerLine);
        $this->assertRegExp('|text/plain|', $headerLine);
        $this->assertRegExp('|application/json|', $headerLine);
    }

    /**
     * Make sure we maintain headers when we add array values with keys.
     */
    public function testWithAddedHeaderArrayValueAndKeys()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $message = $this->getMessage()->withAddedHeader('content-type', ['foo' => 'text/html']);
        $message = $message->withAddedHeader('content-type', ['foo' => 'text/plain', 'bar' => 'application/json']);

        $headerLine = $message->getHeaderLine('content-type');
        $this->assertRegExp('|text/html|', $headerLine);
        $this->assertRegExp('|text/plain|', $headerLine);
        $this->assertRegExp('|application/json|', $headerLine);
    }

    public function testWithoutHeader()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
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
        }

        $initialMessage = $this->getMessage();
        $original = clone $initialMessage;
        $stream = $this->buildStream('foo');
        $message = $initialMessage->withBody($stream);
        $this->assertNotSameObject($initialMessage, $message);
        $this->assertEquals($initialMessage, $original, 'Message object MUST not be mutated');

        $this->assertEquals($stream, $message->getBody());
    }
}
