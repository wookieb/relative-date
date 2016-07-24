<?php

namespace Wookieb\RelativeDate\Rules;


use Wookieb\RelativeDate\DateDiffRequest;
use Wookieb\RelativeDate\DateDiffResult;

use Wookieb\RelativeDate\DateUnits as Unit;

class Results
{
    const SECONDS_AGO = '[X] seconds ago';
    const MINUTES_AGO = '[X] minutes ago';
    const HOURS_AGO = '[X] hours ago';
    const DAYS_AGO = '[X] days ago';
    const WEEKS_AGO = '[X] weeks ago';
    const MONTHS_AGO = '[X] months ago';
    const YEARS_AGO = '[X] years ago';

    /**
     * Returns "seconds ago" result with absolute diff in seconds
     *
     * @param DateDiffRequest $request
     * @return DateDiffResult
     */
    public static function calculateSecondsAgo(DateDiffRequest $request)
    {
        return new DateDiffResult($request, self::SECONDS_AGO, abs($request->getDiffInSeconds()));
    }

    /**
     * Returns "minutes ago" result with absolute diff in minutes
     *
     * @param DateDiffRequest $request
     * @return DateDiffResult
     */
    public static function calculateMinutesAgo(DateDiffRequest $request)
    {
        return new DateDiffResult($request, self::MINUTES_AGO, (int)floor(abs($request->getDiffInSeconds()) / Unit::MINUTE));
    }

    /**
     * Returns "hours ago" result with absolute diff in hours
     *
     * @param DateDiffRequest $request
     * @return DateDiffResult
     */
    public static function calculateHoursAgo(DateDiffRequest $request)
    {
        return new DateDiffResult($request, self::HOURS_AGO, (int)floor(abs($request->getDiffInSeconds()) / Unit::HOUR));
    }

    /**
     * Returns "days ago" result with absolute diff in days
     *
     * @param DateDiffRequest $request
     * @return DateDiffResult
     */
    public static function calculateDaysAgo(DateDiffRequest $request)
    {
        return new DateDiffResult($request, self::DAYS_AGO, $request->getInterval()->days);
    }

    /**
     * Returns "weeks ago" result with absolute diff in weeks
     *
     * @param DateDiffRequest $request
     * @return DateDiffResult
     */
    public static function calculateWeeksAgo(DateDiffRequest $request)
    {
        return new DateDiffResult($request, self::WEEKS_AGO, (int)floor($request->getInterval()->days / 7));
    }

    /**
     * Returns "months ago" result with absolute diff in calendar months
     * @param DateDiffRequest $request
     * @return DateDiffResult
     */
    public static function calculateMonthsAgo(DateDiffRequest $request)
    {
        return new DateDiffResult($request, self::MONTHS_AGO, abs($request->getCalendarMonths()));
    }

    /**
     * Returns "years ago" result with absolute diff in calendar years
     *
     * @param DateDiffRequest $request
     * @return DateDiffResult
     */
    public static function calculateYearsAgo(DateDiffRequest $request)
    {
        return new DateDiffResult($request, self::YEARS_AGO, $request->getInterval()->y);
    }

    public static function createFullDate(DateDiffRequest $request)
    {
        return DateDiffResult::createFullDate($request);
    }
}