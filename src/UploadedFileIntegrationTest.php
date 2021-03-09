<?php

namespace Http\Psr7Test;

use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
abstract class UploadedFileIntegrationTest extends BaseTest
{
    /**
     * @var array with functionName => reason
     */
    protected $skippedTests = [];

    /**
     * @var UploadedFileInterface
     */
    private $uploadedFile;

    /**
     * @return UploadedFileInterface that is used in the tests
     */
    abstract public function createSubject();

    public static function setUpBeforeClass(): void
    {
        @mkdir('.tmp');
        parent::setUpBeforeClass();
    }

    protected function setUp(): void
    {
        $this->uploadedFile = $this->createSubject();
    }

    public function testGetStream()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $file = $this->createSubject();

        $stream = $file->getStream();
        $this->assertTrue($stream instanceof StreamInterface);
    }

    public function testGetStreamAfterMoveTo()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $file = $this->createSubject();
        $this->expectException(\RuntimeException::class);
        $file->moveTo(sys_get_temp_dir().'/foo');
        $file->getStream();
    }

    public function testMoveToAbsolute()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $file = $this->createSubject();
        $targetPath = sys_get_temp_dir().'/'.uniqid('foo', true);

        $this->assertFalse(is_file($targetPath));
        $file->moveTo($targetPath);
        $this->assertTrue(is_file($targetPath));
    }

    public function testMoveToRelative()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $file = $this->createSubject();
        $targetPath = '.tmp/'.uniqid('foo', true);

        $this->assertFalse(is_file($targetPath));
        $file->moveTo($targetPath);
        $this->assertTrue(is_file($targetPath));
    }

    public function testMoveToTwice()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }
        $this->expectException(\RuntimeException::class);

        $file = $this->createSubject();
        $file->moveTo('.tmp/'.uniqid('foo', true));
        $file->moveTo('.tmp/'.uniqid('foo', true));
    }

    public function testGetSize()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $file = $this->createSubject();
        $size = $file->getSize();
        if ($size || 0 === $size) {
            // @TODO remove when package require phpunit 9.1
            if (function_exists('PHPUnit\Framework\assertMatchesRegularExpression')) {
                $this->assertMatchesRegularExpression('|^[0-9]+$|', (string) $size);
            } else {
                $this->assertRegExp('|^[0-9]+$|', (string) $size);
            }
        } else {
            $this->assertNull($size);
        }
    }

    public function testGetError()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $file = $this->createSubject();
        $this->assertEquals(UPLOAD_ERR_OK, $file->getError());
    }

    public function testGetClientFilename()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $file = $this->createSubject();
        $name = $file->getClientFilename();
        if ($name) {
            $this->assertTrue(is_string($name));
        } else {
            $this->assertNull($name);
        }
    }

    public function testGetClientMediaType()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $file = $this->createSubject();
        $type = $file->getClientMediaType();
        if ($type) {
            $this->assertTrue(is_string($type));
        } else {
            $this->assertNull($type);
        }
    }
}
