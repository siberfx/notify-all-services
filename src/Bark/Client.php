<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Notify\Bark;

class Client extends \Guanguans\Notify\Foundation\Client
{
    /**
     * @param \Guanguans\Notify\Bark\Credential|string $credential
     */
    public function __construct($credential, \GuzzleHttp\Client $httpClient = null)
    {
        if (! $credential instanceof Credential) {
            $credential = new Credential($credential);
        }

        parent::__construct($credential, $httpClient);
    }
}