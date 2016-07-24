<?php

namespace Wookieb\RelativeDate;

class DateUnits
{
    const MINUTE = 60;
    const HOUR = self::MINUTE * 60;
    const DAY = self::HOUR * 24;
    const WEEK = self::DAY * 7;
    const YEAR = self::DAY * 365;
}