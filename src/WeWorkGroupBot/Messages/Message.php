<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Notify\WeWorkGroupBot\Messages;

use Guanguans\Notify\Foundation\Concerns\AsJson;
use Guanguans\Notify\Foundation\Concerns\AsPost;
use Guanguans\Notify\Foundation\Credentials\TokenUriTemplateCredential;
use GuzzleHttp\RequestOptions;

abstract class Message extends \Guanguans\Notify\Foundation\Message
{
    use AsJson;
    use AsPost;

    public function toHttpUri()
    {
        return sprintf(
            'https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key={%s}',
            TokenUriTemplateCredential::TEMPLATE
        );
    }

    public function toHttpOptions(): array
    {
        return [
            RequestOptions::JSON => [
                'msgtype' => $this->type(),
                $this->type() => $this->getOptions(),
            ],
        ];
    }

    abstract protected function type(): string;
}
