<?php

namespace Wookieb\RelativeDate\Calculators;


use Wookieb\RelativeDate\Rules\Rules;
use Wookieb\RelativeDate\Rules\RangeRule;
use Wookieb\RelativeDate\DateDiffCalculator;
use Wookieb\RelativeDate\DateDiffRequest;
use Wookieb\RelativeDate\DateDiffResult;
use Wookieb\RelativeDate\DateUnits;
use Wookieb\RelativeDate\StaticInstancesPool;

class TimeAgoCalculator extends StaticInstancesPool
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
     *
     * @return DateDiffCalculator
     */
    public static function full()
    {
        return self::getOrCreate('full', function () {
            return new DateDiffCalculator([
                Rules::yearsAgo(),
                Rules::monthsAgo(),
                Rules::weeksAgo(),
                Rules::daysAgo(),
                Rules::hoursAgo(),
                Rules::minutesAgo(),
                Rules::secondsAgo()
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
     * @return DateDiffCalculator
     */
    public static function upTo2Weeks()
    {
        return self::getOrCreate('up-to-2-weeks', function () {
            return new DateDiffCalculator([
                RangeRule::createForNegativeValues(2 * DateUnits::WEEK, INF, function (DateDiffRequest $request) {
                    return DateDiffResult::createFullDate($request);
                }),
                Rules::weeksAgo(),
                Rules::yesterday(),
                Rules::daysAgo(),
                Rules::hoursAgo(),
                Rules::minutesAgo(),
                Rules::secondsAgo()
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
     *
     * @return DateDiffCalculator
     */
    public static function upTo2Days()
    {
        return self::getOrCreate('up-to-2-days', function () {
            return new DateDiffCalculator([
                Rules::yesterday(),
                Rules::hoursAgo(),
                Rules::minutesAgo(),
                Rules::secondsAgo()
            ]);
        });
    }
}