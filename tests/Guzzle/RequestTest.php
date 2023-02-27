<?php

namespace Http\Psr7Test\Tests\Guzzle;

use GuzzleHttp\Psr7\Request;
use Http\Psr7Test\RequestIntegrationTest;

class RequestTest extends RequestIntegrationTest
{
    protected $skippedTests = [
        'testMethodIsCaseSensitive' => 'methods are uppercased for BC',
    ];

    public function createSubject()
    {
        return new Request('GET', '/');
    }

    public static function getInvalidHeaderArguments()
    {
        $testCases = parent::getInvalidHeaderArguments();

        // Guzzle accepts false as value for BC
        unset($testCases[3]);

        return $testCases;
    }
}
