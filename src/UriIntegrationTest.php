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
        }

        $uri = $this->createUri('/');
        $this->assertSame('', $uri->getScheme());

        $uri = $this->createUri('https://foo.com/');
        $this->assertEquals('https', $uri->getScheme());

        $newUri = $uri->withScheme('http');
        $this->assertNotSameObject($uri, $newUri);
        $this->assertEquals('http', $newUri->getScheme());
    }

    /**
     * @dataProvider getInvalidSchemaArguments
     */
    public function testWithSchemeInvalidArguments($schema)
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $this->expectException(\InvalidArgumentException::class);
        $this->createUri('/')->withScheme($schema);
    }

    public function getInvalidSchemaArguments()
    {
        return [
            [true],
            [['foobar']],
            [34],
            [new \stdClass()],
        ];
    }

    public function testAuthority()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
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
        }

        $uri = $this->createUri('/');
        $this->assertSame('', $uri->getHost());

        $uri = $this->createUri('http://www.foo.com/');
        $this->assertEquals('www.foo.com', $uri->getHost());

        $uri = $this->createUri('http://FOOBAR.COM/');
        $this->assertEquals('foobar.com', $uri->getHost());
    }

    public function testPort()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $uri = $this->createUri('http://www.foo.com/');
        $this->assertNull($uri->getPort());

        $uri = $this->createUri('http://www.foo.com:80/');
        $this->assertNull($uri->getPort());

        $uri = $this->createUri('https://www.foo.com:443/');
        $this->assertNull($uri->getPort());

        $uri = $this->createUri('http://www.foo.com:81/');
        $this->assertSame(81, $uri->getPort());
    }

    /**
     * @dataProvider getPaths
     */
    public function testPath(UriInterface $uri, $expected)
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $this->assertSame($expected, $uri->getPath());
    }

    public function getPaths()
    {
        return [
            [$this->createUri('http://www.foo.com/'), '/'],
            [$this->createUri('http://www.foo.com'), ''],
            [$this->createUri('foo/bar'), 'foo/bar'],
            [$this->createUri('http://www.foo.com/foo bar'), '/foo%20bar'],
            [$this->createUri('http://www.foo.com/foo%20bar'), '/foo%20bar'],
            [$this->createUri('http://www.foo.com/foo%2fbar'), '/foo%2fbar'],
        ];
    }

    /**
     * @dataProvider getQueries
     */
    public function testQuery(UriInterface $uri, $expected)
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $this->assertSame($expected, $uri->getQuery());
    }

    public function getQueries()
    {
        return [
            [$this->createUri('http://www.foo.com'), ''],
            [$this->createUri('http://www.foo.com?'), ''],
            [$this->createUri('http://www.foo.com?foo=bar'), 'foo=bar'],
            [$this->createUri('http://www.foo.com?foo=bar%26baz'), 'foo=bar%26baz'],
            [$this->createUri('http://www.foo.com?foo=bar&baz=biz'), 'foo=bar&baz=biz'],
        ];
    }

    /**
     * @dataProvider getFragments
     */
    public function testFragment(UriInterface $uri, $expected)
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $this->assertEquals($expected, $uri->getFragment());
    }

    public function getFragments()
    {
        return [
            [$this->createUri('http://www.foo.com'), ''],
            [$this->createUri('http://www.foo.com#'), ''],
            [$this->createUri('http://www.foo.com#foo'), 'foo'],
            [$this->createUri('http://www.foo.com#foo%20bar'), 'foo%20bar'],
        ];
    }

    public function testUriModification1()
    {
        $expected = 'https://0:0@0:1/0?0#0';
        $uri = $this->createUri($expected);

        $this->assertInstanceOf(UriInterface::class, $uri);
        $this->assertSame($expected, (string) $uri);
    }

    public function testUriModification2()
    {
        $expected = 'https://0:0@0:1/0?0#0';
        $uri = $this
            ->createUri('')
            ->withHost('0')
            ->withPort(1)
            ->withUserInfo('0', '0')
            ->withScheme('https')
            ->withPath('/0')
            ->withQuery('0')
            ->withFragment('0')
        ;

        $this->assertInstanceOf(UriInterface::class, $uri);
        $this->assertSame($expected, (string) $uri);
    }

    public function testPathWithMultipleSlashes()
    {
        $expected = 'http://example.org//valid///path';
        $uri = $this->createUri($expected);

        $this->assertInstanceOf(UriInterface::class, $uri);
        $this->assertSame($expected, (string) $uri);
        $this->assertSame('//valid///path', $uri->getPath());
    }
}
