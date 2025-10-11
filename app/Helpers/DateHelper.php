<?php

use Alkoumi\LaravelHijriDate\Hijri;
use Carbon\Carbon;

if (!function_exists('toHijri')) {
    function toHijri($date, $format = 'd F Y هـ')
    {
        if (!$date) {
            return 'لا يوجد';
        }
        $carbonDate = Carbon::parse($date, 'UTC')->setTimezone('Asia/Riyadh');

        return Hijri::Date($format, $carbonDate);
    }
}

if (!function_exists('toHijriWithTime')) {
    function toHijriWithTime($date, $format = 'd F Y هـ - h:i A')
    {
        if (!$date) {
            return 'لا يوجد';
        }
        $carbonDate = Carbon::parse($date, 'UTC')->setTimezone('Asia/Riyadh');


        return Hijri::Date($format, $carbonDate);
    }
}
