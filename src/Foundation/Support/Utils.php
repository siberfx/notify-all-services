<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/notify.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Notify\Foundation\Support;

use Composer\InstalledVersions;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\StreamInterface;

\define('MULTIPART_TRY_OPEN_FILE', 1 << 0);
\define('MULTIPART_TRY_OPEN_URL', 1 << 1);

class Utils
{
    /**
     * Convert a form array into a multipart array.
     */
    public static function multipartFor(array $data, int $options = 0): array
    {
        /**
         * @param array-key $key
         * @param  null|resource|scalar|StreamInterface|array{
         *     name: string,
         *     contents: null|resource|scalar|StreamInterface,
         *     headers: array<string, string>,
         *     filename: string,
         *     foo: mixed,
         *     bar: mixed,
         * }  $value
         *
         * @return array{
         *     name: string,
         *     contents: null|resource|scalar|StreamInterface,
         *     headers: array<string, string>,
         *     filename: string,
         * }[]
         */
        $partResolver = static function ($key, $value) use (&$partResolver): array {
            if (! \is_array($value)) {
                return [['name' => $key, 'contents' => $value]];
            }

            if (
                isset($value['name'], $value['contents'])
                && [] === array_diff(array_keys($value), ['name', 'contents', 'headers', 'filename'])
            ) {
                return [$value];
            }

            $parts = [];
            foreach ($value as $k => $v) {
                $k = "{$key}[$k]";

                $parts[] = \is_array($v)
                    ? $partResolver($k, $v)
                    : [['name' => $k, 'contents' => $v]];
            }

            return array_merge([], ...$parts);
        };

        $contentsNormalizer = static function ($contents, int $options) {
            if (! \is_string($contents)) {
                return $contents;
            }

            if (
                (($options & MULTIPART_TRY_OPEN_URL) && filter_var($contents, FILTER_VALIDATE_URL))
                || (($options & MULTIPART_TRY_OPEN_FILE) && is_file($contents))
            ) {
                return \GuzzleHttp\Psr7\Utils::tryFopen($contents, 'r');
            }

            return $contents;
        };

        $parts = [];
        foreach ($data as $key => $value) {
            $parts[] = $partResolver($key, $value);
        }

        return array_map(
            static function (array $part) use ($contentsNormalizer, $options): array {
                $part['contents'] = $contentsNormalizer($part['contents'], $options);

                return $part;
            },
            array_merge([], ...$parts)
        );
    }

    /**
     * Retrieves the HTTP options constants.
     *
     * @return array<string, string>
     */
    public static function getHttpOptionsConstants(): array
    {
        $constants = (new \ReflectionClass(RequestOptions::class))->getConstants() + [
            // '_CONDITIONAL' => '_conditional',
            'BASE_URI' => 'base_uri',
            'CURL' => 'curl',
        ];

        asort($constants);

        return $constants;
    }

    /**
     * Replace the given options with the current request options.
     */
    public static function mergeHttpOptions(array $originalOptions, array ...$options): array
    {
        return array_replace_recursive(
            array_merge_recursive($originalOptions, Arr::only($options, [
                RequestOptions::COOKIES,
                RequestOptions::FORM_PARAMS,
                RequestOptions::HEADERS,
                RequestOptions::JSON,
                RequestOptions::MULTIPART,
                RequestOptions::QUERY,
            ])),
            ...$options
        );
    }

    /**
     * @param array<string, scalar> $agents
     */
    public static function userAgent(array $agents = []): string
    {
        $defaults = [];

        if (class_exists(InstalledVersions::class)) {
            $defaults['notify'] = InstalledVersions::getPrettyVersion('guanguans/notify');
            $defaults['guzzle'] = InstalledVersions::getPrettyVersion('guzzlehttp/guzzle');
        }

        if (\function_exists('curl_version')) {
            $defaults['curl'] = (curl_version() ?: ['version' => 'unknown'])['version'];
        }

        if (\defined('PHP_VERSION')) {
            $defaults['PHP'] = PHP_VERSION;
        }

        if (\defined('HHVM_VERSION')) {
            /** @noinspection PhpUndefinedConstantInspection */
            $defaults['HHVM'] = HHVM_VERSION;
        }

        if (\function_exists('php_uname')) {
            $defaults['OS'] = sprintf('%s(%s)', php_uname('s'), php_uname('r'));
        }

        $defaults = array_merge($defaults, $agents);

        return trim(implode(' ', array_map(
            static fn ($value, string $name): string => "$name/$value",
            $defaults,
            array_keys($defaults)
        )));
    }
}
