<?php

namespace Http\Psr7Test;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
abstract class ResponseIntegrationTest extends BaseTest
{
    use MessageTrait;

    /**
     * @var array with functionName => reason
     */
    protected $skippedTests = [];

    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @return RequestInterface that is used in the tests
     */
    abstract public function createSubject();

    protected function setUp()
    {
        $this->response = $this->createSubject();
    }

    protected function getMessage()
    {
        return $this->response;
    }

    public function testStatusCode()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $response = $this->response->withStatus(204);
        $this->assertNotSameObject($this->response, $response);
        $this->assertEquals(204, $response->getStatusCode());
    }

    public function testReasonPhrase()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $response = $this->response->withStatus(204, 'Foobar');
        $this->assertEquals(204, $response->getStatusCode());
        $this->assertEquals('Foobar', $response->getReasonPhrase());
    }
}
