<?php

namespace Wookieb\RelativeDate\Calculators;


use Wookieb\RelativeDate\Rules\Rules;
use Wookieb\RelativeDate\Rules\RangeRule;
use Wookieb\RelativeDate\DateDiffCalculator;
use Wookieb\RelativeDate\DateDiffRequest;
use Wookieb\RelativeDate\DateDiffResult;
use Wookieb\RelativeDate\DateUnits;
use Wookieb\RelativeDate\StaticInstancesPool;

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
                Rules::secondsAgo(),
                Rules::minutesAgo(),
                Rules::hoursAgo(),
                Rules::daysAgo(),
                Rules::weeksAgo(),
                Rules::monthsAgo(),
                Rules::yearsAgo()
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
                Rules::secondsAgo(),
                Rules::minutesAgo(),
                Rules::yesterday(),
                Rules::hoursAgo(),
                Rules::daysAgo(),
                new RangeRule(10 * DateUnits::DAY, INF, function (DateDiffRequest $request) {
                    return DateDiffResult::createFullDate($request);
                }),
                Rules::weeksAgo()
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
                Rules::secondsAgo(),
                Rules::minutesAgo(),
                Rules::yesterday(),
                Rules::hoursAgo()
            ]);
        });
    }

}