<?php

namespace ddruganov\Yii2ApiEssentials;

use DateTime;

class DateHelper
{
    public static function now(?string $format = 'Y-m-d H:i:s')
    {
        return $format ? self::formatTimestamp($format, time()) : time();
    }

    public static function nowd()
    {
        return self::now('Y-m-d');
    }

    public static function atom()
    {
        return self::now(DateTime::ATOM);
    }

    public static function epochStart(string $format = 'Y-m-d H:i:s')
    {
        return self::formatTimestamp($format, 0);
    }

    public static function epochEnd(string $format = 'Y-m-d H:i:s')
    {
        return self::formatTimestamp($format, 2147483647);
    }

    public static function formatTimestamp(string $format, int $timestamp)
    {
        return date($format, $timestamp);
    }

    public static function changeFormat(?string $value, string $from, string $to): string
    {
        $dateTime = DateTime::createFromFormat($from, $value);
        return $dateTime ? $dateTime->format($to) : '';
    }
}
