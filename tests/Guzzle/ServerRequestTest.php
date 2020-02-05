<?php

namespace Http\Psr7Test\Tests\Guzzle;

use GuzzleHttp\Psr7\ServerRequest;
use Http\Psr7Test\ServerRequestIntegrationTest;

class ServerRequestTest extends ServerRequestIntegrationTest
{
    /**
     * Guzzle accepts more types for parsed body.
     *
     * ServerRequestInterface::withParsedBody says
     * > The data IS NOT REQUIRED to come from $_POST, but MUST be the results of
     * > deserializing the request body content. Deserialization/parsing returns
     * > structured data, and, as such, this method ONLY accepts arrays or objects,
     * > or a null value if nothing was available to parse.
     * > As an example, if content negotiation determines that the request data
     * > is a JSON payload, this method could be used to create a request
     * > instance with the deserialized parameters.
     *
     * A JSON body payload can also be a json string, a json int etc. So withParsedBody would also need to accept that as well. Those two sentences contradict each other.
     * According to a slack discussion, this was based on rfc4627
     * > A JSON text is a serialized object or array.
     *
     * But that is outdated since since rfc7158 in 2013 which does not limit it to array or object anymore. See current https://tools.ietf.org/html/rfc8259
     *
     * > A JSON text is a serialized value. Note that certain previous
     * > specifications of JSON constrained a JSON text to be an object or an
     * > array.
     */
    protected $skippedTests = [
        'testGetParsedBodyInvalid' => 'more types are accepted per rfc7158',
    ];

    public function createSubject()
    {
        return new ServerRequest('GET', '/', [], null, '1.1', $_SERVER);
    }
}
