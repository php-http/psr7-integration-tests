<?php

namespace Http\Psr7Test;

class BaseTest extends \PHPUnit_Framework_TestCase
{
    protected function assertNotSameObject($a, $b)
    {
        $this->assertFalse($a === $b, 'Object does not have different references.');
    }
}
