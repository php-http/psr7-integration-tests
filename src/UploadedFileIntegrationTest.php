<?php

namespace Http\Psr7Test;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * TODO Write me.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
abstract class UploadedFileIntegrationTest extends BaseTest
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

    public function testNothing()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);

            return;
        }

        $this->assertTrue(true);
    }
}
