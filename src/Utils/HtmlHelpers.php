<?php


namespace fvy\Korus\Utils;


class HtmlHelpers
{
    public static function rawHtml(string $str): string
    {
        return htmlspecialchars_decode(stripslashes($str));
    }

    public static function textOnly(string $str): string
    {
        return htmlspecialchars_decode(strip_tags($str));
    }
}