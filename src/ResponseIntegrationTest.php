<?php

namespace Http\Psr7Test;

use InvalidArgumentException;
use PHPUnit\Framework\AssertionFailedError;
use Psr\Http\Message\ResponseInterface;
use Throwable;
use TypeError;

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

        try {
            $this->response->withStatus($statusCode);
            $this->fail('withStatus() should have raised exception on invalid argument');
        } catch (AssertionFailedError $e) {
            // invalid argument not caught
            throw $e;
        } catch (InvalidArgumentException|TypeError $e) {
            // valid
            $this->assertTrue($e instanceof Throwable);
        } catch (Throwable $e) {
            // invalid
            $this->fail(sprintf(
                'Unexpected exception (%s) thrown from withStatus(); expected TypeError or InvalidArgumentException',
                gettype($e)
            ));
        }
    }

    public static function getInvalidStatusCodeArguments()
    {
        return [
            'true' => [true],
            'string' => ['foobar'],
            'too-low' => [99],
            'too-high' => [600],
            'object' => [new \stdClass()],
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
