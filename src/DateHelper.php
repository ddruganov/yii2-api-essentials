<?php

namespace ddruganov\Yii2ApiEssentials;

use DateTime;

class DateHelper
{
    public const DEFAULT_FORMAT = 'Y-m-d H:i:s';

    public static function now(?string $format = static::DEFAULT_FORMAT)
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

    public static function epochStart(string $format = static::DEFAULT_FORMAT)
    {
        return self::formatTimestamp($format, 0);
    }

    public static function epochEnd(string $format = static::DEFAULT_FORMAT)
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
