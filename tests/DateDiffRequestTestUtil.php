<?php

namespace Wookieb\Tests;


use Wookieb\DateDiffRequest;

class DateDiffRequestTestUtil
{
    public static function createForSeconds($seconds)
    {
        $interval = new \DateInterval('PT'.abs($seconds).'S');
        if ($seconds < 0) {
            $interval->invert = true;
        }

        $baseDate = new \DateTimeImmutable('2015-01-01 00:00:00');
        return new DateDiffRequest($baseDate->add($interval), $baseDate);
    }
}