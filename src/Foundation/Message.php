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

use Guanguans\Notify\Foundation\Traits\HasOptions;
use Guanguans\Notify\Traits\CreateStaticable;

class Message implements Contracts\Message
{
    use HasOptions;
    use CreateStaticable;

    public function __construct(array $options = [])
    {
        $this->setOptions($options);
    }

    /**
     * @return array|mixed
     */
    public function toPayload()
    {
        return $this->options;
    }
}