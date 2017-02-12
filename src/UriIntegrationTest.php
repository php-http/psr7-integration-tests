<?php

namespace Http\Psr7Test;

use Psr\Http\Message\UriInterface;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
abstract class UriIntegrationTest extends BaseTest
{
    /**
     * @var array with functionName => reason
     */
    protected $skippedTests = [];

    /**
     * @param string $uri
     *
     * @return UriInterface
     */
    abstract public function createUri($uri);

    public function testScheme()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);

            return;
        }

        $uri = $this->createUri('/');
        $this->assertEquals('', $uri->getScheme());

        $uri = $this->createUri('https://foo.com/');
        $this->assertEquals('https', $uri->getScheme());

        $newUri = $uri->withScheme('http');
        $this->assertNotSameObject($uri, $newUri);
        $this->assertEquals('http', $newUri->getScheme());
    }

    public function testAuthority()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);

            return;
        }

        $uri = $this->createUri('/');
        $this->assertEquals('', $uri->getAuthority());

        $uri = $this->createUri('http://foo@bar.com:80/');
        $this->assertEquals('foo@bar.com', $uri->getAuthority());

        $uri = $this->createUri('http://foo@bar.com:81/');
        $this->assertEquals('foo@bar.com:81', $uri->getAuthority());

        $uri = $this->createUri('http://user:foo@bar.com/');
        $this->assertEquals('user:foo@bar.com', $uri->getAuthority());
    }

    public function testUserInfo()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);

            return;
        }

        $uri = $this->createUri('/');
        $this->assertEquals('', $uri->getUserInfo());

        $uri = $this->createUri('http://user:foo@bar.com/');
        $this->assertEquals('user:foo', $uri->getUserInfo());

        $uri = $this->createUri('http://foo@bar.com/');
        $this->assertEquals('foo', $uri->getUserInfo());
    }

    public function testHost()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);

            return;
        }

        $uri = $this->createUri('/');
        $this->assertEquals('', $uri->getHost());

        $uri = $this->createUri('http://www.foo.com/');
        $this->assertEquals('www.foo.com', $uri->getHost());

        $uri = $this->createUri('http://FOOBAR.COM/');
        $this->assertEquals('foobar.com', $uri->getHost());
    }

    public function testPort()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);

            return;
        }

        $uri = $this->createUri('http://www.foo.com/');
        $this->assertNull($uri->getPort());

        $uri = $this->createUri('http://www.foo.com:80/');
        $this->assertNull($uri->getPort());

        $uri = $this->createUri('https://www.foo.com:443/');
        $this->assertNull($uri->getPort());

        $uri = $this->createUri('http://www.foo.com:81/');
        $this->assertEquals(81, $uri->getPort());
    }

    public function testPath()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);

            return;
        }

        // TODO
    }
    public function testQuery()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);

            return;
        }

        // TODO
    }
    public function testFragment()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);

            return;
        }

        // TODO
    }
}
