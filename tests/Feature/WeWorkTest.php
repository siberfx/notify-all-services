<?php

/**
 * This file is part of the guanguans/notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Notify\Tests\Feature;

use Guanguans\Notify\Factory;
use Guanguans\Notify\Tests\TestCase;

class WeWorkTest extends TestCase
{
    public function testText()
    {
        $this->expectOutputString('93000');

        $ret = Factory::weWork()
            ->setToken('73a3d5a3-ceff-4da8-bcf3-ff5891778')
            ->setMessage((new \Guanguans\Notify\Messages\WeWork\TextMessage([
                'content' => 'content',
            ])))
            ->send();

        echo $ret['errcode'];
    }

    public function testNews()
    {
        $this->expectOutputString('93000');

        $ret = Factory::weWork()
            ->setToken('73a3d5a3-ceff-4da8-bcf3-ff5891778')
            ->setMessage(new \Guanguans\Notify\Messages\WeWork\NewsMessage([
                'title' => 'This is title.',
                'description' => 'This is description.',
                'url' => 'https://github.com/guanguans/notify',
                'picurl' => 'https://avatars.githubusercontent.com/u/22309277?v=4',
            ]))
            ->send();

        echo $ret['errcode'];
    }

    public function testMarkdown()
    {
        $this->expectOutputString('93000');

        $ret = Factory::weWork()
            ->setToken('73a3d5a3-ceff-4da8-bcf3-ff5891778')
            ->setMessage((new \Guanguans\Notify\Messages\WeWork\MarkdownMessage([
                'content' => 'content',
            ])))
            ->send();

        echo $ret['errcode'];
    }

    public function testImage()
    {
        $this->expectOutputString('93000');

        $ret = Factory::weWork()
            ->setToken('73a3d5a3-ceff-4da8-bcf3-ff5891778')
            ->setMessage((new \Guanguans\Notify\Messages\WeWork\ImageMessage([
                'imagePath' => 'https://avatars.githubusercontent.com/u/22309277?v=4',
            ])))
            ->send();

        echo $ret['errcode'];
    }
}
