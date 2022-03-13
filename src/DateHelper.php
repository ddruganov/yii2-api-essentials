<?php

namespace ddruganov\Yii2ApiEssentials;

use DateTime;

final class DateHelper
{
    public const DATE_FORMAT = 'Y-m-d';
    public const TIME_FORMAT = 'H:i:s';
    public const DATETIME_FORMAT = self::DATE_FORMAT . ' ' . self::TIME_FORMAT;

    public static function now(?string $format = self::DATETIME_FORMAT)
    {
        return $format ? self::formatTimestamp($format, time()) : time();
    }

    public static function nowd()
    {
        return self::now(self::DATE_FORMAT);
    }

    public static function atom()
    {
        return self::now(DateTime::ATOM);
    }

    public static function epochStart(string $format = self::DATETIME_FORMAT)
    {
        return self::formatTimestamp($format, 0);
    }

    public static function epochEnd(string $format = self::DATETIME_FORMAT)
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
