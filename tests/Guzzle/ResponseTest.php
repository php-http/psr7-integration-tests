<?php

namespace Http\Psr7Test\Tests\Guzzle;

use GuzzleHttp\Psr7\Response;
use Http\Psr7Test\ResponseIntegrationTest;

class ResponseTest extends ResponseIntegrationTest
{
    public function createSubject()
    {
        return new Response();
    }

    public static function getInvalidHeaderArguments()
    {
        $testCases = parent::getInvalidHeaderArguments();

        // Guzzle accepts false as value for BC
        unset($testCases[3]);

        return $testCases;
    }
}
