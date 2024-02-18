<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Notify\Telegram\Messages;

/**
 * @method \Guanguans\Notify\Telegram\Messages\GetUpdatesMessage offset($offset)
 * @method \Guanguans\Notify\Telegram\Messages\GetUpdatesMessage limit($limit)
 * @method \Guanguans\Notify\Telegram\Messages\GetUpdatesMessage timeout($timeout)
 * @method \Guanguans\Notify\Telegram\Messages\GetUpdatesMessage allowedUpdates($allowedUpdates)
 */
class GetUpdatesMessage extends Message
{
    /**
     * @var array<string>
     */
    protected array $defined = [
        'offset',
        'limit',
        'timeout',
        'allowed_updates',
    ];

    public function toHttpUri(): string
    {
        return 'https://api.telegram.org/bot{token}/getUpdates';
    }
}