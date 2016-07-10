<?php

namespace Wookieb\Conditions;


use Wookieb\StaticInstancesPool;
use Wookieb\DateUnits as Unit;

class Conditions extends StaticInstancesPool
{
    protected static $instances = [];

    /**
     * Produces "days ago" if diff is between 0 and 59 seconds to the past
     *
     * @return ConditionInterface
     */

    public static function secondsAgo()
    {
        return self::getOrCreate('seconds-ago', function () {
            return RangeCondition::createForNegativeValues(0, Unit::MINUTE - 1, [Results::class, 'calculateSecondsAgo']);
        });
    }

    /**
     * Produces "days ago" if diff is between 60 and 3599 seconds to the past
     *
     * @return ConditionInterface
     */
    public static function minutesAgo()
    {
        return self::getOrCreate('minutes-ago', function () {
            return R::createForNegativeValues(Unit::MINUTE, Unit::HOUR - 1, [Results::class, 'calculateMinutesAgo']);
        });
    }

    /**
     * Produces "days ago" if diff is between 60 minutes and 24 hours to the past
     *
     * @return ConditionInterface
     */
    public static function hoursAgo()
    {
        return self::getOrCreate('hours-ago', function () {
            return RangeCondition::createForNegativeValues(Unit::HOUR, Unit::DAY - 1, [Results::class, 'calculateHoursAgo']);
        });
    }

    /**
     * @see YesterdayCondition
     * @return YesterdayCondition
     */
    public static function yesterday()
    {
        return self::getOrCreate('yesterday', function () {
            return new YesterdayCondition();
        });
    }

    /**
     * Produces "days ago" if diff is between 24 and 7 days to the past
     *
     * @return ConditionInterface
     */
    public static function daysAgo()
    {
        return self::getOrCreate('days-ago', function () {
            return RangeCondition::createForNegativeValues(Unit::DAY, Unit::DAY * 7 - 1, [Results::class, 'calculateDaysAgo']);
        });
    }

    /**
     * Produces "weeks ago" if diff is between 7 and 30 days to the past
     *
     * @return ConditionInterface
     */
    public static function weeksAgo()
    {
        return self::getOrCreate('weeks-ago', function () {
            return RangeCondition::createForNegativeValues(Unit::WEEK, 30 * Unit::DAY - 1, [Results::class, 'calculateWeeksAgo']);
        });
    }

    /**
     * Produces "months ago" if diff is between 30 and 365 days to the past
     *
     * @return ConditionInterface
     */
    public static function monthsAgo()
    {
        return self::getOrCreate('months-ago', function () {
            return RangeCondition::createForNegativeValues(30 * Unit::DAY, Unit::YEAR - 1, [Results::class, 'calculateMonthsAgo']);
        });
    }

    /**
     * Produces "years ago" if diff bigger than 365 days to the past
     *
     * @return ConditionInterface
     */
    public static function yearsAgo()
    {
        return self::getOrCreate('years-ago', function () {
            return RangeCondition::createForNegativeValues(365 * Unit::DAY, INF, [Results::class, 'calculateYearsAgo']);
        });
    }
}