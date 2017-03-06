<?php

namespace Http\Psr7Test;

use Psr\Http\Message\RequestInterface;
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
     * @return RequestInterface that is used in the tests
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

        // TODO write me
    }

    public function testGetUploadedFiles()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        // TODO write me
    }

    public function testGetParsedBody()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        // TODO write me
    }

    public function testGetAttributes()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        // TODO write me
    }
}
