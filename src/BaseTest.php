<?php

namespace Http\Psr7Test;

use GuzzleHttp\Psr7\Stream as GuzzleStream;
use GuzzleHttp\Psr7\UploadedFile as GuzzleUploadedFile;
use GuzzleHttp\Psr7\Uri as GuzzleUri;
use GuzzleHttp\Psr7\Utils;
use Http\Message\StreamFactory;
use Http\Message\UriFactory;
use Laminas\Diactoros\Stream as ZendStream;
use Laminas\Diactoros\Uri as ZendUri;
use Laminas\Diactoros\UploadedFile as ZendUploadedFile;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UploadedFileFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use Slim\Psr7\Uri as SlimUri;

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
            if ($factory instanceof UriFactory) {
                return $factory->createUri($uri);
            }
            if ($factory instanceof UriFactoryInterface) {
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

        throw new \RuntimeException('Could not create URI. Check your config');
    }

    protected function buildStream($data)
    {
        if (defined('STREAM_FACTORY')) {
            $factoryClass = STREAM_FACTORY;
            $factory = new $factoryClass();
            if ($factory instanceof StreamFactory) {
                return $factory->createStream($data);
            }
            if ($factory instanceof StreamFactoryInterface) {
                if (is_string($data)) {
                    return $factory->createStream($data);
                } else {
                    return $factory->createStreamFromResource($data);
                }
            }

            throw new \RuntimeException('Constant "STREAM_FACTORY" must be a reference to a Http\Message\StreamFactory or \Psr\Http\Message\StreamFactoryInterface');
        }

        if (class_exists(GuzzleStream::class)) {
            return Utils::streamFor($data);
        }

        if (class_exists(ZendStream::class)) {
            return new ZendStream($data);
        }

        throw new \RuntimeException('Could not create Stream. Check your config');
    }

    protected function buildUploadableFile($data)
    {
        if (defined('UPLOADED_FILE_FACTORY')) {
            $factoryClass = UPLOADED_FILE_FACTORY;
            $factory = new $factoryClass();
            if (!$factory instanceof UploadedFileFactoryInterface) {
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

        throw new \RuntimeException('Could not create Stream. Check your config');
    }
}
