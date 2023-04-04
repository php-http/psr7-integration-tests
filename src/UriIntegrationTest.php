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
     *
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
     *
     * @psalm-param array{expected: non-empty-string, uri: UriInterface} $test
     */
    public function testStringRepresentationWithMultipleSlashes(array $test)
    {
        $this->assertSame($test['expected'], (string) $test['uri']);
    }

    /**
     * Tests that special chars in `userInfo` must always be URL-encoded to pass RFC3986 compliant URIs where characters
     * in username and password MUST NOT contain reserved characters.
     *
     * This test is taken from {@see https://github.com/guzzle/psr7/blob/3cf1b6d4f0c820a2cf8bcaec39fc698f3443b5cf/tests/UriTest.php#L679-L688 guzzlehttp/psr7}.
     *
     * @see https://www.rfc-editor.org/rfc/rfc3986#appendix-A
     */
    public function testSpecialCharsInUserInfo(): void
    {
        $uri = $this->createUri('/')->withUserInfo('foo@bar.com', 'pass#word');
        self::assertSame('foo%40bar.com:pass%23word', $uri->getUserInfo());
    }

    /**
     * Tests that userinfo which is already encoded is not encoded twice.
     * This test is taken from {@see https://github.com/guzzle/psr7/blob/3cf1b6d4f0c820a2cf8bcaec39fc698f3443b5cf/tests/UriTest.php#L679-L688 guzzlehttp/psr7}.
     */
    public function testAlreadyEncodedUserInfo(): void
    {
        $uri = $this->createUri('/')->withUserInfo('foo%40bar.com', 'pass%23word');
        self::assertSame('foo%40bar.com:pass%23word', $uri->getUserInfo());
    }
}
