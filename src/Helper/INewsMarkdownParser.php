<?php

namespace Helper;

use Model\User;
use dflydev\markdown\MarkdownExtraParser;

class INewsMarkdownParser extends MarkdownExtraParser
{
    public function __construct(array $configure = null)
    {
        $this->document_gamut += array(
            "parserUser" => 0,
            'parserUrl'  => 0,
        );

        parent::__construct($configure);
    }

    public function parserUser($text)
    {
        return preg_replace_callback('{
                (?<!\[)
                    @([\w]{1,20})
                (?!\])
            }xs', function ($match) {
            if ($user = User::dispense()->where('name', $match[1])->find_one()) {
                return '[' . $match[0] . '](/u/' . $user->id . ')';
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