<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Notify\Messages\FeiShu;

use Guanguans\Notify\Messages\Message;

class CardMessage extends Message
{
    protected string $type = 'card';

    /**
     * @var array<string>
     */
    protected array $defined = [
        'card',
    ];

    /**
     * @var array<string, string>
     */
    protected array $allowedTypes = [
        'card' => 'array',
    ];

    public function __construct(array $card)
    {
        parent::__construct([
            'card' => $card,
        ]);
    }

    /**
     * @return array<int|string, mixed>
     */
    public function transformToRequestParams(): array
    {
        return [
            'msg_type' => 'interactive',
            $this->type => $this->getOption('card'),
        ];
    }
}
