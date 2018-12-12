<?php

namespace Http\Psr7Test;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
abstract class RequestIntegrationTest extends BaseTest
{
    use MessageTrait;

    /**
     * @var array with functionName => reason
     */
    protected $skippedTests = [];

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @return RequestInterface that is used in the tests
     */
    abstract public function createSubject();

    protected function setUp()
    {
        $this->request = $this->createSubject();
    }

    protected function getMessage()
    {
        return $this->request;
    }

    public function testRequestTarget()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $original = clone $this->request;
        $this->assertEquals('/', $this->request->getRequestTarget());

        $request = $this->request->withRequestTarget('*');
        $this->assertNotSameObject($this->request, $request);
        $this->assertEquals($this->request, $original, 'Request object MUST not be mutated');
        $this->assertEquals('*', $request->getRequestTarget());
    }

    public function testMethod()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $this->assertEquals('GET', $this->request->getMethod());
        $original = clone $this->request;

        $request = $this->request->withMethod('POST');
        $this->assertNotSameObject($this->request, $request);
        $this->assertEquals($this->request, $original, 'Request object MUST not be mutated');
        $this->assertEquals('POST', $request->getMethod());

        $request = $this->request->withMethod('head');
        $this->assertEquals('head', $request->getMethod());
    }

    /**
     * @dataProvider getInvalidMethods
     */
    public function testMethodWithInvalidArguments($method)
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $this->expectException(\InvalidArgumentException::class);
        $this->request->withMethod($method);
    }

    public function getInvalidMethods()
    {
        return [
            [null],
            [1],
            [1.01],
            [false],
            [['foo']],
            [new \stdClass()],
        ];
    }

    public function testUri()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }
        $original = clone $this->request;

        $this->assertInstanceOf(UriInterface::class, $this->request->getUri());

        $uri = $this->buildUri('http://www.foo.com/bar');
        $request = $this->request->withUri($uri);
        $this->assertNotSameObject($this->request, $request);
        $this->assertEquals($this->request, $original, 'Request object MUST not be mutated');
        $this->assertEquals('www.foo.com', $request->getHeaderLine('host'));
        $this->assertInstanceOf(UriInterface::class, $request->getUri());
        $this->assertEquals('http://www.foo.com/bar', (string) $request->getUri());

        $request = $request->withUri($this->buildUri('/foobar'));
        $this->assertNotSameObject($this->request, $request);
        $this->assertEquals($this->request, $original, 'Request object MUST not be mutated');
        $this->assertEquals('www.foo.com', $request->getHeaderLine('host'), 'If the URI does not contain a host component, any pre-existing Host header MUST be carried over to the returned request.');
        $this->assertEquals('/foobar', (string) $request->getUri());
    }

    public function testUriPreserveHost_NoHost_Host()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $request = $this->request->withUri($this->buildUri('http://www.foo.com/bar'), true);
        $this->assertEquals('www.foo.com', $request->getHeaderLine('host'));
    }

    public function testUriPreserveHost_NoHost_NoHost()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $host = $this->request->getHeaderLine('host');
        $request = $this->request->withUri($this->buildUri('/bar'), true);
        $this->assertEquals($host, $request->getHeaderLine('host'));
    }

    public function testUriPreserveHost_Host_Host()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $request = $this->request->withUri($this->buildUri('http://www.foo.com/bar'));
        $host = $request->getHeaderLine('host');

        $request2 = $request->withUri($this->buildUri('http://www.bar.com/foo'), true);
        $this->assertEquals($host, $request2->getHeaderLine('host'));
    }
}
