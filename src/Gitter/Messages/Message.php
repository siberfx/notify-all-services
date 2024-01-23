<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Notify\Gitter\Messages;

use Guanguans\Notify\Foundation\Concerns\AsJson;
use Guanguans\Notify\Foundation\Concerns\AsPost;

class Message extends \Guanguans\Notify\Foundation\Message
{
    use AsPost;
    use AsJson;

    protected array $defined = [
        'text',
    ];

    private string $roomsId;

    public function __construct(string $roomsId, string $text)
    {
        parent::__construct(['text' => $text]);
        $this->roomsId = $roomsId;
    }

    public function httpUri(): string
    {
        return "https://api.gitter.im/v1/rooms/$this->roomsId/chatMessages";
    }
}