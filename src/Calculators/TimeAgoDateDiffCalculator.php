<?php

namespace Wookieb\Calculators;


use Wookieb\Conditions\Conditions;
use Wookieb\Conditions\RangeCondition;
use Wookieb\Conditions\YesterdayCondition;
use Wookieb\DateDiffCalculator;
use Wookieb\DateDiffRequest;
use Wookieb\DateDiffResult;
use Wookieb\DateUnits;
use Wookieb\StaticInstancesPool;

class TimeAgoDateDiffCalculator extends StaticInstancesPool
{
    protected static $instances = [];

    /**
     * DateDiffCalculator that calculates diff to the past in one of the units:
     * - seconds
     * - minutes
     * - hours
     * - days
     * - weeks
     * - months
     * - years
     * @return DateDiffCalculator
     */
    public static function full()
    {
        return self::getOrCreate('full', function () {
            return new DateDiffCalculator([
                Conditions::secondsAgo(),
                Conditions::minutesAgo(),
                Conditions::hoursAgo(),
                Conditions::daysAgo(),
                Conditions::weeksAgo(),
                Conditions::monthsAgo(),
                Conditions::yearsAgo()
            ]);
        });
    }

    /**
     * DateDiffCalculator that calculates diff to the past in one of the units:
     * - seconds
     * - minutes
     * - "yesterday"
     * - hours
     * - days
     * - weeks (up to 14 days)
     * - full date
     *
     * @see YesterdayCondition
     * @return DateDiffCalculator
     */
    public static function upTo2Weeks()
    {
        return self::getOrCreate('up-to-2-weeks', function () {
            return new DateDiffCalculator([
                Conditions::secondsAgo(),
                Conditions::minutesAgo(),
                Conditions::yesterday(),
                Conditions::hoursAgo(),
                Conditions::daysAgo(),
                new RangeCondition(10 * DateUnits::DAY, INF, function (DateDiffRequest $request) {
                    return DateDiffResult::createFullDate($request);
                }),
                Conditions::weeksAgo()
            ]);
        });
    }

    /**
     * DateDiffCalculator that calculates diff to the past in one of the units:
     * - seconds
     * - minutes
     * - "yesterday"
     * - hours
     * - full date
     */
    public static function upTo2Days()
    {
        return self::getOrCreate('up-to-2-days', function () {
            return new DateDiffCalculator([
                Conditions::secondsAgo(),
                Conditions::minutesAgo(),
                Conditions::yesterday(),
                Conditions::hoursAgo()
            ]);
        });
    }

}