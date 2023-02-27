<?php

namespace Http\Psr7Test;

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
     * @return ResponseInterface that is used in the tests
     */
    abstract public function createSubject();

    protected function setUp(): void
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

        $original = clone $this->response;
        $response = $this->response->withStatus(204);
        $this->assertNotSameObject($this->response, $response);
        $this->assertEquals($this->response, $original, 'Response MUST not be mutated');
        $this->assertSame(204, $response->getStatusCode());
    }

    /**
     * @dataProvider getInvalidStatusCodeArguments
     */
    public function testStatusCodeInvalidArgument($statusCode)
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $this->expectException(\InvalidArgumentException::class);
        $this->response->withStatus($statusCode);
    }

    public static function getInvalidStatusCodeArguments()
    {
        return [
            [true],
            ['foobar'],
            [99],
            [600],
            [200.34],
            [new \stdClass()],
        ];
    }

    public function testReasonPhrase()
    {
        if (isset($this->skippedTests[__FUNCTION__])) {
            $this->markTestSkipped($this->skippedTests[__FUNCTION__]);
        }

        $response = $this->response->withStatus(204, 'Foobar');
        $this->assertSame(204, $response->getStatusCode());
        $this->assertEquals('Foobar', $response->getReasonPhrase());
    }
}
