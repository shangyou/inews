<?php

namespace Helper;

use dflydev\markdown\MarkdownExtraParser;
use Voodoo\Paginator;

class Html
{
    public static function fromMarkdown($text)
    {
        static $markdown;

        if ($markdown === null) {
            $markdown = new INewsMarkdownParser();
        }

        return $markdown->transformMarkdown($text);
    }

    public static function makePage($path, $pattern, $page, $total, $limit = 20)
    {
        $paginator = new Paginator($path, $pattern);
        return $paginator->setTotalItems($total)
            ->setItemsPerPage($limit)
            ->setNavigationSize(9)
            ->setCurrentPage($page)
            ->render();
    }

    public static function gravatar($email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array())
    {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        if ($img) {
            $url = '<img src="' . $url . '"';
            foreach ($atts as $key => $val)
                $url .= ' ' . $key . '="' . $val . '"';
            $url .= ' />';
        }
        return $url;
    }
}