<?php

namespace Helper;

use Model\User;
use dflydev\markdown\MarkdownExtraParser;

class INewsMarkdownParser extends MarkdownExtraParser
{
    public function __construct(array $configure = null)
    {
        $this->block_gamut += array(
            "parserUser" => 100,
            'parserUrl'  => 0,
        );

        $this->span_gamut += array(
            'parserNewLine' => 0,
        );

        parent::__construct($configure);
    }

    public function parserNewLine($text)
    {
        return preg_replace_callback('/\n/',
            array(&$this, '_doHardBreaks_callback'), $text);
    }

    public function parserUser($text)
    {
        return preg_replace_callback('{
                (?<!(?:\[|`))\s
                    @([\w]{1,20})
                \s(?!(?:\]|`))
            }xs', function ($match) {
            if ($user = User::dispense()->where('name', $match[1])->find_one()) {
                return '<a href="/u/' . $user->id . '">' . trim($match[0]) . '</a>';
            }
        }, $text);
    }

    public function parserUrl($text)
    {
        return preg_replace_callback("{
                (?<!\(|\"|')
                    ((http|https|ftp)://(\S*?\.\S*?))(\s|\;|\)|\]|\[|\{|\}|,|\"|'|:|\<|$|\.\s)
                (?!\)|\"|')
            }xs",
            function ($match) {
                if (strpos($match[1], $_SERVER['HTTP_HOST'])) {
                    return '[' . $match[1] . '](' . $match[1] . ')';
                } else {
                    return '<a href="' . $match[1] . '" target="_blank">' . $match[1] . '</a>';
                }
            }, $text);
    }
}