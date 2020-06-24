<?php

namespace Http\Psr7Test;

use GuzzleHttp\Psr7\Stream as GuzzleStream;
use GuzzleHttp\Psr7\UploadedFile as GuzzleUploadedFile;
use GuzzleHttp\Psr7\Uri as GuzzleUri;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\UriInterface;
use Slim\Psr7\Uri as SlimUri;

use Zend\Diactoros\Stream as ZendStream;
use Zend\Diactoros\Uri as ZendUri;
use Zend\Diactoros\UploadedFile as ZendUploadedFile;
use Shieldon\Psr7\Uri as ShieldonUri;
use Shieldon\Psr17\StreamFactory as ShieldonStreamFactory;
use Shieldon\Psr17\UploadedFileFactory as ShieldonUploadedFileFactory;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
abstract class BaseTest extends TestCase
{
    protected function assertNotSameObject($a, $b)
    {
        $this->assertFalse($a === $b, 'Object does not have different references.');
    }

    protected function buildUri($uri)
    {
        if (defined('URI_FACTORY')) {
            $factoryClass = URI_FACTORY;
            $factory = new $factoryClass();
            if ($factory instanceof \Http\Message\UriFactory) {
                return $factory->createUri($uri);
            }
            if ($factory instanceof \Psr\Http\Message\UriFactoryInterface) {
                if ($uri instanceof UriInterface) {
                    return $uri;
                }

                return $factory->createUri($uri);
            }

            throw new \RuntimeException('Constant "URI_FACTORY" must be a reference to a Http\Message\UriFactory or \Psr\Http\Message\UriFactoryInterface');
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

        if (class_exists(ZendUri::class)) {
            return new ZendUri($uri);
        }

        if (class_exists(ShieldonUri::class)) {
            return new ShieldonUri($uri);
        }

        throw new \RuntimeException('Could not create URI. Check your config');
    }

    protected function buildStream($data)
    {
        if (defined('STREAM_FACTORY')) {
            $factoryClass = STREAM_FACTORY;
            $factory = new $factoryClass();
            if ($factory instanceof \Http\Message\StreamFactory) {
                return $factory->createStream($data);
            }
            if ($factory instanceof \Psr\Http\Message\StreamFactoryInterface) {
                if (is_string($data)) {
                    return $factory->createStream($data);
                } else {
                    return $factory->createStreamFromResource($data);
                }
            }

            throw new \RuntimeException('Constant "STREAM_FACTORY" must be a reference to a Http\Message\StreamFactory or \Psr\Http\Message\StreamFactoryInterface');
        }

        if (class_exists(GuzzleStream::class)) {
            return \GuzzleHttp\Psr7\stream_for($data);
        }

        if (class_exists(ZendStream::class)) {
            return new ZendStream($data);
        }

        if (class_exists(ShieldonStreamFactory::class)) {
            if (is_string($data)) {
                return (new ShieldonStreamFactory)->createStream($data);
            }
            return (new ShieldonStreamFactory)->createStreamFromResource($data);
        }

        throw new \RuntimeException('Could not create Stream. Check your config');
    }

    protected function buildUploadableFile($data)
    {
        if (defined('UPLOADED_FILE_FACTORY')) {
            $factoryClass = UPLOADED_FILE_FACTORY;
            $factory = new $factoryClass();
            if (!$factory instanceof \Psr\Http\Message\UploadedFileFactoryInterface) {
                throw new \RuntimeException('Constant "UPLOADED_FILE_FACTORY" must be a reference to a Psr\Http\Message\UploadedFileFactoryInterface');
            }

            $stream = $this->buildStream($data);

            return $factory->createUploadedFile($stream);
        }

        if (class_exists(GuzzleUploadedFile::class)) {
            return new GuzzleUploadedFile($data, strlen($data), 0);
        }

        if (class_exists(ZendUploadedFile::class)) {
            return new ZendUploadedFile($data, strlen($data), 0);
        }

        if (class_exists(ShieldonUploadedFileFactory::class)) {
            return ShieldonUploadedFileFactory::fromGlobal();
        }

        throw new \RuntimeException('Could not create Stream. Check your config');
    }
}
