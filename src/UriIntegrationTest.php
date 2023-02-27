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

    public static function getInvalidSchemaArguments()
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
    public function testPath(string $uri, string $expected)
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $this->assertSame($expected, $this->createUri($uri)->getPath());
    }

    public static function getPaths()
    {
        return [
            ['http://www.foo.com/', '/'],
            ['http://www.foo.com', ''],
            ['foo/bar', 'foo/bar'],
            ['http://www.foo.com/foo bar', '/foo%20bar'],
            ['http://www.foo.com/foo%20bar', '/foo%20bar'],
            ['http://www.foo.com/foo%2fbar', '/foo%2fbar'],
        ];
    }

    /**
     * @dataProvider getQueries
     */
    public function testQuery(string $uri, string $expected)
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $this->assertSame($expected, $this->createUri($uri)->getQuery());
    }

    public static function getQueries()
    {
        return [
            ['http://www.foo.com', ''],
            ['http://www.foo.com?', ''],
            ['http://www.foo.com?foo=bar', 'foo=bar'],
            ['http://www.foo.com?foo=bar%26baz', 'foo=bar%26baz'],
            ['http://www.foo.com?foo=bar&baz=biz', 'foo=bar&baz=biz'],
        ];
    }

    /**
     * @dataProvider getFragments
     */
    public function testFragment(string $uri, string $expected)
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $this->assertEquals($expected, $this->createUri($uri)->getFragment());
    }

    public static function getFragments()
    {
        return [
            ['http://www.foo.com', ''],
            ['http://www.foo.com#', ''],
            ['http://www.foo.com#foo', 'foo'],
            ['http://www.foo.com#foo%20bar', 'foo%20bar'],
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
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $expected = 'http://example.org/valid///path';
        $uri = $this->createUri($expected);

        $this->assertInstanceOf(UriInterface::class, $uri);
        $this->assertSame('/valid///path', $uri->getPath());
        $this->assertSame($expected, (string) $uri);
    }

    /**
     * Tests that getPath() normalizes multiple leading slashes to a single
     * slash. This is done to ensure that when a path is used in isolation from
     * the authority, it will not cause URL poisoning and/or XSS issues.
     *
     * @see https://cve.mitre.org/cgi-bin/cvename.cgi?name=CVE-2015-3257
     * @psalm-param array{expected: non-empty-string, uri: UriInterface} $test
     */
    public function testGetPathNormalizesMultipleLeadingSlashesToSingleSlashToPreventXSS()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $expected = 'http://example.org//valid///path';
        $uri = $this->createUri($expected);

        $this->assertInstanceOf(UriInterface::class, $uri);
        $this->assertSame('/valid///path', $uri->getPath());

        return [
            'expected' => $expected,
            'uri' => $uri,
        ];
    }

    /**
     * Tests that the full string representation of a URI that includes multiple
     * leading slashes in the path is presented verbatim (in contrast to what is
     * provided when calling getPath()).
     *
     * @depends testGetPathNormalizesMultipleLeadingSlashesToSingleSlashToPreventXSS
     * @psalm-param array{expected: non-empty-string, uri: UriInterface} $test
     */
    public function testStringRepresentationWithMultipleSlashes(array $test)
    {
        $this->assertSame($test['expected'], (string) $test['uri']);
    }
}
