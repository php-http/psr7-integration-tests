<?php

namespace Http\Psr7Test;

use GuzzleHttp\Psr7\Stream as GuzzleStream;
use GuzzleHttp\Psr7\Uri as GuzzleUri;
use Slim\Http\Uri as SlimUri;
use Zend\Diactoros\Stream as ZendStream;
use Zend\Diactoros\Uri as ZendUri;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class BaseTest extends \PHPUnit_Framework_TestCase
{
    protected function assertNotSameObject($a, $b)
    {
        $this->assertFalse($a === $b, 'Object does not have different references.');
    }

    protected function buildUri($uri)
    {
        $factory = getenv('URI_FACTORY');

        if (!empty($factory)) {
            $factoryClass = new $factory();
            if (!$factoryClass instanceof \Http\Message\UriFactory) {
                throw new \RuntimeException('Environment variable "URI_FACTORY" must be a reference to a Http\Message\UriFactory');
            }

            return $factoryClass->createUri($uri);
        }

        if (class_exists(GuzzleUri::class)) {
            return new GuzzleUri($uri);
        }

        if (class_exists(SlimUri::class)) {
            return SlimUri::createFromString($uri);
        }

        if (class_exists(ZendUri::class)) {
            return new ZendUri($uri);
        }

        throw new \RuntimeException('Could not create URI. Check your config');
    }

    protected function buildStream($data)
    {
        $factory = getenv('STREAM_FACTORY');

        if (!empty($factory)) {
            $factoryClass = new $factory();
            if (!$factoryClass instanceof \Http\Message\StreamFactory) {
                throw new \RuntimeException('Environment variable "STREAM_FACTORY" must be a reference to a Http\Message\StreamFactory');
            }

            return $factoryClass->createStream($data);
        }

        if (class_exists(GuzzleStream::class)) {
            return \GuzzleHttp\Psr7\stream_for($data);
        }

        if (class_exists(ZendStream::class)) {
            return new ZendStream($data);
        }

        throw new \RuntimeException('Could not create Stream. Check your config');
    }
}
