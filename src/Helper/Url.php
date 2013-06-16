<?php

namespace Helper;


class Url
{
    public static function parseEmbed($url)
    {
        $embed = array();
        if (preg_match('/http:\/\/v.youku.com\/v_show\/id_([a-zA-Z0-9]+).html/', $url, $m)) {
            $embed = array(
                'type' => 'swf',
                'url'  => 'http://player.youku.com/player.php/sid/' . $m[1] . '/v.swf'
            );
        }

        $embed['html'] = self::parseEmbedHtml($embed);
        return $embed;
    }

    public static function parseEmbedHtml($embed)
    {
        if (!$embed) return;

        switch ($embed['type']) {
            case 'swf':
                return '<embed src="' . $embed['url'] . '" allowFullScreen="true" quality="high" width="610" height="400" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" wmode="transparent"></embed>';
                break;
        }

        return '';
    }
}
