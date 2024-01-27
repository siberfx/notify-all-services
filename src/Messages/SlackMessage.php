<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Notify\Messages;

use Symfony\Component\OptionsResolver\OptionsResolver;

class SlackMessage extends Message
{
    /**
     * @var array<string>
     */
    protected array $defined = [
        'text',
        'channel',
        'username',
        'icon_emoji',
        'icon_url',
        'unfurl_links',
        'attachments',
    ];

    /**
     * @var array<string, mixed>
     */
    protected array $options = [
        'unfurl_links' => false,
        'attachments' => [],
    ];

    protected array $allowedTypes = [
        'unfurl_links' => 'bool',
        'attachments' => 'array',
    ];

    public function setAttachments(array $attachments): self
    {
        return $this->addAttachments($attachments);
    }

    public function addAttachments(array $attachments): self
    {
        foreach ($attachments as $attachment) {
            $this->addAttachment($attachment);
        }

        return $this;
    }

    public function setAttachment(array $attachment): self
    {
        return $this->addAttachment($attachment);
    }

    public function addAttachment(array $attachment): self
    {
        $this->options['attachments'][] = configure_options($attachment, static function (OptionsResolver $optionsResolver): void {
            $optionsResolver->setDefined([
                'fallback',
                'text',
                'pretext',
                'color',
                'fields',
            ]);
        });

        return $this;
    }

    protected function configureOptionsResolver(OptionsResolver $optionsResolver): OptionsResolver
    {
        return tap(parent::configureOptionsResolver($optionsResolver), static function (OptionsResolver $resolver): void {
            $resolver->setNormalizer('attachments', static fn (OptionsResolver $optionsResolver, array $value): array => isset($value[0]) ? $value : [$value]);
        });
    }
}
