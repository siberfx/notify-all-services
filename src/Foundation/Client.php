<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Notify\Foundation;

use Guanguans\Notify\Foundation\Authenticators\NullAuthenticator;
use Guanguans\Notify\Foundation\Concerns\Dumpable;
use Guanguans\Notify\Foundation\Concerns\HasHttpClient;
use Guanguans\Notify\Foundation\Contracts\Authenticator;
use Guanguans\Notify\Foundation\Contracts\Message;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class Client implements Contracts\Client
{
    use Dumpable;
    use HasHttpClient;

    private Authenticator $authenticator;

    public function __construct(?Authenticator $authenticator = null)
    {
        $this->authenticator = $authenticator ?? new NullAuthenticator;
    }

    public function __debugInfo(): array
    {
        return $this->withDebugInfo([
            'httpClient' => $this->getHttpClient(),
            'httpClientResolver' => $this->getHttpClientResolver(),
            'handlerStack' => $this->getHandlerStack(),
            'httpOptions' => $this->getHttpOptions(),
        ]);
    }

    /**
     * @return Response|ResponseInterface
     *
     * @throws GuzzleException
     */
    public function send(Message $message): ResponseInterface
    {
        return $this->getHttpClient()->request(
            $message->toHttpMethod(),
            $message->toHttpUri(),
            $this->authenticator->applyToOptions($message->toHttpOptions())
        );
    }
}
