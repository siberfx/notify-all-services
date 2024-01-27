<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Notify\DingTalkGroupBot\Messages;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @method \Guanguans\Notify\DingTalkGroupBot\Messages\MarkdownMessage title($title)
 * @method \Guanguans\Notify\DingTalkGroupBot\Messages\MarkdownMessage text($text)
 * @method \Guanguans\Notify\DingTalkGroupBot\Messages\MarkdownMessage atMobiles($atMobiles)
 * @method \Guanguans\Notify\DingTalkGroupBot\Messages\MarkdownMessage atDingtalkIds($atDingtalkIds)
 * @method \Guanguans\Notify\DingTalkGroupBot\Messages\MarkdownMessage isAtAll($isAtAll)
 */
class MarkdownMessage extends Message
{
    protected array $defined = [
        'title',
        'text',
        'atMobiles',
        'atDingtalkIds',
        'isAtAll',
    ];

    protected array $allowedTypes = [
        'atMobiles' => ['int', 'string', 'array'],
        'atDingtalkIds' => ['int', 'string', 'array'],
        'isAtAll' => 'bool',
    ];

    protected function configureOptionsResolver(OptionsResolver $optionsResolver): OptionsResolver
    {
        return tap(parent::configureOptionsResolver($optionsResolver), static function (OptionsResolver $resolver): void {
            $resolver->setNormalizer('atMobiles', static fn (OptionsResolver $optionsResolver, $value): array => (array) $value);
            $resolver->setNormalizer('atDingtalkIds', static fn (OptionsResolver $optionsResolver, $value): array => (array) $value);
        });
    }

    protected function type(): string
    {
        return 'markdown';
    }
}
