<?php

namespace Http\Psr7Test;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
abstract class ServerRequestIntegrationTest extends BaseTest
{
    /**
     * @var array with functionName => reason
     */
    protected $skippedTests = [];

    /**
     * @var ServerRequestInterface
     */
    private $serverRequest;

    /**
     * @return ServerRequestInterface that is used in the tests
     */
    abstract public function createSubject();

    protected function setUp()
    {
        $this->serverRequest = $this->createSubject();
    }

    public function testGetServerParams()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $this->assertEquals($_SERVER, $this->serverRequest->getServerParams());
    }

    public function testGetCookieParams()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $this->assertEquals($_COOKIE, $this->serverRequest->getCookieParams());
    }

    public function testWithCookieParams()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $orgCookie = $_COOKIE;
        $new = $this->serverRequest->withCookieParams(['foo' => 'bar']);

        $this->assertEquals($orgCookie, $this->serverRequest->getCookieParams(), 'Super global $_COOKIE MUST NOT change.');
        $this->assertNotEquals($orgCookie, $new->getCookieParams());

        $this->assertArrayHasKey('foo', $new->getCookieParams());
    }

    public function testGetQueryParams()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $new = $this->serverRequest->withQueryParams(['foo' => 'bar']);
        $this->assertEmpty($this->serverRequest->getQueryParams(), 'withQueryParams MUST be immutable');

        $this->assertArrayHasKey('foo', $new->getQueryParams());
    }

    public function testGetUploadedFiles()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $file = $this->buildUploadableFile('foo');
        $new = $this->serverRequest->withUploadedFiles([$file]);
        $this->assertEmpty($this->serverRequest->getUploadedFiles(), 'withUploadedFiles MUST be immutable');

        $files = $new->getUploadedFiles();
        $this->assertEquals(1, count($files));
        $this->assertEquals($file, $files[0]);
    }

    /**
     * @dataProvider validParsedBodyParams
     */
    public function testGetParsedBody($value)
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $new = $this->serverRequest->withParsedBody($value);
        $this->assertNull($this->serverRequest->getParsedBody(), 'withParsedBody MUST be immutable');
        $this->assertEquals($value, $new->getParsedBody());
    }

    public function validParsedBodyParams()
    {
        return [
            [null],
            [new \stdClass()],
            [['foo' => 'bar', 'baz']],
        ];
    }

    /**
     * @dataProvider invalidParsedBodyParams
     * @expectedException \InvalidArgumentException
     */
    public function testGetParsedBodyInvalid($value)
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $new = $this->serverRequest->withParsedBody($value);
        $this->assertNull($this->serverRequest->getParsedBody(), 'withParsedBody MUST be immutable');
        $this->assertEquals($value, $new->getParsedBody());
    }

    public function invalidParsedBodyParams()
    {
        return [
            [4711],
            [47.11],
            ['foobar'],
            [true],
        ];
    }

    public function testGetAttributes()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $new = $this->serverRequest->withAttribute('foo', 'bar');
        $oldAttributes = $this->serverRequest->getAttributes();
        $this->assertInternalType('array', $oldAttributes, 'getAttributes MUST return an array');
        $this->assertEmpty($oldAttributes, 'withAttribute MUST be immutable');
        $this->assertEquals(['foo' => 'bar'], $new->getAttributes());

        $new = $new->withAttribute('baz', 'biz');
        $this->assertEquals(['foo' => 'bar', 'baz' => 'biz'], $new->getAttributes());
    }

    public function testGetAttribute()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $new = $this->serverRequest->withAttribute('foo', 'bar');
        $this->assertEquals('bar', $new->getAttribute('foo'));
        $this->assertEquals('baz', $new->getAttribute('not found', 'baz'));
        $this->assertEquals(null, $new->getAttribute('not found'));
    }

    public function testWithoutAttribute()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $with = $this->serverRequest->withAttribute('foo', 'bar');
        $without = $with->withoutAttribute('foo');

        $this->assertEquals('bar', $with->getAttribute('foo'), 'withoutAttribute MUST be immutable');
        $this->assertEquals(null, $without->getAttribute('foo'));
    }
}
