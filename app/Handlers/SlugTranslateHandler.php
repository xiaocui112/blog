<?php

namespace App\Handlers;

use GuzzleHttp\Client;
use Overtrue\Pinyin\Pinyin;
use Illuminate\Support\Str;

class SlugTranslateHandler
{
    /**
     * 翻译 中文拼音
     *
     * @param string $text
     * @return string
     */
    public function translate(string $text): string
    {
        return $this->pinyin($text);
    }
    /**
     * 翻译中文
     *
     * @param string $text
     * @return string
     */
    public function pinyin(string $text): string
    {
        return Str::slug(app(Pinyin::class)->permalink($text));
    }
}
